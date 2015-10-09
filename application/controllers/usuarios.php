<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MY_Controller {
	
	function __construct() {
		parent::__construct();
        /*if($this->session->userdata('user_group')!=1){
            redirect('seguranca/acesso_negado');
        }*/
	}

   public function cadastrar(){
        if($this->model_users->ver_acesso($this->uri->segment(2))) {
            if($this->session->userdata('user_group')==1){
                $this->form_validation->set_rules('nome','Nome do Usuario','trim|required|max_length[50]');
                $this->form_validation->set_rules('senha','Senha do Usuario','trim|required|max_length[50]|matches[senha2]|md5');
                $this->form_validation->set_rules('id_grupo_user','Grupo do Usuario','trim|required');
                $this->form_validation->set_rules('id_regiao','Regiao','trim');
                $this->form_validation->set_rules('cnes','Unidade','trim');
                
                if($this->form_validation->run()==TRUE){
                    
                    switch($this->input->post('id_grupo_user')){
                        case 3: $data = elements(array('id_grupo_user','nome','senha','cnes'),$this->input->post());break;
                        case 4: $data = elements(array('id_grupo_user','nome','senha','id_regiao'),$this->input->post());break;
                        default: $data = elements(array('id_grupo_user','nome','senha'),$this->input->post());break;
                    }

                    $this->model_users->cadastrar($data);
                }

                $dados = array(
                    'titulo' => 'Cadastrar Usuários',
                    'tela' => 'usuarios/cadastrar',
                    'unidades' => $this->model_ubs->retorna_ubs(),
                    'tipousuario' => $this->model_users->tipousuario(),
                    'regioes' => $this->model_ubs->retorna_regioes());

                $this->load->view('index', $dados);

            }else{
                redirect('seguranca/acesso_negado');
            }
        }
    }

    public function consultar(){
        if($this->model_users->ver_acesso($this->uri->segment(2))) {
            $usuarios = $this->model_users->get_all();
            $dados = array(
                'titulo' => 'Consultar/Alterar Usuário',
                'tela' => 'usuarios/consultar',
                'usuarios' => $usuarios
                );
            $this->load->view('index',$dados);
        }
    }

    public function editar(){
        if($this->model_users->ver_acesso($this->uri->segment(2))) {
            $codigo_user = $this->uri->segment(3);
            $this->form_validation->set_rules('senha','Senha do Usuario','trim|max_length[50]');
            $this->form_validation->set_rules('cnes','Unidade','trim');

            if($this->form_validation->run()){
                $nome = $this->input->post('nome');
                
                    if($this->input->post('cnes') != ''){
                        $cnes = $this->input->post('cnes');
                        $regiao = null;

                    }else{

                        $cnes = null;
                        $regiao = $this->input->post('id_regiao');

                    }
                
                    $this->form_validation->set_rules('senha', 'Nova Senha', 'matches[conf_new_senha]');
                    $this->form_validation->set_rules('conf_new_senha', 'Confirmação');
                    $this->form_validation->set_rules('cnes', 'Unidade', 'trim');

                    if($this->form_validation->run()) {
                        if ($this->input->post('senha')!=null){
                            $senha = array ('senha' => md5($this->input->post('senha')),'cnes' => $cnes,'id_regiao' => $regiao, 'id_grupo_user' => $this->input->post('id_grupo_user'));
                        }else{
                            $senha = array ('cnes' => $cnes,'id_regiao' => $regiao, 'id_grupo_user' => $this->input->post('id_grupo_user'));    
                        }
                        $this->session->set_flashdata('excluirok','Usuario alterado com sucesso!');
                        $this->model_users->alterarSenha($senha,$codigo_user);
                        redirect('usuarios/consultar');
                    }

            }

            $usuario = $this->model_users->get_ById($codigo_user);
            if ($usuario == null) {
                redirect('usuarios/consultar');
            }
            $dados = array(
                'titulo' => 'Editar Usuário',
                'tela' => 'usuarios/edit',
                'usuario' => $usuario,
                'unidades' => $this->model_ubs->retorna_ubs(),
                'tipousuario' => $this->model_users->tipousuario(),
                'regioes' => $this->model_ubs->retorna_regioes()
                );
            $this->load->view('index',$dados);
        }
    }

    public function deletar()
    {
        if($this->model_users->ver_acesso($this->uri->segment(2))) {
            $codigo_user = $this->uri->segment(3);
            if ($codigo_user != null) {
                $inativar = array('ativo' => 'false');
                if ($this->model_users->inativar($codigo_user, $inativar)){
                    $this->session->set_flashdata('excluirok','Usuario excluido com sucesso!');
                    redirect('usuarios/consultar');
                }
            }
        }
    }
    
    public function filtro_permissao(){
        if($this->model_users->ver_acesso($this->uri->segment(2))) {
            $id_grupo = $this->model_users->tipousuario($this->input->post('group_user'));

                 $dados = array(
                        'titulo' => 'Filtro para Permissão de Acesso',
                        'tela' => 'usuarios/filtro_permissao',
                        'grupo_user' => $id_grupo
                        );

             $this->load->view('index', $dados);
        }
    }


    public function permissao(){
        //if($this->model_users->ver_acesso($this->uri->segment(2))) {
            if($this->session->userdata('user_group')==1){
                $dados= array(
                    'titulo' => 'Permissão de Acesso',
                    'tela' => 'usuarios/permissao',
                    'id_grupo' => $this->model_users->idgrupopermissao($this->input->post('grupo_user')),
                    'nome_grupo' => $this->model_users->permissaousuario($this->input->post('grupo_user')),
                    'aplicacoes' => $this->model_users->aplicacoes(),
                    'grupousuario' => $this->model_users->grupopermissao()
                );

            }
            $this->load->view('index',$dados);
        //}
    }

    public function adicionarAppAoGrupo(){

        $renomeado = str_replace("_", " ", $this->uri->segment(6)); /*Tirar os _ dos nomes e insere espaço*/

        $this->session->set_userdata('aviso','Aplicação: '.ucfirst($renomeado).' adicionada ao grupo com sucesso.');
        $this->session->set_userdata('tipo','success');
        $this->session->set_userdata('grupoASerEditado',$this->uri->segment(5)); /*Saber ID que está sendo editado*/

        $dados = array (
            'id_aplicacao' => $this->uri->segment(3),
            'id_grupo' => $this->uri->segment(4)
            );

        $dados2 = array(
                'titulo' => 'Permissão de Acesso',
                'tela' => 'usuarios/permissao',
                'id_grupo' => $this->model_users->idgrupopermissao($this->uri->segment(4)),
                'nome_grupo' => $this->model_users->permissaousuario($this->uri->segment(4)),
                'aplicacoes' => $this->model_users->aplicacoes(),
                'grupousuario' => $this->model_users->grupopermissao()

            );

        $this->model_users->addAppAoGrupo($dados);
        
        $this->session->set_flashdata('grupo_user',$this->input->post('grupo_user'));

        $this->load->view('index',$dados2);
    }

    /*LEGENDA PARA SEGMENT DAS FUNÇÕES: REMOVER DO GRUPO E ADICIONAR AO GRUPO
    3 = NÚMERO DA APLICAÇÃO, USADO PARA ADICIONAR/REMOVER A TABELA DE RELACIONAMENTO
    4 = NÚMERO DO GRUPO, USADO PARA ADICIONAR/REMOVER A TABELA DE RELACIONAMENTO
    5 = NOME DO GRUPO, USADO PARA EXIBIR MENSAGEM PÓS INSERT OU DELETE
    6 = NOME DA APLICAÇÃO, USADO PARA QUANDO FOR RECARREGAR A TELA SABER QUAL APLICAÇÃO ERA.*/

    public function removerAppDoGrupo(){
            
        $renomeado = str_replace("_", " ", $this->uri->segment(6)); /*Tirar os _ dos nomes e insere espaço*/

        $this->session->set_userdata('aviso','Aplicação: '.ucfirst($renomeado).' removida do grupo com sucesso.');
        $this->session->set_userdata('tipo','success');
        $this->session->set_userdata('grupoASerEditado',$this->uri->segment(5)); /*Saber ID que está sendo editado*/

        $dados = array (
            'id_aplicacao' => $this->uri->segment(3),
            'id_grupo' => $this->uri->segment(4)
            );
        
        $dados2 = array(
                'titulo' => 'Permissão de Acesso',
                'tela' => 'usuarios/permissao',
                'id_grupo' => $this->model_users->idgrupopermissao($this->uri->segment(4)),
                'nome_grupo' => $this->model_users->permissaousuario($this->uri->segment(4)),
                'aplicacoes' => $this->model_users->aplicacoes(),
                'grupousuario' => $this->model_users->grupopermissao()
            );

        $this->model_users->remAppDoGrupo($dados);

        $this->session->set_flashdata('grupo_user',$this->input->post('grupo_user'));

        $this->load->view('index',$dados2);
        
    }

    

}
