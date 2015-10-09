<div class="col-lg-10 center">
    <div class="well bs-docs-example">
        <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/usuarios.js"></script>
        <?php
            $attrbForm = array('class'=>'form');
            echo form_open('usuarios/editar/'.$usuario->row()->id_cad_users,$attrbForm);
            $attrLabel = array('class' => 'col-lg-2 control-label');
            echo '<fieldset>';
                echo '<div class="form-group">';
                    echo validation_errors('<div class="alert alert-dismissable alert-danger""><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
                        if ($this->session->flashdata('edicaook')){
                            '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('edicaook').'</div>';
                        }

                    echo form_label('Nome do Usuario:','nome',$attrLabel);
                        echo '<div class="col-lg-10">';
                           echo form_input(array('name'=>'exibir','id'=>'exibir','class'=>'form-control','disabled'=>''),set_value('exibir',$usuario->row()->nome),'autofocus');
                           echo form_hidden('nome',$usuario->row()->nome);
                        echo '</div>';
                   
                    echo form_label('Senha de Atual:','senha',$attrLabel);
                        echo '<div class="col-lg-10">';
                            echo form_password(array('name'=>'senha','id'=>'senha','class'=>'form-control'),set_value('senha'));
                        echo '</div>';
                   
                    echo form_label('Confirmação da Nova Senha:','conf_new_senha',$attrLabel);
                        echo '<div class="col-lg-10">';
                            echo form_password(array('name'=>'conf_new_senha','id'=>'conf_new_senha','class'=>'form-control'),set_value('conf_new_senha'));
                        echo '</div>';
        ?>     
    <!-- ======================TIPO DE USUARIO DO SISTEMA =============================================================== -->
                    
        <label id="label_id_grupo_user" class="col-lg-2 control-label">Tipo de Usuário</label>
        <div class="col-lg-10">    
                <select name="id_grupo_user" id="id_grupo_user" class="input-xxlarge form-control">
                    <?php 
                        foreach($tipousuario as $tipo){
                            if($tipo->id_grupo_user == $usuario->row()->id_grupo_user){
                                echo '<option value='.$tipo->id_grupo_user.' selected>'.$tipo->nome_grupo.'</option>';
                            }else{
                                echo '<option value='.$tipo->id_grupo_user.'>'.$tipo->nome_grupo.'</option>';
                            }
                        }
                    ?>
                </select>
        </div >

    <!-- ======================ESCOLHA DA UNIDADE DO USUÁRIO ============================================================= -->
        
        <label id="label_cnes" class="col-lg-2 control-label">Unidade</label>
        <div class="col-lg-10">    
                <select name="cnes" id="cnes" class="input-xxlarge form-control">
                    <option></option>
                    <?php 
                        foreach($unidades as $cnes){

                            if($cnes->cnes_unidade == $usuario->row()->cnes){
                                echo '<option value='.$cnes->cnes_unidade.' selected>'.$cnes->nome_unidade.'</option>';
                            }else{
                                echo '<option value='.$cnes->cnes_unidade.'>'.$cnes->nome_unidade.'</option>';
                            }
                        }
                    ?>
                </select>
        </div >

     <!-- ======================ESCOLHA DA REGIÃO DE SAUDE ============================================================= -->
        <label name="label_regiao" id="label_regiao" class="col-lg-2 control-label">Região</label>
        <div class="col-lg-10">    
                <select name="id_regiao" id="id_regiao" class="input-xxlarge form-control">
                    <option></option>
                    <?php 
                        foreach($regioes as $regiao){

                            if($regiao->id_regiao == $usuario->row()->id_regiao){
                                echo '<option value='.$regiao->id_regiao.' selected>'.$regiao->nome.'</option>';
                            }else{
                                echo '<option value='.$regiao->id_regiao.'>'.$regiao->nome.'</option>';
                            }
                        }
                    ?>
                </select>
        </div >
    <!-- ================================================================================================================= -->
        <?php            
                echo "</div>";
            echo '</fieldset>'; 

                echo "<br/>";
                echo "<div align='center'>";
                    echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary align-center'),'Alterar');
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo '<a href="'.base_url("usuarios/consultar").'" class="btn btn-danger">Cancelar</a>';
                echo "</div>";
        ?>
    </div>
</div>