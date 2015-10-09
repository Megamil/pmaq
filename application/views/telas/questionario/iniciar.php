<div class="col-lg-10 center">
	<div class="well bs-docs-example">
	<?php 
		$atriForm = array('class' => 'form-horizontal',);
		echo form_open('questionario/dimensao', $atriForm);
		$attr_label = array(
	    'class' => 'col-lg-2 control-label',
		);
		echo "<fieldset>
			<div class=\"form-group\">";
				echo validation_errors('<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
					if ($this->session->flashdata('tudook')) {
						echo '<p>'. $this->session->flashdata('tudook').'</p>';	
					}
				echo form_label('Responsavel:','responsavel-label',$attr_label);
					echo "<div class=\"col-lg-10\">";
						$nome = $this->session->userdata('nome');
						$data = array(
				              'responsavel'  => $nome
				            );
						echo form_hidden($data);
						echo form_input(array('name' => 'responsavel-label','id' => 'responsavel-label', 'class' => 'form-control', 'disabled'=>'', 'value'=>$nome),set_value('responsavel'));
					echo "</div>";

			echo " <br /><br /><br />";

			echo form_label('Unidade:','unidade',$attr_label);
			echo "<div class=\"col-lg-10\">";
				echo '
						<select class="input-xxlarge form-control" name="unidade" id="unidade">
						'.$unidades.'
						</select><br />
				';
			echo "</div>";

	?>
		<input type="submit" class="btn btn-primary btn-right" value="Continue &rarr;"/>
		<?php echo "</div></fieldset>"; ?>
	</div>
</div>
</div>
