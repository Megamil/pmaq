<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
	// Adiciona extenções do code igniter
	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$dados = array (
		'titulo' => 'Programa de Melhoria do Acesso e da Qualidade da Atenção Básica',
		'tela' => 'inicio'
		);		
		$this->load->view('index',$dados);		
	}

	public function erro()
	{
		$dados = array (
		'titulo' => 'Erro 404',
		'tela' => 'erro'
		);		
		$this->load->view('index',$dados);		
	}
	
}
