<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Model_ubs extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function retorna_ubs(){
		$consulta = $this->db->query("select * from unidade order by nome_unidade");
		return $consulta->result();	
	}

	public function retorna_regioes(){
		$consulta = $this->db->get("regiao_de_saude");
		return $consulta->result();	
	}

	public function get_unidade($codigo=null){
		$this->db->select('nome_unidade');
		$this->db->where('id_unidade', $codigo);
		$consulta = $this->db->get("unidade")->row();
		return $consulta->nome_unidade;	
	}

	public function retorna_ubs_byregiao($regiao='')
	{
		if ($regiao !=null) {
			$this->db->where('id_regiao_regiao_de_saude', $regiao);
			$consulta = $this->db->get("unidade");
			return $consulta;	
		}
	}

	public function retorna_ubs_cnes($cnes=null)
	{
		$consulta = $this->db->query("select id_unidade from unidade where cnes_unidade= '".$cnes."'");
		return $consulta;	
	}

}