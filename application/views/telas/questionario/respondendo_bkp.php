<div class="col-lg-10 center">
	<div class="well bs-docs-example">
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery-1.4.2.min.js"></script>		
	    <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.form.js"></script>
	    <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.validate.js"></script>
	    <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/bbq.js"></script>
	    <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery-ui-1.8.5.custom.min.js"></script>
	    <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.form.wizard.js"></script>
	    <h5 id="status"></h5>
	    	<form id="questionario" action="127.0.0.1" method="post" accept-charset="utf-8">
	    		<div class="fieldWrapper">
	    			<div class="step_visualization"></div>
	    			<?php
                    foreach($perguntas -> result() as $linha){
                    	echo '
                    	<div class="step" id="'.$linha->codigo.'">
	    					<label for="firstname">Possui, '.$linha->pergunta.'?</label><br />
							<input class="input_field_12em" name="firstname" id="firstname" /><br />
	    			
	    			
	    				</div>';
                        
                    }
                	?>
	    			<div id="demoNavigation"> 							
					<input class="navigation_button" id="back" value="Proximo" type="reset" />
					<input class="navigation_button" id="next" value="Anterior" type="submit" />
				</div>
			</form>
	    						
	</div>
</div>
	<script type="text/javascript">
			$(function(){
				$("#questionario").formwizard({ 
				 	validationEnabled: true,
				 	focusFirstInput : true,
				 }
				);
  		});
    </script>