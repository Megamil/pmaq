<script>
    $(document).ready(function(){
        $("#enviar").click(function(){

            if ($("#regiao").val() == 99){
                alert ("Escolha uma Regional de Saúde para verificar seu resultado");
                return false;
            }
        });

    });
</script>

<div class="col-lg-10 center">
    
    <form name="filtro" method="post" action="retorno_filtro">
        <div class="well bs-docs-example">
          
            <b>Região de Saúde</b> 
                <div class="form-group">
                    
                        <?php 

                            echo '<select name="regionalsaude" id="regiao" class="input-large form-control">';
                            echo '<option value="99">Selecione...</option>';
                            
                            $retorna = $this->model_ubs->retorna_regioes();

                            foreach($retorna as $regiao){
                                echo '<option value= '.$regiao->id_regiao.'>'.$regiao->nome.'</option>';
                            }

                            echo ('</select>');
                        ?>
                   
                </div>
        </div>
        
        <div align="right"><input type="submit" class="btn btn-primary" value="Consultar &rarr;" id="enviar" /></div>

    </form>
</div>