<div class="col-lg-10 center">
	<div class="well bs-docs-example">
	
		<?php

			if($this->session->userdata('error')){
	            echo'<div class="alert alert-dismissable alert-danger">
	            	<button type="button" class="close" data-dismiss="alert">x</button>'.$this->session->userdata('error').
	            	'</div>';
	        }

			$atriForm = array('class' => 'form-horizontal',);
			echo form_open('relatorios/consultar_resultados', $atriForm);
			$attr_label = array('class' => 'col-lg-2 control-label');
			
			echo "<fieldset>
			<div class=\"form-group\">";

				echo form_label('Unidade:','unidade',$attr_label);
					echo "<div class=\"col-lg-10\">";
						echo '
								<select class="input-xxlarge form-control" name="unidade" id="unidade">
								'.$unidades.'
								</select><br />
						';
					echo "</div>";
				echo "</div>";
			echo "</div>";
		?>
			<input type="submit" class="btn btn-primary btn-right" value="Continue &rarr;"/>
	</div>
</div>