<?php
    $attrFormulario = array('class'=>'form', 'nome'=> 'cadastro_usuario');
    $attrLabel = array('class' => 'col-lg-2 control-label');
?>

<div class="col-lg-10 center">
	<div class="well bs-docs-example">
        <?php 
            echo validation_errors('<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>','</p></div>');
            if($this->session->userdata('cadastro_ok')){
                echo'<p>'.$this->session->userdata('cadastro_ok').'</p>';
            }
                echo '<h1>';
                if (!empty($resposta)){
                    $resposta = $this->session->userdata('resposta');
                    print_r(json_encode(unserialize($resposta)));
                }
                echo "</h1>";
            
         ?>
         <div id="loadcheck"></div>
    <form action="<?php echo base_url();?>questoes/nova" method="post" class="form" name"cadastro_questao" id"cadastro_questao">
	<fieldset>
        <div class="form-group">
        <!--Adicionado para as questões do múltiplas escolhas-->
         <?php echo form_label('Será de múltipla escolha?:','multipla_escolha',$attrLabel); ?>
            <div class="col-lg-10">
                <?php echo form_input(array('type'=>'checkbox','name'=>'multipla_escolha','id'=>'multipla_escolha'),set_value('codigo_pergunta')); ?>
            </div>
        <!--Adicionado para as questões do múltiplas escolhas-->
            <?php echo form_label('Numero da Questão:','codigo_pergunta',$attrLabel); ?>
            <div class="col-lg-10">
                <?php echo form_input(array('type'=>'number','name'=>'codigo_pergunta','id'=>'codigo_pergunta','class'=>'form-control','placeholder'=>'Numero da Questão...'),set_value('codigo_pergunta')); ?>
            </div>
            <?php echo form_label('Pergunta:','pergunta',$attrLabel); ?>
            <div class="col-lg-10">
                <?php echo form_input(array('name'=>'pergunta','id'=>'pergunta','class'=>'form-control','placeholder'=>'Pergunta...'),set_value('pergunta')); ?>
            </div>
            <?php echo form_label('Percentual da Sub-dimensão:','percentual_subdimensao',$attrLabel); ?>
            <div class="col-lg-10">
                <?php echo form_input(array('type'=>'number', 'step'=>'any', 'name'=>'percentual_subdimensao','id'=>'percentual_subdimensao','class'=>'form-control','placeholder'=>'Percentual na Sub Dimensão...'),set_value('percentual_subdimensao')); ?>
            </div>
            <?php echo form_label('Percentual Externo:','percentual_externa',$attrLabel); ?>
            <div class="col-lg-10">
                <?php echo form_input(array('type'=>'number', 'step'=>'any', 'name'=>'percentual_externa','id'=>'percentual_externa','class'=>'form-control','placeholder'=>'Percentual Externo...'),set_value('percentual_externa')); ?>
                <input type="hidden" name="validator" id="validator" value="0">
            </div>
            <?php echo form_label('Dimensão da pergunta:','codigo_dimensao_sub_dimensao',$attrLabel); ?>
            <div class="col-lg-10">
                <?php  
                    $attr = 'id="codigo_dimensao_sub_dimensao" class="input-xxlarge form-control"';
                    $options= array('0'=> 'Selecione...','1' => 'Dimensão I','2' => 'Dimensão II','3'=>'Dimensão III', '4'=>'Dimensão IV', '5'=>'Dimensão V');
                    echo form_dropdown('codigo_dimensao_sub_dimensao',$options,'',$attr);
                ?>
            </div>
            <?php echo form_label('Sub Dimensão da pergunta:','codigo_sub_dimensao',$attrLabel); ?>
            <div class="col-lg-10">
                <?php echo form_input(array('type'=>'number', 'step'=>'any', 'name'=>'codigo_sub_dimensao','id'=>'codigo_sub_dimensao','class'=>'form-control','placeholder'=>'Defina...'),set_value('codigo_sub_dimensao')); ?>
            </div>
            <div class="col-lg-12"><br>
                <table id="respostas" class="display" cellspacing="0" width="100%" border="2px">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Resposta</th>
                            <th>Valor</th>
                            <th>Considerações</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-lg-2"><br>
                <a id="addRow" class='btn btn-success'>Adicionar Resposta</a>
            </div>
            <div class="col-lg-2"><br>
                <a id="remover" class='btn btn-danger'>Remover Resposta</a>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2"><br>
                <button id="submit" class='btn btn-primary'>Salvar</button>
            </div>
        </div>
    </fieldset>
    </form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/nova_questao.js"></script>