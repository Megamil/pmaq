<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questoes extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	// Add a new item
	public function nova()
	{
		if($this->model_users->ver_acesso('novaQuestao')) {
	       
	        $validator = (isset($_POST['validator'])) ? $_POST['validator'] : NULL ;
	       	if ($validator != NULL){
	        	$this->session->set_userdata('cadastro_ok', '<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>Não foi inserida nenhuma resposta</p></div>');
		        $this->form_validation->set_rules('codigo_pergunta', 'Codigo da Pergunta', 'trim|required|numeric');
	        	$this->form_validation->set_rules('pergunta', 'Enunciado da Pergunta', 'trim|required|min_length[5]|max_length[12]|xss_clean');
	        	$this->form_validation->set_rules('percentual_subdimensao', 'Percentual da Subdimensão', 'trim|required|numeric|decimal');
	        	$this->form_validation->set_rules('percentual_externa', 'Percentual Externo', 'trim|required|decimal');
	        	$this->form_validation->set_rules('codigo_dimensao_sub_dimensao', 'Codigo da Dimensão', 'trim|required|numeric');
	        	$this->form_validation->set_rules('codigo_sub_dimensao', 'Codigo da Sub-Dimensão', 'trim|required|numeric');
	        	
	        	if ($this->form_validation->run()==TRUE) {
	        		$pergunta = array(		
					'codigo' => $_POST["codigo_pergunta"],
					'pergunta' => $_POST["pergunta"],
					'percentual_subdimensao' => $_POST["percentual_subdimensao"],
					'percentual_externa' => $_POST["percentual_externa"],
					'codigo_sub_dimensao' => $_POST["codigo_sub_dimensao"],
					'codigo_dimensao_sub_dimensao' => $_POST["codigo_dimensao_sub_dimensao"]
					);
					
					$id_pergunta = $this->model_perguntas->adicionarQuestao($pergunta);
					if ($id_pergunta != NULL) {
						$respostas = array();
						for ($i=1; $i <= $_POST['validator']; $i++) {
							$resposta = array(
				        		"codigo" => $i,
				        		"resposta" => $_POST["resaaa$i"],
				        		"valor" => $_POST["valoraaa$i"],
				        		"consideracoes" => $_POST["consideracoesaaa$i"],
				        		"codigo_perguntas" => $_POST["codigo_pergunta"],
				        		"codigo_sub_dimensao_perguntas" => $_POST["codigo_sub_dimensao"],
				        		"codigo_dimensao_sub_dimensao_perguntas" => $_POST["codigo_dimensao_sub_dimensao"],
				        		);
								$flag_ok = $this->model_perguntas->adicionarResposta($resposta);
						}
					}
					
					if ($flag_ok == 1) {
						setcookie("resposta",'',time()*60*60*24*30);
				    	$this->session->set_userdata('resposta','');
				    	redirect('questoes/nova');
					}
					$dados = array(
			        	'titulo' => 'Pagina de Teste',
			        	'tela' => 'teste',
			        	'teste' => $respostas
			        	);
			        $this->load->view('index',$dados);

	        	}else{

		        	$resposta = Array();
		        	for ($i=1; $i <= $_POST['validator']; $i++) {
		        		if($_POST["codigoaaa$i"]){
			        		$adicionar = array(
			        		"codigoaaa" => $_POST["codigoaaa$i"],
			        		"resaaa" => $_POST["resaaa$i"],
			        		"valoraaa" => $_POST["valoraaa$i"],
			        		"consideracoesaaa" => $_POST["consideracoesaaa$i"]
			        		);
			        		$resposta[] = $adicionar;
		        		}

		        	$amazenar = serialize($resposta);
				    setcookie("resposta",$amazenar,time()*60*60*24*30);
				    $this->session->set_userdata('resposta',$amazenar);
		        	}

			        $dados = array(
			        	'titulo' => 'Cadastrar Questões',
			        	'tela' => 'questoes/novaQuestao',
			        	'resposta' => $resposta
			        	);
			        $this->load->view('index',$dados);
			    }

			}else{

				$dados = array(
			      	'titulo' => 'Cadastrar Questões',
			      	'tela' => 'questoes/novaQuestao'
			      	);
			    $this->load->view('index',$dados);
			}
		}
	}
	public function jsonNova()
	{
		//json_respostas.php
	    header('Content-Type: application/json');
    	$resposta = $this->session->userdata('resposta');
    	if ($resposta != NULL) {
    		$resposta = unserialize($resposta);
    		echo (json_encode($resposta));
    	}else{
    		$resposta = "";
    	}
	}
	public function consultar()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
			$perguntas = $this->model_perguntas->obterPerguntasAll();
			$dados = array(
			        	'titulo' => 'Consultar/Alterar Questões',
			        	'tela' => 'questoes/consultar_perguntas',
			        	'perguntas' => $perguntas
			        	);
			$this->load->view('index',$dados);
		}
	}
	public function resposta()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
			$codigos = explode('-', $this->uri->segment(3));
			if ($codigos[0] != NULL) {
				
	            $this->form_validation->set_rules('resposta', 'Resposta', 'trim|required|ucwords');
	            if ($this->form_validation->run()==TRUE) {
	            	$dados = array('resposta' => $_POST['resposta'],'valor' => $_POST['valor'],'consideracoes' => $_POST['consideracoes']);
	            	$this->model_perguntas->update_resposta($codigos[0],$codigos[1],$codigos[2],$codigos[3],$dados);
	            }
			}
		}
	}

	public function pergunta()
	{
		//if($this->model_users->ver_acesso($this->uri->segment(2))) {
			$codigos = explode('-', $this->uri->segment(3));
			if ($codigos[0] != NULL) {
	            $this->form_validation->set_rules('resposta', 'Resposta', 'trim|required|ucwords');
	            if ($this->form_validation->run()==TRUE) {
	            	if(!is_null($_POST['multipla_escolha'])){
	            		$multipla_escolha = 't';
	            	} else {
	            		$multipla_escolha = 'f';
	            	}
	            	$dados = array('pergunta' => $_POST['pergunta'],'multipla_escolha' => $multipla_escolha);
					$this->model_perguntas->update_pergunta($codigos[0],$codigos[1],$codigos[2],$dados);
	            }
			}
		//}
	}
	
	public function excluir()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
			$codigos = explode('-', $this->uri->segment(3));

			$comp = array(
				'codigo_dimensao_sub_dimensao_respostas' => $codigos[1],
				'codigo_sub_dimensao_respostas' => $codigos[2],
				'codigo_pergunta_respostas' => $codigos[0],
				'codigo_respostas' => $codigos[3]
			);
			$aSerDeletado = array(
				'codigo_dimensao_sub_dimensao_perguntas' => $codigos[1],
				'codigo_sub_dimensao_perguntas' => $codigos[2],
				'codigo_perguntas' => $codigos[0],
				'codigo' => $codigos[3]
			);
			$this->model_perguntas->deletarAlternativa($comp,$aSerDeletado);
		}

	}

	public function deletarQuestao()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
			$codigos = explode('-', $this->uri->segment(3));
			$comp = array(
				'codigo_dimensao_sub_dimensao' => $codigos[0],
				'codigo_sub_dimensao' => $codigos[1],
				'codigo' => $codigos[2]
			);
			$aSerDeletado = array(
				'codigo_dimensao_sub_dimensao' => $codigos[0],
				'codigo_sub_dimensao' => $codigos[1],
				'codigo' => $codigos[2]
			);
			$this->model_perguntas->deletarPergunta($comp,$aSerDeletado);
		}
	}

	public function alternativa()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
			$codigos = explode('-', $this->uri->segment(3));
			
			if ($codigos[0]!=null) {
				$this->form_validation->set_rules('resposta', 'Alternativa', 'trim|required|min_length[3]|xss_clean');
				$this->form_validation->set_rules('valor', 'Valor', 'trim|required|is_numeric|min_length[1]|max_length[3]|xss_clean');
				if ($this->form_validation->run()==true) {
					$dados = elements(array('resposta','valor'),$this->input->post());
					$this->model_perguntas->adcAlternativa($dados,$codigos);
				}else{
					$pergunta = $this->model_perguntas->obterPergunta($codigos[2],$codigos[1],$codigos[3])->row();
					$respostas = $this->model_perguntas->obterRespostasPergunta($codigos[2],$codigos[1],$codigos[3]);
					$dados = array(
				        	'titulo' => 'Consultar Questoes',
				        	'tela' => 'questoes/editar',
							'codigo_dimensao_sub_dimensao' => $codigos[1], 
							'codigo_sub_dimensao' => $codigos[2],
				        	'codigo_pergunta' => $codigos[3],
							'pergunta' => $pergunta->pergunta,
							'respostas' => $respostas
				        	);
					$this->load->view('index',$dados);
				}
			}else {
				print_r($codigos);
			}
		}
	}
	
	public function editar()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {
			$codigos = explode('-', $this->uri->segment(3));
			if ($codigos[0] != NULL) {

				$pergunta = $this->model_perguntas->obterPergunta($codigos[1],$codigos[0],$codigos[2])->row();
				$respostas = $this->model_perguntas->obterRespostasPergunta($codigos[1],$codigos[0],$codigos[2]);
				$dados = array(
			        	'titulo' => 'Editar a Questão',
			        	'tela' => 'questoes/editar',
						'codigo_dimensao_sub_dimensao' => $codigos[0], 
						'codigo_sub_dimensao' => $codigos[1],
			        	'codigo_pergunta' => $codigos[2],
						'pergunta' => $pergunta->pergunta,
						'respostas' => $respostas
			        	);
				$this->load->view('index',$dados);
			}
		}
	}
}

/* End of file questoes.php */
/* Location: ./application/controllers/questoes.php */