<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Users extends CI_Model {
	public function get_usuario($nome,$senha) {
		$this->db->get('cad_user');
		$this->db->where('nome',$nome);
		$this->db->where('senha',$senha);
		$querylogin = $this->db->get('cad_user');
		return $querylogin->row(0);
	}

	public function login($options = array()) {
		$nome = $this->get_usuario($options['nome'],$options['senha']);
		if(!$nome) return false;
		return true;
	}

	public function alterarSenha($senha = null,$codigo_user = null) /*Pensado para somente um usuário*/
	{
        $this->db->where('id_cad_users', $codigo_user);
		$this->db->update('cad_user',$senha);
            
		return true;
	}

    public function cadastrar($dados=null){
        if($dados!=null){
            if($this->db->insert('cad_user',$dados)){
            $this->session->set_flashdata('cadastro_ok','<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button><p>Cadastro efetuado com sucesso</p></div>');
            }else{
            $this->session->set_flashdata('cadastro_ok','<div class="alert alert-block alert-error"><button type="button" class="close" data-dismiss="alert">x</button><p>Cadastro não efetuado</p></div>');
            }
            redirect('usuarios/cadastrar');
        }
    }

    public function inativar($codigo_user=null, $dados=null)
    {
        $this->db->where('id_cad_users', $codigo_user);
        $this->db->update('cad_user',$dados);
        return true;
    }

    public function get_all()
    {
    	return $this->db->get('cad_user');
    }

    public function get_ById($codigo_user=null)
    {
    	if ($codigo_user != null) {
    		$this->db->where('id_cad_users',$codigo_user);
    		$this->db->limit(1);
    		return $this->db->get('cad_user');
    	}else{
    		return false;
    	}
    }
    
    public function get_ByNome($nome_usuario='')
    {
        if ($nome_usuario != null) {
            $this->db->where('nome',$nome_usuario);
            $this->db->limit(1);
            return $this->db->get('cad_user')->row();
        }else{
            return false;
        }
    }

    public function tipousuario(){
        $tipousuario = $this->db->query('select * from grupo_user order by nome_grupo');
        return $tipousuario->result();
    }

    public function permissaousuario($grupo=null){
        $permitido = $this->db->query('select nome_grupo from grupo_user where id_grupo_user ='.$grupo);
        return $permitido;
    }
    
    public function idgrupopermissao($grupo=null){
        $permitido = $this->db->query('select id_grupo_user from grupo_user where id_grupo_user ='.$grupo);
        return $permitido;
    }

    public function grupopermissao(){
        $grupo = $this->db->query('select * from grupo_user');
        return $grupo->result();
    }

    public function aplicacoes(){
        $aplicacao = $this->db->query('select * from aplicacoes order by id_aplicacao');
        return $aplicacao->result();
    }

    public function addAppAoGrupo($dados = null){ /*Adiciona aplicação ao grupo*/
            return $this->db->insert('grupo_x_aplicacao',$dados);
    }

    public function remAppDoGrupo($dados = null){ /*Remove aplicação do grupo*/
            $this->db->where('id_aplicacao',$dados['id_aplicacao']);
            $this->db->where('id_grupo',$dados['id_grupo']);
            return $this->db->delete('grupo_x_aplicacao',$dados);
    }

    public function manipularbotoes($aplicacao=null,$grupo=null){
        $resultado = $this->db->query('select * from grupo_x_aplicacao where id_grupo ='.$grupo.' and id_aplicacao ='.$aplicacao);
        return $resultado->row();
    }

    public function ver_acesso($acesso=null){
        $sql = 'select ga.id_aplicacao, ga.id_grupo from grupo_x_aplicacao ga
        left join aplicacoes a on a.id_aplicacao = ga.id_aplicacao
        where a.nome_aplicacao = \''.$acesso.'\' and ga.id_grupo ='.$this->session->userdata('user_group');

        $aplicacoes = $this->db->query($sql);

        if ($aplicacoes->num_rows()>0){
            return true;
        }else{
            $dados = array(
            'titulo' => 'Acesso Negado',
            'tela' => 'erros/acesso_negado'
        );
        $this->load->view('index', $dados);
        }
    }

    public function unid_login($cnes=null){
        $check = $this->db->query("select distinct(id_unidade) from unidade where cnes_unidade= '".$cnes."'");
        return $check->result();

    }

}
