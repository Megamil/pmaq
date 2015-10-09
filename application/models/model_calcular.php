<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_calcular extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function log_respondidos($id_dimensao=null,$responsavel=null,$id_unidade_unidade=null)
	{
		 $where = array('codigo_dimensao_sub_dimensao_perguntas_respostas' => $id_dimensao, 'responsvel'=>$responsavel, 'id_unidade_unidade'=>$id_unidade_unidade );
		 $this->db->select('*');
		 $this->db->from('log_respondidas');
		 $this->db->where($where);
		 return  $this->db->get();
	}

	public function log_respondidos_bySubs($id_sub=null,$id_dimensao=null,$responsavel=null,$id_unidade_unidade=null)
	{
		 $where = array('codigo_sub_dimensao_perguntas_respostas' => $id_sub,'codigo_dimensao_sub_dimensao_perguntas_respostas' => $id_dimensao, 'responsvel'=>$responsavel, 'id_unidade_unidade'=>$id_unidade_unidade );
		 $this->db->select('*');
		 $this->db->from('log_respondidas');
		 $this->db->where($where);
		 return  $this->db->get();
	}

	public function get_log($id_sub=null,$id_dimensao=null,$responsavel=null,$id_unidade_unidade=null)
	{
		$where = array('codigo_subdimensao' => $id_sub,'codigo_dimensao' => $id_dimensao, 'responsvel'=>$responsavel, 'id_unidade'=>$id_unidade_unidade );
		$this->db->select('*');
		$this->db->from('log_percentual_valor');
		$this->db->where($where);
		return  $this->db->get();
	}
	
	public function obterRespostasRespondidas($id_sub =null, $id_dimensao = NULL,$id_pergunta = null, $id_resposta = null)
    {
        if ($id_sub != NULL && $id_dimensao != null) {
            return $this->db->query("SELECT * FROM respostas WHERE codigo_sub_dimensao_perguntas = $id_sub AND codigo_dimensao_sub_dimensao_perguntas = $id_dimensao AND codigo_perguntas = $id_pergunta AND codigo = $id_resposta");
        }
    }

	public function sub_dimensoes($id_dimensao=null,$id_sub_dimensao=null)
	{
		 $where = array('codigo_dimensao' => $id_dimensao);
		 $this->db->select('*');
		 $this->db->from('sub_dimensao');
		 $this->db->where($where);
		 return  $this->db->get();
	}

    public function calcular($id_unidade_unidade = null,$responsavel=null)
    {
    	if ($id_unidade_unidade != null && $responsavel != null) {
		$string = array ();
		$valor_sub = 0;
		$aux = 0;
		$total = array ();
    	$subs = array ();
		$resultado = array ();

    		for ($i=1; $i <= 5 ; $i++) { //listar as dimensões (5 no total)
				
				$subdi = $this->model_calcular->sub_dimensoes($i); //recebe as subdimensões das dimensões do for de acordo com o $i.

				foreach ($subdi->result() as $subdimensao) {

					$subs[$subdimensao->codigo_dimensao][$subdimensao->codigo] = $subdimensao->percentual_subdimensao; //atribui o percentual_subdimensao para a variável $subs
					$resultado[$subdimensao->codigo_dimensao][$subdimensao->codigo] = 0; //atribui 0 (zero) para a variável $resultado
					$log = $this->model_calcular->get_log($subdimensao->codigo,$subdimensao->codigo_dimensao,$responsavel,$id_unidade_unidade); //envia dados para o where executado na view do banco log_percentual_valor

					if ($log->num_rows() > 0) { //verifica se tem alguma linha de resultado na variável $log se sim executa o código abaixo

						$string = $this->db->last_query(); //variável $string executa/recebe o ultimo query realizado no banco novamente?

						foreach ($log->result() as $ocorrencia) {

							$resultado[$subdimensao->codigo_dimensao][$subdimensao->codigo] += ($ocorrencia->valor_repostas/100)*$ocorrencia->percentual_subdimensao; //$resultado recebe o resultado da conta onde o valor da resposta é divido por 100 e multiplicado pelo percentual da subdimensao.
							$total[][$subdimensao->codigo_dimensao][$subdimensao->codigo] = ($ocorrencia->valor_repostas/100)*$ocorrencia->percentual_subdimensao.'<br>'; //$total recebe o resultado da conta onde o valor da resposta é divido por 100 e multiplicado pelo percentual da subdimensao.
						}

					} else {

						$resultado[$subdimensao->codigo_dimensao][$subdimensao->codigo] = 0; // atribui 0 (zero) para variável #resultado caso o IF retorne falso.

					} // fechar o else
				} //fechar o foreach da variavel $subdimensao

				foreach ($subdi->result() as $subdimensao) {

					$resultado[$subdimensao->codigo_dimensao][$subdimensao->codigo] = round($resultado[$subdimensao->codigo_dimensao][$subdimensao->codigo]*10)/10;
				
				}

			} //fechar o for das dimensões
			return (array('total' => $total,'resultado' => $resultado));
    	}
    }
	

}

/* End of file model_calcular.php */
/* Location: ./application/models/model_calcular.php */