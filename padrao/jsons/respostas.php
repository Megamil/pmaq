<?php 
	//$resposta = Array(array('codigoaaa1' => 1, 'resaaa1' => 2, 'valoraaa1' => 3, 'consideracoesaaa1' => 4),array('codigoaaa1' => 1, 'resaaa1' => 2, 'valoraaa1' => 3, 'consideracoesaaa1' => 4)); 
	$resposta = isset($_COOKIE["resposta"]) ? $_COOKIE["resposta"] : "";
	$resposta = unserialize($resposta);
	echo json_encode($resposta);
 ?>