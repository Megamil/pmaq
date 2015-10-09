<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Dimensoes extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function obter_SubDimensoes($id_dimensao = null){
        if ($id_dimensao == null){
        }else{
        	$this->db->order_by('codigo');
            $this->db->where('codigo_dimensao',$id_dimensao);
			return $this->db->get('sub_dimensao');
        }
	}
}