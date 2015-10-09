<style type="text/css">

	#avisoErro {
		z-index: 60;
		position:fixed;
		display: none;
		top: 40px;
		left: 42%;
	}
	
	#anterior {
		position:fixed;
		bottom:50px;
		right:60px;
	}

	#proximo {
		z-index: 50;
		position:fixed;
		bottom:50px;
		right:154px;
	}

	#fixo {
		z-index: 50;
		position:fixed;
		overflow: scroll;
		width:50%;
		bottom: 90px;
		box-shadow: 3px 3px 7px black;
	}

</style>

<script type="text/javascript">

	$(document).ready(function(){

		var continuar = 0;
		var i = 0;
		var proximo = 0;
		var anterior = 0;
		var finalizar = 0;

		while(continuar < 3) {

			var texto = $('a:nth('+i+')').text();

			if(texto == 'Proximo' && proximo == 0) {
			
				continuar = continuar+1;
				proximo = i;
			
			} else if(texto == 'Anterior' && anterior == 0) {

				continuar = continuar+1;
				anterior = i;

			} else if (texto == 'Finalizar' && finalizar == 0) {

				continuar = continuar+1;
				finalizar = i;

			} else {

				i++;

			}


		}

		$("div.content.clearfix").attr("id","fixo");

		$('a:nth('+proximo+')').attr("id","proximo");

		$('a:nth('+finalizar+')').attr("id","proximo");

		$('a:nth('+anterior+')').attr("id","anterior");	


		$('a:nth('+proximo+')').click(function(){

			if(!$("label.error").text() == "") {

				$("label.error").text("").css("display","none");
				$("#avisoErro").css("display","block").text("Selecione uma alternativa antes de continuar");

				setTimeout(function(){
				    $("#avisoErro").css("display","none");
				},3000);

			}


		});



		$('a:nth('+anterior+')').click(function(){

			if(!$("label.error").text() == "") {

			$("label.error").text("").css("display","none");
			$("#avisoErro").css("display","block").text("Selecione uma alternativa antes de voltar");

			setTimeout(function(){
				    $("#avisoErro").css("display","none");
				},3000);

			}

		});
			

	});

</script>

<div role='actions clearfix'>
<div role="menu">
</div>
</div>

<div class="col-lg-10 center">
	<div class="well bs-docs-example">	

	<div class="alert alert-danger" role="alert" id="avisoErro">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Erro:</span>
	</div>

		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/jquery.steps.css" type="text/css"/>
	    <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.steps.js"></script>
	    	<form id="formulario" name="formulario" action="<?php echo base_url(); ?>questionario/salvar" method="post" accept-charset="utf-8">
	    		<div id="questionario">

	    		<?php
	    			$i = 0;
                    foreach($perguntas -> result() as $linha){
                    	$i=$linha->codigo;
                    	echo '
                    	<h1></h1>
                    	<div>
	    					<label for="pergunta-'.$linha->codigo.'"> Questao Num: '.$linha->codigo.' <br><br> '.$linha->pergunta.'</label> <hr><br />';
							foreach($respostas -> result() as $resposta){
		                    	if ($linha->codigo == $resposta->codigo_perguntas) {                    		
									echo'
									<div class="radio field">
										<label>
											<input type="radio" class="required" id="resposta-'.$linha->codigo.'" name="resposta-'.$linha->codigo.'" value="'.$resposta->codigo.'">
										'.$resposta->resposta.'</label>
									</div>';
									$checked = '';
								}
		                    }
						echo "</div>";
                        
                    }
					$this->session->set_userdata('num_questoes',$i);
					?>
					<input type="hidden" name="id_sub" value="<?php echo($id_sub); ?>">
					<input type="hidden" name="id_unidade" value="<?php echo($id_unidade); ?>">
					<input type="hidden" name="responsvel" value="<?php echo($responsvel); ?>">
					<input type="hidden" name="id_dimensao" value="<?php echo($id_dimensao); ?>">
                </div>
			</form>
	    	<input type="button" name="btnVolta" value="Voltar" onclick="javascript:window.history.back();" class="btn btn-info" />					
	</div>
</div>
	<script type="text/javascript">
		var form = $("#formulario");
		form.validate({
		    errorPlacement: function errorPlacement(error, element) { element.before(error); },
		    rules: {
		        required: true
		    }
		});
		form.children("div").steps({
		    transitionEffect: "slideLeft",
		    onStepChanging: function (event, currentIndex, newIndex)
		    {
		        form.validate().settings.ignore = ":disabled,:hidden";
		        return form.valid();
		    },
			labels: {
				cancel: "Cancelar",
				current: "Perguntal atual:",
				pagination: "Paginação",
				finish: "Finalizar",
				next: "Proximo",
				previous: "Anterior",
				loading: "Carregando ..."
			},
			onFinished: function (event, currentIndex) {
				document.getElementById("formulario").submit();
			},
			stepsOrientation: $.fn.steps.stepsOrientation.vertical
		});
			
	</script>