<?php 
	$resposta = isset($_COOKIE["resposta"]) ? $_COOKIE["resposta"] : "";
	$resposta = unserialize($resposta);
	echo json_encode($resposta);
 ?>