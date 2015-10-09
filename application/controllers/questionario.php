<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Questionario extends MY_Controller {

	function __construct() {
		parent::__construct();		
	}

	public function iniciar()
	{
		//if($this->model_users->ver_acesso($this->uri->segment(2))) { //validar o acesso as telas por grupo de usuário
            if ($this->session->userdata('user_group') == 1 || $this->session->userdata('user_group') == 2){
	            $ubs = $this->model_ubs->retorna_ubs();
	            $option = "<option value=''></option>";
	            
		            foreach ($ubs as $linha) {
		               $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
		            }

	            $dados = array(
	                'titulo' => 'Responder as Dimensões',
	                'tela' => 'questionario/iniciar',
	                'unidades' => $option
	            );
	            $this->load->view('index', $dados);

	        }else if($this->session->userdata('user_group') == 4){

	            $ubs = $this->model_ubs->retorna_ubs_byregiao($this->session->userdata('id_regiao'))->result();
	            
	            $option = "<option value=''></option>";
	            
		            foreach ($ubs as $linha) {
		               $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
		            }

	            $dados = array(
	                'titulo' => 'Responder as Dimensões',
	                'tela' => 'questionario/iniciar',
	                'unidades' => $option
	            );
	            $this->load->view('index', $dados);

	        }else{
				$ubs = $this->model_ubs->retorna_ubs();
					$option = 0;	            
		            foreach ($ubs as $linha) {
		               if($linha->cnes_unidade == $this->session->userdata('cnes')){
		               	$option = $linha->cnes_unidade;
		               }
		            }

	            $dados = array(
	                'titulo' => 'Responder as Dimensões',
	                'tela' => 'questionario/escolher_dimensao',
	                'unidades' => $option
	            );

	        	$this->load->view('index', $dados);
        	}//fim do if dos grupos do sistema
        //}
	}

	public function resultado()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
			if ($this->session->userdata('user_group') == 1 || $this->session->userdata('user_group') == 2){// verifica se é admin ou consultor
				$ubs = $this->model_ubs->retorna_ubs();
	            $option = "<option value=''></option>";

	            foreach ($ubs as $linha) {
	                $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
	            }//final do foreach

	            $dados = array(
	                'titulo' => 'Consultar os Resultados',
	                'tela' => 'questionario/resultado',
	                'unidades' => $option
	            );
	            $this->load->view('index', $dados);

	        }else if($this->session->userdata('user_group') == 4){

	        	$ubs = $this->model_ubs->retorna_ubs_byregiao($this->session->userdata('id_regiao'));
	            $option = "<option value=''></option>";

	            foreach ($ubs->result() as $linha) {
	                $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
	            }//final do foreach

	            $dados = array(
	                'titulo' => 'Consultar os Resultados',
	                'tela' => 'questionario/resultado',
	                'unidades' => $option
	            );
	            $this->load->view('index', $dados);

	        }else{
	        	
	        	$info = array('responsavel' => $this->session->userdata('nome'), 
	        		          'unidades' => $unidades->row()->id_unidade);
	            $option = $info;

	            $dados = array(
	                'titulo' => 'Consultar os Resultados',
	                'tela' => 'relatorios/consultar_resultados',
	                'unidade' => $option
	            );
	            $this->load->view('index', $dados);

	        }
        } //final do if de verficação de permissão

	}//final da function


	public function dimensao()
	{
		if ($this->session->userdata('user_group') == 1 || $this->session->userdata('user_group') == 2){// verifica se é admin ou consultor
			$this->form_validation->set_rules('responsavel','Responsavel','trim|required|max_length[50]');
			$this->form_validation->set_rules('unidade','UBS','trim|required|max_length[50]|integer');

			if ($this->form_validation->run() == TRUE) {

				$info = array('responsavel' => $this->input->post('responsavel'), 'unidade' => $this->input->post('unidade'));
				$this->session->set_userdata($info);
				$id = $this->uri->segment(3);
				if ($id == '') {
					$dados = array(
					'titulo' => 'Escolher a Dimensão',
					'tela' => 'questionario/escolher_dimensao'
					);		
					$this->load->view('index',$dados);
				}else{
					$_SESSION['validadion'] == $id;
		            $sub_dimensoes = $this->model_dimensoes->obter_SubDimensoes($id);
	                $responsavel = $this->session->userdata('responsavel');
					$dados = array(
		                'titulo' => 'Escolher a Sub-Dimensão',
		                'tela' => 'questionario/escolher_sub',
		                'sub_dimensoes' => $sub_dimensoes,
	                    'responsavel' => $responsavel
					);		
					$this->load->view('index',$dados);
				}

			}else{

				$id = $this->uri->segment(3);
				if ($id == '') {
					$ubs = $this->model_ubs->retorna_ubs();
					$option = "<option value=''></option>";
						foreach($ubs -> result() as $linha) {
							$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>"; 
						}
					$dados = array(
						'titulo' => 'Responder as Dimensões',
						'tela' => 'questionario/iniciar',
						'unidades' => $option
					);		
					$this->load->view('index',$dados);

				}else{

					$sub_dimensoes = $this->model_dimensoes->obter_SubDimensoes($id);
	                $responsavel = $this->session->userdata('responsavel');
					$dados = array(
		                'titulo' => 'Escolher Sub-Dimensão',
		                'tela' => 'questionario/escolher_sub',
		                'sub_dimensoes' => $sub_dimensoes,
	                    'responsavel' => $responsavel
					);		
					$this->load->view('index',$dados);
				}
			}

		}else if($this->session->userdata('user_group') == 4){

			$info = array('responsavel' => $this->session->userdata('nome'), 'unidade' => $this->input->post('unidade'));
			$this->session->set_userdata($info);
			$id = $this->uri->segment(3);

			if ($id == ''){
			$ubs = $this->model_ubs->retorna_ubs_byregiao($this->session->userdata('id_regiao'));
			$option = "<option value=''></option>";
				foreach($ubs -> result() as $linha) {
					$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>"; 
				}
			$dados = array(
				'titulo' => 'Responder as Dimensões',
				'tela' => 'questionario/escolher_dimensao',
				'unidade' => $option
			);

			$this->load->view('index',$dados);

			}else{
		            $sub_dimensoes = $this->model_dimensoes->obter_SubDimensoes($id);
	                $responsavel = $this->session->userdata('responsavel');
					$dados = array(
		                'titulo' => 'Escolher a Sub-Dimensão',
		                'tela' => 'questionario/escolher_sub',
		                'sub_dimensoes' => $sub_dimensoes,
	                    'responsavel' => $responsavel
					);		
					$this->load->view('index',$dados);

			}

		}else{

			$unidades = $this->model_ubs->retorna_ubs_cnes($this->session->userdata('cnes'));

			$info = array('responsavel' => $this->session->userdata('nome'), 'unidade' => $unidades->row()->id_unidade);
			$this->session->set_userdata($info);
			$id = $this->uri->segment(3);
				
				if ($id == '') {

					$dados = array(
					'titulo' => 'Escolher a Dimensão',
					'tela' => 'questionario/escolher_dimensao'
					);		
					$this->load->view('index',$dados);

				}else{
					
		            $sub_dimensoes = $this->model_dimensoes->obter_SubDimensoes($id);
	                $responsavel = $this->session->userdata('responsavel');
					$dados = array(
		                'titulo' => 'Escolher a Sub-Dimensão',
		                'tela' => 'questionario/escolher_sub',
		                'sub_dimensoes' => $sub_dimensoes,
	                    'responsavel' => $responsavel
					);		
					$this->load->view('index',$dados);
				}
		}		
	}

	public function sub_dimensao()
	{
		
			$id_sub = $this->uri->segment(3);
			$id_dimensao = $this->uri->segment(4);
			if ($id_sub != '' && $id_dimensao != '') {
				$perguntas = $this->model_perguntas->obterPerguntas($id_sub,$id_dimensao);
				$respostas = $this->model_perguntas->obterRespostas($id_sub,$id_dimensao);
				$id_unidade = $this->session->userdata('unidade');
				$responsavel = $this->session->userdata('responsavel');
				$dados = array(
	                'titulo' => 'Respondendo a Sub-Dimensão',
	                'tela' => 'questionario/respondendo',
	                'perguntas' => $perguntas,
	                'respostas' => $respostas,
	                'id_sub' => $id_sub,
	                'id_dimensao' => $id_dimensao,
	                'id_unidade' => $id_unidade,
	                'responsvel' => $responsavel
				);		
				$this->load->view('index',$dados);
			} else {
				
			}
			
	}

	public function salvar(){
		if ($this->session->userdata('user_group') == 1 || $this->session->userdata('user_group') == 2 || $this->session->userdata('user_group') == 4){
			$insert = array();
			$j = $this->session->userdata('num_questoes');
			for ($i=0; $i <= $j ; $i++) { 
				if (!empty($this->input->post("resposta-$i"))){
					$insert[] = array(
						'codigo_respostas'=> $this->input->post("resposta-$i"),
						'codigo_perguntas_respostas'=> $i,
						'codigo_sub_dimensao_perguntas_respostas'=> $this->input->post('id_sub'),
						'codigo_dimensao_sub_dimensao_perguntas_respostas'=> $this->input->post('id_dimensao'),
						'id_unidade_unidade' => $this->input->post('id_unidade'),
						'responsvel' =>$this->input->post('responsvel')
					);
				}
			}
			$this->model_perguntas->salvar($insert);

			redirect('/questionario/dimensao/'.$this->input->post('id_dimensao').'', 'refresh');
		
		}else{

			$insert = array();
			$j = $this->session->userdata('num_questoes');
			for ($i=0; $i <= $j ; $i++) { 
				if (!empty($this->input->post("resposta-$i"))){
					$insert[] = array(
						'codigo_respostas'=> $this->input->post("resposta-$i"),
						'codigo_perguntas_respostas'=> $i,
						'codigo_sub_dimensao_perguntas_respostas'=> $this->input->post('id_sub'),
						'codigo_dimensao_sub_dimensao_perguntas_respostas'=> $this->input->post('id_dimensao'),
						'id_unidade_unidade' => $this->model_ubs->retorna_ubs_cnes($this->session->userdata('cnes'))->row()->id_unidade,
						'responsvel' => $this->session->userdata('nome')
					);
				}
			}
			$this->model_perguntas->salvar($insert);

			redirect('/questionario/dimensao/'.$this->input->post('id_dimensao').'', 'refresh');

		}
	}

    public function consultar_respondidos(){
    	//print_r($this->uri->segment(2));
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
	        $responsavel=$this->session->userdata('nome_usuario');
	        $respondidos = $this->model_perguntas->obter_unidade_log($responsavel);
	        $dados = array (
	            'titulo' => 'Consultar Respondidos',
	            'tela' => 'questionario/consultar_respondidos.php',
	            'respondidos' => $respondidos
	        );
	        $this->load->view('index',$dados);
	    }
    }
    
}
