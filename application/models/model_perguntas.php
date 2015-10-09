<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Perguntas extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
  public function update_resposta($codigo_pergunta=null,$codigo_dimensao_sub_dimensao=null,$codigo_sub_dimensao=null,$resposta=null,$dados=null)
  {
      
      if ($dados!=null) {
          $where = array('codigo_perguntas' => $codigo_pergunta,'codigo_dimensao_sub_dimensao_perguntas' => $codigo_dimensao_sub_dimensao, 'codigo_sub_dimensao_perguntas'=>$codigo_sub_dimensao, 'codigo' => $resposta);
          $this->db->update('respostas',$dados,$where);
          $this->session->set_flashdata('edicaook','<div class="alert alert-block alert-success"><p>Edição efetuada com sucesso.</p></div>');
          $this->db->_error_message();
          $this->db->_error_number();
          redirect("questoes/editar/$codigo_dimensao_sub_dimensao-$codigo_sub_dimensao-$codigo_pergunta");
      }

  }

  public function update_pergunta($codigo_dimensao_sub_dimensao=null,$codigo_sub_dimensao=null,$codigo_pergunta=null,$dados=null)
  {
      
      if ($dados!=null) {
          $where = array('codigo_dimensao_sub_dimensao' => $codigo_dimensao_sub_dimensao, 'codigo_sub_dimensao'=>$codigo_sub_dimensao, 'codigo' => $codigo_pergunta);
          $this->db->update('perguntas',$dados,$where);
          $this->session->set_flashdata('edicaook','<div class="alert alert-block alert-success"><p>Edição efetuada com sucesso.</p></div>');
          redirect("questoes/editar/$codigo_dimensao_sub_dimensao-$codigo_sub_dimensao-$codigo_pergunta");
      }
  }

  public function deletarAlternativa($comp=null,$aSerDeletado=null)
  {
      $db_debug = $this->db->db_debug; //save setting
      $this->db->db_debug = FALSE; //disable debugging for queries
      if($this->db->delete('respostas', $aSerDeletado)){
          $this->session->set_flashdata('edicaook','<div class="alert alert-block alert-success"><p>Alternativa deletada com sucesso.</p></div>');
          redirect("questoes/editar/".$comp['codigo_dimensao_sub_dimensao_respostas']."-".$comp['codigo_sub_dimensao_respostas']."-".$comp['codigo_pergunta_respostas']);
          $this->db->db_debug = $db_debug; //restore setting
      } else {
          $this->session->set_flashdata('edicaook','<div class="alert alert-block alert-danger"><p>Alternativa não pode ser removida, pois já foi selecionada anteriormente.</p></div>');
          redirect("questoes/editar/".$comp['codigo_dimensao_sub_dimensao_respostas']."-".$comp['codigo_sub_dimensao_respostas']."-".$comp['codigo_pergunta_respostas']);
          $this->db->db_debug = $db_debug; //restore setting
      }
  }

  public function deletarPergunta($comp=null,$aSerDeletado=null)
  {
      if($this->db->delete('perguntas', $aSerDeletado)){
          $this->session->set_flashdata('edicaook','<div class="alert alert-block alert-success"><p>Pergunta deletada com sucesso.</p></div>');
          redirect("questoes/consultar");
      } else {
          $this->session->set_flashdata('edicaook','<div class="alert alert-block alert-danger"><p>Pergunta não pode ser removida, por favor exclua as alternativas antes.</p></div>');
          redirect("questoes/consultar");
      }
  }

  public function adcAlternativa($dados=null,$codigos=null)
  {
    if ($dados!=null) {
      
      $this->db->insert('respostas',array(
                                    'resposta' => $dados['resposta'],
                                    'valor'=>$dados['valor'],
                                    'codigo'=> $codigos[0]+1,
                                    'codigo_perguntas'=> $codigos[1],
                                    'codigo_sub_dimensao_perguntas'=> $codigos[2],
                                    'codigo_dimensao_sub_dimensao_perguntas'=> $codigos[3]));
      redirect('questoes/editar/'.$codigos[3].'-'.$codigos[2].'-'.$codigos[1]);
    }
  }

  public function obterPerguntasAll()
  {
      $consulta = $this->db->get("perguntas");
      return $consulta->result();
  }

	public function obterPerguntas($id_sub =null, $id_dimensao = NULL)
  {
      if ($id_sub != NULL && $id_dimensao != null) {
          $this->db->order_by('codigo asc, codigo_sub_dimensao asc,codigo_dimensao_sub_dimensao asc'); 
          $this->db->where(array('codigo_sub_dimensao'=>$id_sub,'codigo_dimensao_sub_dimensao'=>$id_dimensao));            
          return $this->db->get('perguntas');            
      }
  }

  public function obterPergunta($id_sub =null, $id_dimensao = NULL,$id_pergunta = null)
  {
      if ($id_sub != NULL && $id_dimensao != null && $id_pergunta != null) {
          return $this->db->get_where('perguntas',array('codigo_sub_dimensao'=>$id_sub,'codigo_dimensao_sub_dimensao'=>$id_dimensao,'codigo'=>$id_pergunta));            
      }
  }

  public function obterRespostasPergunta($id_sub =null, $id_dimensao = NULL,$id_pergunta = null)
  {
      if ($id_sub != NULL && $id_dimensao != null) {
          return $this->db->query("SELECT * FROM respostas WHERE codigo_sub_dimensao_perguntas = $id_sub AND codigo_dimensao_sub_dimensao_perguntas = $id_dimensao AND codigo_perguntas = $id_pergunta");
      }
  }

	public function obterRespostas($id_sub =null, $id_dimensao = NULL)
	{
		if ($id_sub != NULL && $id_dimensao != null) {
      $this->db->order_by('codigo asc, codigo_sub_dimensao_perguntas asc,codigo_dimensao_sub_dimensao_perguntas asc'); 
			return $this->db->get_where('respostas',array('codigo_sub_dimensao_perguntas'=>$id_sub,'codigo_dimensao_sub_dimensao_perguntas'=>$id_dimensao));			
		}
	}

	public function salvar($dados = null)
	{
		if($dados!=null){

      $this->db->insert_batch('log_respondidas', $dados);

		}
	}
  
	public function consultar_log($id_dimensao=null,$id_sub_dimensao=null,$responsavel=null)
  {

     $where = array('codigo_sub_dimensao_perguntas_respostas' => $id_sub_dimensao,'codigo_dimensao_sub_dimensao_perguntas_respostas' => $id_dimensao, 'responsvel'=>$responsavel );
     $this->db->select('*');
     $this->db->from('log_respondidas');
     $this->db->where($where);
     $query = $this->db->get();
     return ($query->num_rows() > 0) ? 1 : 0 ;  
  }

  public function check_log($id_sub_dimensao=null,$id_dimensao=null,$id_unidade=null,$responsavel=null)
  {

       $where = array('codigo_sub_dimensao_perguntas_respostas' => $id_sub_dimensao,'codigo_dimensao_sub_dimensao_perguntas_respostas' => $id_dimensao, 'responsvel'=>$responsavel , 'id_unidade_unidade'=>$id_unidade );
       $this->db->select('*');
       $this->db->from('log_respondidas');
       $this->db->where($where);
       $query = $this->db->get();
       return ($query->num_rows() > 0) ? 1 : 0 ;
  }

  public function obter_unidade_log($responsavel=null){

       $query = 'SELECT DISTINCT unidade.nome_unidade, log_respondidas.id_unidade_unidade FROM log_respondidas, unidade WHERE log_respondidas.id_unidade_unidade = unidade.id_unidade AND '.$this->db->escape($responsavel).' = log_respondidas.responsvel';
        $result = $this->db->query($query);

          $result = $this->db->query($query);
  
      return $result ;
  }

  public function obter_dimensao($id_unidade=null){
      $query = 'SELECT DISTINCT dimensao.nome as dimensao, log_respondidas.codigo_dimensao_sub_dimensao_perguntas_respostas as id_dimensao FROM dimensao, log_respondidas WHERE log_respondidas.codigo_dimensao_sub_dimensao_perguntas_respostas = dimensao.codigo AND '.$this->db->escape($id_unidade).' = log_respondidas.id_unidade_unidade';
      $result = $this->db->query($query);
      return $result ;
  }

  public function obter_sub_dimensao($id_unidade=null){
      $query = 'SELECT distinct sub_dimensao.codigo as id_sub_dimensao, sub_dimensao.nome as sub_dimensao FROM public.log_respondidas JOIN public.sub_dimensao ON sub_dimensao.codigo = log_respondidas.codigo_sub_dimensao_perguntas_respostas AND sub_dimensao.codigo_dimensao = log_respondidas.codigo_dimensao_sub_dimensao_perguntas_respostas WHERE log_respondidas.id_unidade_unidade = '.$this->db->escape($id_unidade).'';
      $result = $this->db->query($query);
      return $result ;
  }

  public function obter_pergunta_resposta($id_unidade=null,$sub_dimensao=null,$dimensao=null){
      $query = '
      SELECT
        perguntas.pergunta,
        respostas.resposta
      FROM
      public.log_respondidas
      JOIN respostas ON log_respondidas.codigo_respostas = respostas.codigo AND
      log_respondidas.codigo_perguntas_respostas = respostas.codigo_perguntas
      JOIN perguntas ON respostas.codigo_perguntas = perguntas.codigo AND
      log_respondidas.codigo_perguntas_respostas = perguntas.codigo AND
      respostas.codigo_sub_dimensao_perguntas = perguntas.codigo_sub_dimensao AND
      respostas.codigo_dimensao_sub_dimensao_perguntas = perguntas.codigo_dimensao_sub_dimensao
      WHERE log_respondidas.id_unidade_unidade = '.$this->db->escape($id_unidade).' AND
      respostas.codigo_sub_dimensao_perguntas = '.$this->db->escape($sub_dimensao).' AND
      respostas.codigo_dimensao_sub_dimensao_perguntas = '.$this->db->escape($dimensao).'
      ';
      $result = $this->db->query($query);
      return $result ;
  }

  public function adicionarQuestao($dados='')
  {
      if($dados!=null){
          $this->db->insert('perguntas',$dados);
          return 1;
      }
  }

  public function adicionarResposta($dados='')
  {
      if($dados!=null){
          $this->db->insert('respostas',$dados);
          $this->session->set_userdata('cadastro_ok','<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button><p>Cadastro efetuado com sucesso</p></div>');
          return 1;
      }
  }

  public function limpaLog($unidade=null,$responsavel=null,$dados=null)
  {
    $where = array('id_unidade_unidade' => $unidade, 'responsvel'=>$responsavel);
    if ($dados!=null) {
      if($this->db->delete('log_respondidas', $where)){
        $this->db->insert('log_resultados', $dados);
        $this->session->set_flashdata('edicaook','<div class="alert alert-block alert-success"><p>Salvo com sucesso.</p></div>');
        redirect("questionario/resultado");
      }
    }
  }

  public function checkLogResultados($unidade=null,$responsavel=null)
  {
    $where = array('id_unidade' => $unidade, 'responsavel'=>$responsavel);
    $this->db->select('*');
    $this->db->from('log_resultados');
    $this->db->where($where);
    $query = $this->db->get();
    
    if($query->num_rows() > 0){
      return $query->row();
    }else{      
      return NULL;  
    }
  }

  public function checkLogResultadosUnidade($unidade=null)
  {
    $where = array('id_unidade' => $unidade);
    $this->db->select('*');
    $this->db->from('log_resultados');
    $this->db->where($where);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->row();
    }else{      
      return NULL;  
    }
  }

  public function checkLogResultadosAll()
  {
    $this->db->select('*');
    $this->db->from('log_resultados');
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query;
    }else{      
      return NULL;  
    }
  }

  public function checkLogRespondidos($unidade=null,$responsavel=null)
  {
    $where = array('id_unidade_unidade' => $unidade, 'responsvel'=>$responsavel);
    $this->db->select('*');
    $this->db->from('log_respondidas');
    $this->db->where($where);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->row();
    }else{      
      return NULL;  
    }
  }

  public function relatorio_subdimensoes($unidade=NULL){

   $query = $this->db->query('select id_unidade_unidade, nome_unidade, cod_dimensao, dimensao, cod_subdimensao, subdimensao, pergunta, resposta, valor, responsavel 
    from relatorio_subdimensoes where id_unidade_unidade = '.$unidade.' order by cod_dimensao, cod_subdimensao, pergunta, resposta');

     if($query->num_rows() > 0){

        return $query->result();

      }else{   

        return NULL;  

      }

  }

}
