		<div class="col-lg-10">
			<div class="well bs-docs-example">
				<div id="tabs-1">
						<table class="display table table-striped table-hover table-condensed" id="consultar" border="0">
							<thead> 
								<tr>	
									<th class="span3">Unidade</th>
									<th class="span3">Dimensão</th>
									<th class="span3">Sub Dimensão</th>
									<th class="span2">Total da Sub-Dimensão</th>

								</tr>
							</thead>

								<tbody>
									<?php

										$totalobtido = 0;
										$totalmaximo = 0;
										$valordimensao = 0;
										$sub = 1;
										$codigo_dimensao = 0; $nome_dimensao = 0;
										$codigo_subdimensao = 0; $nome_subdimensao = 0;
										$tabela_resultado = "";
										$i = 1;
											foreach($unidad as $resultado) {

												if ($sub == $resultado->cod_dimensao.$resultado->cod_subdimensao){

													$nome_unidade = $resultado->nome_unidade;
													$codigo_dimensao = $resultado->cod_dimensao;
													$nome_dimensao = $resultado->dimensao;
													$nome_subdimensao = $resultado->subdimensao;

													$tabela_resultado .= "<tr class= respostas_sub_".$codigo_dimensao.$codigo_subdimensao.">";
													$tabela_resultado .= "<td colspan=2>".$i." - <i>".$resultado->pergunta."</i></td>";
													$tabela_resultado .= "<td><i>".$resultado->resposta."</i></td>";
													$tabela_resultado .= "<td><i>".$resultado->responsavel."</i></td>";
													$tabela_resultado .= "</tr>";

													$totalobtido = $totalobtido + $resultado->valor;
													$totalmaximo = $totalmaximo + 100;

													$i++;

												}else if($totalobtido>0){

													$valordimensao = round((($totalobtido / $totalmaximo)*100),2);

													   echo '
															<tr class=sub_dimensao_'.$codigo_dimensao.$codigo_subdimensao.'>
																<td>'.$nome_unidade.'</td>
																<td>'.$nome_dimensao.'</td>
																<td>'.$nome_subdimensao.'</td>
																<td align=center><b>'.$valordimensao.'%</b></td> 
															</tr>

															<tr class=respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'>
																<td colspan=2><i><b>Perguntas</b></i></td>
																<td><i><b>Respostas</b></i></td>
																<td><i><b>Responsável</b></i></td>
															</tr>
																'.$tabela_resultado.'
															';

															$tabela_resultado = "";

															$nome_unidade = $resultado->nome_unidade;
															$codigo_dimensao = $resultado->cod_dimensao;
															$nome_dimensao = $resultado->dimensao;
															$codigo_subdimensao = $resultado->cod_subdimensao;
															$nome_subdimensao = $resultado->subdimensao;
															
															$i = 1;

															$tabela_resultado .= '<tr class=respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'>';
															$tabela_resultado .= "<td colspan=2>".$i." - <i>".$resultado->pergunta."</i></td>";
															$tabela_resultado .= "<td><i>".$resultado->resposta."</i></td>";
															$tabela_resultado .= "<td><i>".$resultado->responsavel."</i></td>";
															$tabela_resultado .= "</tr>";

															$i++;

															$totalobtido = 0;
															$totalmaximo = 0;
															$valordimensao = 0;	

															$totalobtido = $totalobtido + $resultado->valor;
															$totalmaximo = $totalmaximo + 100;

															$sub = $resultado->cod_dimensao.$resultado->cod_subdimensao;


														echo '<script>

															$(document).ready(function(){

																$(".respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'" ).toggle();

																	$(".sub_dimensao_'.$codigo_dimensao.$codigo_subdimensao.'").click(function() {
																	  $(".respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'" ).toggle( "flash" );
																	});

																});

															</script>';
													

												}else{

													$nome_unidade = $resultado->nome_unidade;
													$codigo_dimensao = $resultado->cod_dimensao;
													$nome_dimensao = $resultado->dimensao;
													$codigo_subdimensao = $resultado->cod_subdimensao;
													$nome_subdimensao = $resultado->subdimensao;

													$tabela_resultado .= '<tr class=respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'>';
													$tabela_resultado .= "<td colspan=2>".$i." - <i>".$resultado->pergunta."</i></td>";
													$tabela_resultado .= "<td><i>".$resultado->resposta."</i></td>";
													$tabela_resultado .= "<td><i>".$resultado->responsavel."</i></td>";
													$tabela_resultado .= "</tr>";

													//$tabela_resultado = "";

													$i++;

													$totalobtido = $totalobtido + $resultado->valor;
													$totalmaximo = $totalmaximo + 100;

													$sub = $resultado->cod_dimensao.$resultado->cod_subdimensao;

													echo '<script>

															$(document).ready(function(){

																$(".respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'" ).toggle();

																	$(".sub_dimensao_'.$codigo_dimensao.$codigo_subdimensao.'").click(function() {
																		$(".respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'" ).toggle( "flash" );
																	});

																});

														</script>';
													
												}



											}

											$valordimensao = round((($totalobtido / $totalmaximo)*100),2);
												
											echo '
													<tr class=sub_dimensao_'.$codigo_dimensao.$codigo_subdimensao.'>
														<td>'.$nome_unidade.'</td>
														<td>'.$nome_dimensao.'</td>
														<td>'.$nome_subdimensao.'</td>
														<td align=center><b>'.$valordimensao.'%</b></td> 
													</tr>

													<tr class=respostas_sub_'.$codigo_dimensao.$codigo_subdimensao.'>
														<td colspan=2><i><b>Perguntas</b></i></td>
														<td><i><b>Respostas</b></i></td>
														<td><i><b>Responsável</b></i></td>
													</tr>
														'.$tabela_resultado.'
													';

												echo '<a href="'.base_url().'pdf_controller/exportar/'.$resultado->id_unidade_unidade.'" class="btn btn-info" target="_blank">Exportar Excel</a>';
												echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
												echo '<a href="'.base_url().'pdf_controller/impressao_relatorio_total_subdimensao/'.$resultado->id_unidade_unidade.'" class="btn btn-info" target="_blank">Imprimir Completo</a>';
												echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
												echo '<a href="'.base_url().'pdf_controller/impressao_relatorio_total_subdimensao_resumo/'.$resultado->id_unidade_unidade.'" class="btn btn-info" target="_blank">Imprimir Resumido</a>';
									?>
								</tbody>
						</table>
					
				</div>
			</div>
		</div>