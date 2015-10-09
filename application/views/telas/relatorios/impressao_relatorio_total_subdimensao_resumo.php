<?php

anchor_popup("pdf_controller/impressao_realtorio_total_subdimensao");

$html = "
<meta charset='utf-8'/>
	<style language='text/css'>

		.titulorelatorio{
			font-family: helvetica,sans,serif;
			font-weight: bold;
			background-color: #dddddd;
		}
		
		.titulocolunas{
			font-family: helvetica,sans,serif;
			background-color: #66ccff;
		}
	
		.titulodimensao{
			font-family: helvetica,sans,serif;
			background-color: #ffffff;
		}

	</style>
		<table width='100%'>
		<tr><td class='titulorelatorio' align='center'><h3>Programa de Melhoria do Acesso e da Qualidade da Atenção Básica - PMAQ</h3></td></tr>
		<tr><td class='titulorelatorio' align='center'>Relatório Total das Subdimensões - Resumido</td></tr>
		</table>

		<br />
		<table border='1' cellspacing='0' cellpadding='0'>
			<thead>

				<tr>
					<th class='titulocolunas'>Unidade</th>
					<th class='titulocolunas'>Dimensão</th>
					<th class='titulocolunas'>Sub Dimensão</th>
					<th class='titulocolunas'>Total da <br>Sub-Dimensão</th>

				</tr>
			</thead>

				<tbody>";

					$totalobtido = 0;
					$totalmaximo = 0;
					$valordimensao = 0;
					$sub = 1.;
					$codigo_dimensao = 0; $nome_dimensao = 0;
					$codigo_subdimensao = 0; $nome_subdimensao = 0;
					$tabela_resultado = '';
					$i = 1;
						foreach($pack as $resultado) {

							if ($sub == $resultado->cod_dimensao.$resultado->cod_subdimensao){

								$nome_unidade = $resultado->nome_unidade;
								$codigo_dimensao = $resultado->cod_dimensao;
								$nome_dimensao = $resultado->dimensao;
								$nome_subdimensao = $resultado->subdimensao;

								$totalobtido = $totalobtido + $resultado->valor;
								$totalmaximo = $totalmaximo + 100;


							}else if($totalobtido>0){

								$valordimensao = round((($totalobtido / $totalmaximo)*100),2);

								   
								$html .= "<tr>
											<td class='titulodimensao'>".$nome_unidade."</td>
											<td class='titulodimensao'>".$nome_dimensao."</td>
											<td class='titulodimensao'>".$nome_subdimensao."</td>
											<td class='titulodimensao' align='center'><b>".$valordimensao."%</b></td> 
										 </tr>";
										

										$nome_unidade = $resultado->nome_unidade;
										$codigo_dimensao = $resultado->cod_dimensao;
										$nome_dimensao = $resultado->dimensao;
										$codigo_subdimensao = $resultado->cod_subdimensao;
										$nome_subdimensao = $resultado->subdimensao;
		
										$totalobtido = 0;
										$totalmaximo = 0;
										$valordimensao = 0;	

										$totalobtido = $totalobtido + $resultado->valor;
										$totalmaximo = $totalmaximo + 100;

										$sub = $resultado->cod_dimensao.$resultado->cod_subdimensao;

							}else{

								$nome_unidade = $resultado->nome_unidade;
								$codigo_dimensao = $resultado->cod_dimensao;
								$nome_dimensao = $resultado->dimensao;
								$codigo_subdimensao = $resultado->cod_subdimensao;
								$nome_subdimensao = $resultado->subdimensao;

								$totalobtido = $totalobtido + $resultado->valor;
								$totalmaximo = $totalmaximo + 100;

								$sub = $resultado->cod_dimensao.$resultado->cod_subdimensao;
			
							}



						}

						$valordimensao = round((($totalobtido / $totalmaximo)*100),2);
							
					$html .= "<tr>
								<td class='titulodimensao'>".$nome_unidade."</td>
								<td class='titulodimensao'>".$nome_dimensao."</td>
								<td class='titulodimensao'>".$nome_subdimensao."</td>
								<td class='titulodimensao' align='center'><b>".$valordimensao."%</b></td> 
							</tr>";

				$html .= "</tbody>
		</table>";

// Incluímos a biblioteca DOMPDF
require_once("./dompdf/dompdf_config.inc.php");
 
// Instanciamos a classe
$dompdf = new DOMPDF();
 
// Passamos o conteúdo que será convertido para PDF
$dompdf->load_html($html);
 
// Definimos o tamanho do papel e
// sua orientação (retrato ou paisagem)
$dompdf->set_paper('A4','landscape');
 
// O arquivo é convertido
$dompdf->render();
 
// Salvo no diretório temporário do sistema
// e exibido para o usuário
$dompdf->stream("relatorio_subdimensao_total.pdf",array('Attachment'=>0));

?>