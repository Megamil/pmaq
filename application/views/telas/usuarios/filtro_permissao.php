<div class="col-lg-10 center">
    <?php echo form_open('usuarios/permissao'); ?>
    <!-- <form name="filtro" method="post" action="usuarios/permissao"> -->
        <div class="well bs-docs-example">
          
            <b>Grupo de Usuários</b> 
                <div class="form-group">
                    
                        <?php 

                            echo '<select name="grupo_user" id="grupo_user" class="input-large form-control">';
                            echo '<option value="">Selecione...</option>';

                            $retorna = $this->model_users->tipousuario();

                            foreach($retorna as $grupo){
                                echo '<option value="'.$grupo->id_grupo_user.'">'.$grupo->nome_grupo.'</option>';
                            }

                            echo ('</select>');
                        ?>
                   
                </div>
        </div>
        
        <div align="right"><input type="submit" class="btn btn-primary" value="Avançar &rarr;" id="enviar" /></div>

    </form>
</div>