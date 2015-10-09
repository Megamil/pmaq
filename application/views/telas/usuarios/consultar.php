<div class="col-lg-10 center">
	<div class="well bs-component">
		<?php 
			if ($this->session->flashdata('excluirok')) {
				echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
			}
		?>
		<div id="tabs-1">
			<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
				<thead> 
					<tr>
						<th class="span3">Codigo</th>
						<th class="span3">Nome do Usuario</th>
						<th class="span2">Grupo do Usuario</th>
						<th class="span3" >Operações</th>
					</tr>
				</thead>
			<tbody>
			<?php
				$anchor_delete = array('class'=>"btn  btn-danger");
				$anchor_edit = array('class'=>"label label-warning");
				$anchor_pass = array('class'=>"label  label-info");
				foreach ($usuarios ->result() as $linha) {
					if ($linha->ativo != 'f') {
						$codigo = $linha->id_cad_users;
						$nome = $linha->nome;
						switch ($linha->id_grupo_user) {
							case 1 : $grupo = 'Administrador'; break;
							case 2 : $grupo = 'Consultor'; break;
							case 3 : $grupo = 'Unidade'; break;
							case 4 : $grupo = 'Região de Saude'; break;
						}
						$ops = anchor("usuarios/editar/$linha->id_cad_users",'Editar',$anchor_edit).'<i class="icon-italic"></i> <a href="#DeleteModal'.$linha->id_cad_users.'" class="label  label-danger" data-toggle="modal">Deletar</a>';
						echo "<tr class='gradeA'>";
				        echo "<td><center>$codigo</center></td>";
				        echo "<td><center>$nome</center></td>";
						echo "<td><center>$grupo</center></td>";
						echo "<td><center>$ops</center></td>";
						echo '<div id="DeleteModal'.$linha->id_cad_users.'" class="modal fade" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
										<h3 id="meuModelLabel">Realmente deseja Excluir o usuario?</h3>
									</div>
									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
										'.anchor("usuarios/deletar/$linha->id_cad_users",'Excluir',$anchor_delete).'
									</div>					
								</div>
							</div>
						</div> </tr>';
					}
				}
			?>
</tbody>
</table>
</div>
</div>
</div>
<script>

//Todos scripts dentro de Document.Ready são Jquery 
$(document).ready(function() { 
	$('#consultar_usuarios').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"Tlfr>t<"F"ip>',
		"oTableTools": {
            "sSwfPath": "/pmaq/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{ 
					"sExtends": "xls",
					"sButtonText": "Exportar para Excel",
					"sTitle": "Usuarios Cadastrados",
					"mColumns": [0, 1, 2]
				},
				{
					"sExtends": "pdf",
					"sButtonText": "Exportar para PDF",
					"sTitle": "Usuarios Cadastrados",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2] 
				} 
			] 
		},
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por página",
			"sZeroRecords": "Nenhum registro encontrado",
			"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
			"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros)",
			"sSearch": "Pesquisar: ",
			"oPaginate": {
				"sFirst": "Início ",
				"sPrevious": " Anterior ",
				"sNext": " Próximo ",
				"sLast": " Último "
			}
		},
		"aaSorting": [[0, 'desc']],
		"aoColumnDefs": [
			{"sType": "num-html", "aTargets": [0]}
		]
	});
});//fim jquery
</script>