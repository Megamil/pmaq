	<div class="col-lg-10 center">
		<div class="well bs-component">
			<div id="tabs-1">
				<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
					<thead> 
						<tr>
							<td>
								<?php
						
									switch($id_grupo->row()->id_grupo_user){
										case 1: $nomegrupo = 'Administrador'; break;
										case 2: $nomegrupo = 'Consultor'; break;
										case 3: $nomegrupo = 'Unidade'; break;
										case 4: $nomegrupo = 'Regiao'; break;
									}

									echo '<strong>Grupo de Usuários:</strong> '.$nomegrupo; 

							 	?>
							</td>
						</tr>
						<tr>
							<th class="span3">Aplicação</th>
							<th class="span2">Permitir essa Aplicação</th>
							<th class="span3">Status Aplicação</th>
						</tr>
					</thead>
				<tbody>
				<?php
					
					foreach ($aplicacoes as $aplicacao) {

						$apl = $aplicacao->id_aplicacao;
						$grupo = $id_grupo->row()->id_grupo_user;

						$permitir = $this->model_users->manipularbotoes($apl,$grupo);

						if ($permitir == NULL){
							$sim = "";
							$nao = "disabled";
							$permitido = "Não Permitido Acesso";
						}else{
							$sim = "disabled";
							$nao = "";
							$permitido = "Permitido Acesso";
						}

						echo "<tr>";
						echo "<td>".$aplicacao->id_aplicacao." - ".$aplicacao->descricao_aplicacao."</td>";
						echo "<td>"
						.anchor("usuarios/adicionarAppAoGrupo/".$aplicacao->id_aplicacao."/".$id_grupo->row()->id_grupo_user,"<div class='btn btn-success'".$sim.">Sim</div>").
						anchor("usuarios/removerAppDoGrupo/".$aplicacao->id_aplicacao."/".$id_grupo->row()->id_grupo_user,"<div class='btn btn-danger'".$nao.">Não</div>")."</td>";
						echo "<td>".$permitido."</td>";
						echo "</tr>";
					}
				?>
				</tbody>
				</table>
			</div>
		</div>
	</div>