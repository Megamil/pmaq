<?php 
	/*$resposta = Array(array('codigo-1' => 1, 'resposta-1' => 2, 'valor-1' => 3, 'consideracoes-1' => 4)); 
	if (isset($_SESSION['resposta'])) {
		$resposta = $_SESSION['resposta'];
	}
	echo json_encode($resposta);*/
	$var = Array(
    array(
        "nome"=>"João",
        "sobreNome"=>"Silva",
        "cidade"=>"Maringá",
        "Consideracoes" => "Consideracoes"
    ),
    array(
        "nome"=>"Ana",
        "sobreNome"=>"Rocha",
        "cidade"=>"Londrina",
        "Consideracoes" => "Consideracoes"
    ),
    array(
        "nome"=>"Véra",
        "sobreNome"=>"Valério",
        "cidade"=>"Cianorte",
        "Consideracoes" => "Consideracoes"
    ));
// convertemos em json e colocamos na tela
    echo json_encode($var);
 ?>