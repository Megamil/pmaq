<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Model_Excel extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function exportar($id_unidade=NULL){

    $unidade = $this->db->query("select id_unidade_unidade, nome_unidade, cod_dimensao, dimensao, cod_subdimensao, subdimensao, 
    pergunta, resposta, valor, responsavel from relatorio_subdimensoes 
    where id_unidade_unidade = ".$id_unidade." order by cod_dimensao, cod_subdimensao, pergunta, resposta");

      if($unidade->num_rows() > 0){
                
        return $unidade;

      }else{  

        return NULL;  

      }

  }

}
