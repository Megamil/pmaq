<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios extends My_Controller {

	public function __construct(){
		parent::__construct();
	}

	// List all your items
	public function consultar_resultados(){
		
		if($this->model_users->ver_acesso($this->uri->segment(2))) {

			if($this->session->userdata('user_group')==3) {

				if($this->session->userdata('cnes') != ''){$unidade = $this->model_ubs->retorna_ubs_cnes($this->session->userdata('cnes'));}
				if($this->session->userdata('id_regiao') != ''){$unidade = $this->model_ubs->retorna_ubs_byregiao($this->session->userdata('id_regiao'));}


					$resultado = $this->model_perguntas->checkLogResultadosUnidade($unidade->row()->id_unidade);
					
					if ($resultado == NULL){
						$array = array (
							'error' => 'Resultado da unidade não foi salvo'
						);
						$this->session->set_userdata( $array );
						$ubs = $this->model_ubs->retorna_ubs();
				        $option = "<option value=''></option>";

				        foreach ($ubs as $linha) {

					        $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";

					    }//final do foreach
				    	
				        $dados = array (
				            'titulo' => 'Resultado por Unidade',
				            'tela' => 'relatorios/consultar_resultados',
				            'unidades' => $option
				        );
				        $this->load->view('index', $dados);

					}else{//else da verificação da variável resultuado
						$array = array (
						 	'por_dimensao' => unserialize($resultado->json_ref),
						 	'log' => 1
						 );		

						$this->session->set_userdata($array);

						$dados = array(
			                'titulo' => 'Resultado por Unidade',
			                'tela' => 'questionario/visualizando',
			                'dados' => $this->session->userdata('por_dimensao'),
			                'unidade' => $unidade->row()->id_unidade
			            );

			            $this->load->view('index', $dados);

			       }

			}

			if($this->session->userdata('user_group')==4) {

				$this->form_validation->set_rules('unidade','UBS','trim|required|max_length[50]|integer');

				if ($this->form_validation->run() != TRUE){

					$ubs = $this->model_ubs->retorna_ubs_byregiao($this->session->userdata('id_regiao'));
		            $option = "<option value=''></option>";

		            foreach ($ubs->result() as $linha) {
		                $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
		            }//final do foreach

		            $dados = array(
		                'titulo' => 'Resultado por Unidade',
				            'tela' => 'relatorios/consultar_resultados',
		                		'unidades' => $option
		            );

		            $this->load->view('index', $dados);

		        } else {

		        	$id_unidade_unidade=$this->input->get_post('unidade');
					$resultado = $this->model_perguntas->checkLogResultadosUnidade($id_unidade_unidade);
					
					if ($resultado == NULL){
						$array = array (
							'error' => 'Resultado da unidade não foi salvo'
						);
						$this->session->set_userdata( $array );
						$ubs = $this->model_ubs->retorna_ubs();
				        $option = "<option value=''></option>";

				        foreach ($ubs as $linha) {

					        $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";

					    }//final do foreach
				    	
				        $dados = array (
				            'titulo' => 'Resultado por Unidade',
				            'tela' => 'relatorios/consultar_resultados',
				            'unidades' => $option
				        );
				        $this->load->view('index', $dados);

					}else{//else da verificação da variável resultuado

						$array = array (
						 	'por_dimensao' => unserialize($resultado->json_ref),
						 	'log' => 1
						 );			 
						$this->session->set_userdata($array);
						$dados = array(
			                'titulo' => 'Resultado por Unidade',
			                'tela' => 'questionario/visualizando',
			                'dados' => $this->session->userdata('por_dimensao'),
			                'unidade' => $this->input->get_post('unidade')
			            );
			            $this->load->view('index', $dados);
					}//final do if para verificar o a variável resultado
     		   }
			}

			if($this->session->userdata('user_group')==1 || $this->session->userdata('user_group')==2){//verifica se o usuário é do tipo administrador ou consultor
				
				$this->form_validation->set_rules('unidade','UBS','trim|required|max_length[50]|integer');

				if ($this->form_validation->run() == TRUE){

					$id_unidade_unidade=$this->input->get_post('unidade');
					$resultado = $this->model_perguntas->checkLogResultadosUnidade($id_unidade_unidade);
					
					if ($resultado == NULL){
						$array = array (
							'error' => 'Resultado da unidade não foi salvo'
						);
						$this->session->set_userdata( $array );
						$ubs = $this->model_ubs->retorna_ubs();
				        $option = "<option value=''></option>";

				        foreach ($ubs as $linha) {

					        $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";

					    }//final do foreach
				    	
				        $dados = array (
				            'titulo' => 'Resultado por Unidade',
				            'tela' => 'relatorios/consultar_resultados',
				            'unidades' => $option
				        );
				        $this->load->view('index', $dados);

					}else{//else da verificação da variável resultuado

						$array = array (
						 	'por_dimensao' => unserialize($resultado->json_ref),
						 	'log' => 1
						 );			 
						$this->session->set_userdata($array);
						$dados = array(
			                'titulo' => 'Resultado por Unidade',
			                'tela' => 'questionario/visualizando',
			                'dados' => $this->session->userdata('por_dimensao'),
			                'unidade' => $this->input->get_post('unidade')
			            );
			            $this->load->view('index', $dados);
					}//final do if para verificar o a variável resultado

				}else{//else da verificação de validação

					$ubs = $this->model_ubs->retorna_ubs();
			        $option = "<option value=''></option>";
			        foreach ($ubs as $linha) {
			            $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
			        }
			        $dados = array (
			            'titulo' => 'Resultado por Unidade',
			            'tela' => 'relatorios/consultar_resultados',
			            'unidades' => $option
			        );
			        $this->load->view('index', $dados);

				}//final do if de verificação da validação

			}else{//funcões para usuário do tipo unidade


			}//final do if de verificação do tipo de usuário

		}// final da verificação da permissão de acesso

	}// final da function consultar_resultados


	// Add a new item
	public function regiao(){
		if($this->model_users->ver_acesso('filtro_regiao')) {
			if($this->session->userdata('user_group')!=4){

				$dados = array (
			            'titulo' => 'Resultados por Região',
			            'tela' => 'relatorios/filtro_regiao'

			        );

				$this->load->view('index', $dados);
			}else{
				
				$this->retorno_filtro($this->session->userdata('id_regiao'));

			}
		}

	}

	public function retorno_filtro($id_regiao = null){
		if($this->model_users->ver_acesso('filtro_regiao')) {
			
			if($id_regiao == null){$regiao = $this->input->post('regionalsaude'); } else {$regiao = $id_regiao;}

			$regiao = $this->model_ubs->retorna_ubs_byregiao($regiao)->result();

				 $dados = array (
			            'titulo' => 'Resultados por Região',
			            'tela' => 'relatorios/consultar_regiao',
			            'ubs_regiao' => $regiao
			        );

			 $this->load->view('index', $dados);
		}

	}

	public function relatorio_subdimensoes()
	{
		if($this->model_users->ver_acesso($this->uri->segment(2))) {

			if($this->session->userdata('user_group') == 4) {

				$ubs = $this->model_ubs->retorna_ubs_byregiao($this->session->userdata('id_regiao'));
		            $option = "<option value=''></option>";

		            foreach ($ubs->result() as $linha) {
		                $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
		            }//final do foreach

		            $dados = array(
						'titulo' => 'Resultado por Sub Dimensão',
			            'tela' => 'relatorios/relatorio_subdimensoes',
			            'unidade' => $option
		            );

		            $this->load->view('index', $dados);

			} else if ($this->session->userdata('user_group') == 3) {

				if($this->session->userdata('cnes') != ''){$unidade = $this->model_ubs->retorna_ubs_cnes($this->session->userdata('cnes'));}
				if($this->session->userdata('id_regiao') != ''){$unidade = $this->model_ubs->retorna_ubs_byregiao($this->session->userdata('id_regiao'));}

				$unidad = $this->model_perguntas->relatorio_subdimensoes($unidade->row()->id_unidade);

					$dados = array (
				        'titulo' => 'Relatório Sub Dimensões',
				        'tela' => 'relatorios/relatorio_total_subdimensao',
				        'unidad' => $unidad);
						
				$this->load->view('index', $dados);
			} else {

				$ubs = $this->model_ubs->retorna_ubs();
			    $option = "<option value=''></option>";

			        foreach ($ubs as $linha) {
			            $option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
			        }

			        $dados = array (
			            'titulo' => 'Resultado por Sub Dimensão',
			            'tela' => 'relatorios/relatorio_subdimensoes',
			            'unidade' => $option
			        );

			    $this->load->view('index', $dados);

			}
		}
	}

	public function relatorio_total_subdimensoes()
	{
		
		if(empty($this->input->post('unidade'))){
					
			$this->session->set_userdata('erro','<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>Selecione um Unidade.</p></div>');
			$this->relatorio_subdimensoes();
				
		}else{
				
			$unidad = $this->model_perguntas->relatorio_subdimensoes($this->input->post('unidade'));

			if(is_null($unidad)){

				$this->session->set_userdata('erro','<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>Selecione uma unidade que já preencheu uma sub-dimensão.</p></div>');
				$this->relatorio_subdimensoes();

			}else{
				
				$dados = array (
				        'titulo' => 'Relatório Sub Dimensões',
				        'tela' => 'relatorios/relatorio_total_subdimensao',
				        'unidad' => $unidad);
						
				$this->load->view('index', $dados);
			}

		}
		
	}



}
	
	/* End of file relatorios.php */
	/* Location: ./application/controllers/relatorios.php */