<?php
		$this->load->view('includes/header'); 
		if(isset($tela))$this->load->view('telas/'.$tela);
		$this->load->view('includes/footer');
 ?>
