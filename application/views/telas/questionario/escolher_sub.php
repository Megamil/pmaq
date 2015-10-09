<div class="col-lg-10 center">
	<div class="well bs-docs-example">
        <?php
            foreach($sub_dimensoes -> result() as $linha){

            	if ($this->model_perguntas->check_log($linha->codigo,$linha->codigo_dimensao,$this->session->userdata('unidade'),$responsavel) == 1) {
					
					echo '<div class="col-lg-1" ></div><div class="row center">
                    <button class="btn btn-primary" onClick="respondido();" style="background: green; width: 100%;">Sub Dimensão - '.$linha->codigo.' </br>'.$linha->nome.'</button></div>';
				
				}else{

					echo '<div class="col-lg-1" ></div><div class="row center">
                    <button class="btn btn-primary" style="width: 100%;" onClick="parent.location=\''.base_url().'questionario/sub_dimensao/'.$linha->codigo.'/'.$linha->codigo_dimensao.'\'">Sub Dimensão - '.$linha->codigo.' </br>'.$linha->nome.'</button></div>';	
				
				}

            }
        ?>
        <input type="button" name="btnVolta" value="Voltar" onclick="javascript:window.history.back();" class="btn btn-info" />
	</div>
</div>
	
<script type="text/javascript" charset="utf-8">
	function respondido(){
        alert('Esta sub-dimensão já foi respondida!');
    }
</script>