<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calcular extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function calcular()
	{
		// para calcular primeiro precisa, calcular os pontos feitos em todas a subdimensões uma por uma, vou pegar, e guardalas em um array.
		$this->form_validation->set_rules('responsavel','Responsavel','trim|required');
		$this->form_validation->set_rules('unidade','UBS','trim|required|max_length[50]|integer');
		if ($this->form_validation->run() == TRUE) {
			$responsavel=$this->input->get_post('responsavel');
			$id_unidade_unidade=$this->input->get_post('unidade');
			$resultado = $this->model_perguntas->checkLogResultados($id_unidade_unidade,$responsavel);
			$respondidos = $this->model_perguntas->checkLogRespondidos($id_unidade_unidade,$responsavel);
			if ($resultado == NULL) {
				if ($respondidos == NULL) {
					$this->session->set_flashdata('erro','<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>Você não respondeu nenhuma Sub-dimensão desta unidade ainda!</p></div>');
					redirect('questionario/resultado');
				}else{
					$total =array ();
					$resultado = array ();
					$calculo = $this->model_calcular->calcular($id_unidade_unidade,$responsavel);
					$total = $calculo['total'];
					$resultado = $calculo['resultado'];
					$result['cols'] = array ();
					$result['cols'][] = array ('label'=> 'Dimensões', 'type' => 'string');
					$result['cols'][] = array ('label'=> 'Percentual', 'type' => 'number');
					$result['rows'] = array ();
					$value=0;
					$total2=0;
					foreach ($resultado as $linha => $valor) {
						switch ($linha) {
								case 1: $value = (array_sum($valor)*100)/101.7; $total2 += (round(($value*10)/10))*0.1;break;
								case 2: $value = (array_sum($valor)*100)/105.6; $total2 += (round(($value*10)/10))*0.1;break;
								case 3: $value = (array_sum($valor)*100)/209.2; $total2 += (round(($value*10)/10))*0.2;break;
								case 4: $value = (array_sum($valor)*100)/189.3; $total2 += (round(($value*10)/10))*0.5;break;
								case 5: $value = (array_sum($valor)*100)/107.99; $total2 += (round(($value*10)/10))*0.1;break;
							}
						$result['rows'][] =array('0' => 'Dimensao '.$linha , '1' => round(($value*10)/10));
						
					}

					$result['rows'][] =array('0' => 'Total ', '1' => round(($total2*10)/10));

					$array = array(
					 	'por_dimensao' => $result['rows'],
					 	'log' => 0
					 );	
					 		 
					$this->session->set_userdata($array);
				}
			}else {
				$array = array(
				 	'por_dimensao' => unserialize($resultado->json_ref),
				 	'log' => 1
				 );			 
				$this->session->set_userdata($array);
			}
			$dados = array(
                'titulo' => 'Resultado da Unidade',
                'tela' => 'questionario/visualizando',
                'dados' => $this->session->userdata('por_dimensao'),
                'unidade' => $this->input->get_post('unidade')
            );
            $this->load->view('index', $dados);
		}else{
            $dados = array(
                'titulo' => 'Sistema do PMAQ',
                'tela' => 'questionario/erro'
            );
            $this->load->view('index', $dados);

        }
	}

	public function dataJson($value='')
	{
		$unidade =$this->uri->segment(3);
		if (isset($unidade)) {
			$resultado = $this->model_perguntas->checkLogResultadosUnidade($unidade);
			$data = unserialize($resultado->json_ref);
			
			header('Content-Type: application/json');
			echo(json_encode($data));
		}else{
			$data = $this->session->userdata('por_dimensao');
			
			header('Content-Type: application/json');
			echo(json_encode($data));
		}
	}
	
	public function salvar()
	{
		$data = $this->session->userdata('por_dimensao');
		$dados = array(
			'id_unidade' => $this->input->post('id_unidade'),
			'responsavel' => $this->input->post('responsavel'),
			"1" => $data[0][1],
			"2" => $data[1][1],
			"3" => $data[2][1],
			"4" => $data[3][1],
			"5" => $data[4][1],
			'total' => $data[5][1],
			'json_ref' => serialize($this->session->userdata('por_dimensao'))			
			);

		redirect ('questionario/resultado');
		//$this->model_perguntas->limpaLog($this->input->post('id_unidade'),$this->input->post('responsavel'),$dados);
		//desabilitado a opção de excluir o resultado após salvar o mesmo.
	}
}

/* End of file calcular.php */
/* Location: ./application/controllers/calcular.php */
