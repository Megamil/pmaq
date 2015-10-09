<div class="col-lg-10 center">
    <div class="well bs-docs-example">
        <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/usuarios.js"></script>
        <?php
            $attrFormulario = array('class'=>'form', 'nome'=> 'cadastro_usuario');
            echo form_open('usuarios/cadastrar',$attrFormulario);
            $attrLabel = array('class' => 'col-lg-2 control-label');
            echo '<fieldset>';
                echo '<div class="form-group">';
                    echo validation_errors('<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>','</p></div>');
                        if ($this->session->flashdata('cadastro_ok')){
                            echo'<p>'.$this->session->flashdata('cadastro_ok').'</p>';
                        }

                    echo form_label('Nome do Usuario:','nome',$attrLabel);
                        echo '<div class="col-lg-10">';
                           echo form_input(array('name'=>'nome','id'=>'nome','class'=>'form-control','placeholder'=>'Nome do Usuario...'),set_value('nome'));
                        echo '</div>';
                   
                    echo form_label('Senha de Acesso:','senha',$attrLabel);
                        echo '<div class="col-lg-10">';
                            echo form_password(array('name'=>'senha','id'=>'senha','class'=>'form-control','placeholder'=>'Senha do Usuario...'),set_value('senha'));
                        echo '</div>';
                   
                    echo form_label('Confirmação de Senha:','senha2',$attrLabel);
                        echo '<div class="col-lg-10">';
                            echo form_password(array('name'=>'senha2','id'=>'senha2','class'=>'form-control','placeholder'=>'Confirmação de Senha...'),set_value('senha2'));
                        echo '</div>';
             
//=========================================================TIPO DE USUARIO DO SISTEMA ===============================================================//       
                    echo form_label('Tipo de Usuario:','label_id_grupo_user',$attrLabel);
                        echo '<div class="col-lg-10">';

                            $attr = 'name="id_grupo_user" id="id_grupo_user" class="input-xxlarge form-control"';
                            $grupo = array($grupo[0] = 'Selecione...');

                            foreach($tipousuario as $tipo){
                                $grupo[$tipo->id_grupo_user] = $tipo->nome_grupo;
                            }

                            echo form_dropdown('id_grupo_user',$grupo,'',$attr);
                        echo '</div>';
                
//=========================================================ESCOLHA DA UNIDADE DO USUÁRIO =============================================================//
                    echo form_label('Unidade:','cnes',array('class' => 'col-lg-2 control-label','id'=>'label_cnes'),$attrLabel);
                        echo '<div class="col-lg-10">';

                            $attr = 'id="cnes" class="input-xxlarge form-control"';
                            $id_unidade = array($id_unidade[0] = 'Selecione...');

                            foreach($unidades as $cnes){
                                $id_unidade[$cnes->cnes_unidade] = $cnes->nome_unidade;
                            }
                            echo form_dropdown('cnes',$id_unidade,'',$attr);
                        echo '</div>';

//=========================================================ESCOLHA DA REGIÃO DE SAUDE ================================================================//
                    echo form_label('Região:','id_regiao',array('class' => 'col-lg-2 control-label','id' => 'label_regiao'),$attrLabel);
                        echo '<div class="col-lg-10">';

                            $attr = 'id="id_regiao" class="input-xxlarge form-control"';
                            $id_regiao = array($id_regiao[0] = 'Selecione...');

                            foreach($regioes as $regiao){
                                $id_regiao[$regiao->id_regiao] = $regiao->nome;
                            }
                            echo form_dropdown('id_regiao',$id_regiao,'',$attr);
                        echo '</div>';
//====================================================================================================================================================//    
                    
                    echo "<div class='col-lg-2'> <br> ";
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary aling-center form-control'),'Cadastrar');
                    echo "</div>";
            echo '</div>
            </fieldset>'; 
        ?>
    </div>
</div>

