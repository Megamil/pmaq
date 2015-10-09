<div class="col-lg-10 center">
    <div class="well bs-docs-example">
<?php
    if ($this->session->flashdata('excluirok')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
	}
	echo "<fieldset>
        <div class=\"form-group\">";
    echo validation_errors('<div class="alert alert-dismissable alert-danger""><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
    if ($this->session->flashdata('edicaook')) {
        echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('edicaook').'</div>';
    }
	$anchor_delete = array('class'=>"btn  btn-info");
	$anchor_edit = array('class'=>"label label-info");
?>
		<table class="display table table-striped table-hover table-condensed" id="consultar">
			<thead>
				<th>Dimensão</th>
				<th>Sub-Dimensão</th>
				<th>Numero</th>
				<th>Pergunta</th>
				<th>Operações</th>
			</thead>
			<tbody>
			<?php 
			foreach ($perguntas as $pergunta) {
				$dimensao = "Dimensão $pergunta->codigo_dimensao_sub_dimensao";
				$sub = "Sub-Dimensão $pergunta->codigo_sub_dimensao";
				$numero = $pergunta->codigo;
				$perg = $pergunta->pergunta;
				$operacoes = anchor("questoes/editar/$pergunta->codigo_dimensao_sub_dimensao-$pergunta->codigo_sub_dimensao-$pergunta->codigo",'Editar',$anchor_edit).'<i class="icon-italic"></i> <a href="#DeleteModal'.$pergunta->codigo_dimensao_sub_dimensao.'-'.$pergunta->codigo_sub_dimensao.'-'.$pergunta->codigo.'" class="label  label-danger" data-toggle="modal">Deletar</a>';
				echo '
				<tr class="gradeA">
					<td>
						'.$dimensao.'
					</td>
					<td>
						'.$sub.'
					</td>
					<td>
						'.$numero.'
					</td>
					<td>
						<center>'.$perg.'</center>
					</td>
					<td>
						'.$operacoes.'
					</td>
				</tr>
				';
				echo '<div id="DeleteModal'.$pergunta->codigo_dimensao_sub_dimensao.'-'.$pergunta->codigo_sub_dimensao.'-'.$pergunta->codigo.'" class="modal fade" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
								<h3 id="meuModelLabel">Realmente deseja Excluir o usuario?</h3>
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
								'.anchor("questoes/deletarQuestao/$pergunta->codigo_dimensao_sub_dimensao-$pergunta->codigo_sub_dimensao-$pergunta->codigo",'Excluir',$anchor_delete).'
							</div>					
						</div>
					</div>
				</div>';
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
		var table = $('#consultar').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sDom": '<"H"Tlfr>t<"F"ip>',
			"oTableTools": {
            "sSwfPath": "/pmaq/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
				"aButtons": [ 
					{ 
						"sExtends": "xls",
						"sButtonText": "Exportar para Excel",
						"sTitle": "Perguntas",
						"mColumns": [0, 1, 2, 3]
					},
					{
						"sExtends": "pdf",
						"sButtonText": "Exportar para PDF",
						"sTitle": "Pergunta",
						"sPdfOrientation": "landscape",
						"mColumns": [0, 1, 2, 3] 
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
		table.columnFilter();
	});//fim jquery
</script>