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
            if ($this->session->flashdata('edicaook')) {
                echo'<div class="alert alert-block alert-sucess"><button type="button" class="close" data-dismiss="alert">x</button><p>'.$this->session->flashdata('edicaook').'</p></div>';
            }
                echo '<h1>';
                if (!empty($resposta)){
                    $resposta = $this->session->userdata('resposta');
                    print_r(json_encode(unserialize($resposta)));
                }
                echo "</h1>";
            
         ?>
         <div id="loadcheck"></div>

            <?php 
                echo form_hidden(array(
                    'type'=>'number',
                    'name'=>'codigo_pergunta',
                    'id'=>'codigo_pergunta',
                    'class'=>'form-control',
                    'placeholder'=>'Numero da Questão...'
                ),set_value('codigo_pergunta',$codigo_pergunta));

                echo form_hidden(array(
                    'type'=>'number',
                    'name'=>'codigo_dimensao_sub_dimensao',
                    'id'=>'codigo_dimensao_sub_dimensao',
                    'class'=>'form-control',
                    'placeholder'=>'Numero da Questão...'
                ),set_value('codigo_dimensao_sub_dimensao',$codigo_dimensao_sub_dimensao));

                echo form_hidden(array(
                    'type'=>'number',
                    'step'=>'any',
                    'name'=>'codigo_sub_dimensao',
                    'id'=>'codigo_sub_dimensao',
                    'class'=>'form-control',
                    'placeholder'=>'Defina...'
                ),set_value('codigo_sub_dimensao',$codigo_sub_dimensao));
                $parametros = "$codigo_dimensao_sub_dimensao-$codigo_sub_dimensao-$codigo_pergunta";
            ?>

    <form action="<?php echo base_url();?>questoes/pergunta/<?php echo $parametros; ?>" method="post" class="form" name"alterar_questao" id"alterar_questao">
	<fieldset> 
        <div class="form-group">
            <div class="row">
                <?php echo form_label('Pergunta:','pergunta',$attrLabel); ?>
                <div class="col-lg-10">
                    <?php echo form_textarea(array('style'=>'resize: none; width: 100%; height: 100px;','name'=>'pergunta','id'=>'pergunta','class'=>'form-control','placeholder'=>'Pergunta...'),set_value('pergunta',$pergunta)); ?>
                </div>
                <div class="col-lg-12"><br>
        <!--Adicionado para as questões do múltiplas escolhas-->
         <?php echo form_label('Será de múltipla escolha?:','multipla_escolha',$attrLabel); ?>
            <div class="col-lg-10">
                <?php echo form_input(array('type'=>'checkbox','name'=>'multipla_escolha','id'=>'multipla_escolha'),set_value('multipla_escolha')); ?>
            </div>
        <!--Adicionado para as questões do múltiplas escolhas-->
                    <table class="display table table-striped table-hover table-condensed" id="consultar">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Resposta</th>
                                <th>Valor</th>
                                <th>Considerações</th>
                                <th>Edição</th>
                                <th>Exclusão</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $lastcodigo=0;
                                foreach ($respostas->result() as $resposta) {
                                    $id_ref = "$codigo_pergunta-$codigo_dimensao_sub_dimensao-$codigo_sub_dimensao-$resposta->codigo";
                                    echo '
                                        <tr>
                                            <th>'.$resposta->codigo.'</th>
                                            <th>'.$resposta->resposta.'</th>
                                            <th>'.$resposta->valor.'</th>
                                            <th>'.$resposta->consideracoes.'</th>
                                            <th><a href="#MeuModal'.$id_ref.'" class="label  label-warning" data-toggle="modal">Editar</a></th>
                                            <th><a href="#ModalExcluir'.$id_ref.'" class="label label-danger" data-toggle="modal">Excluir</a></th>
                                        </tr>
                                    ';
//-------------Modal de alerta para alterar alternativa das questões -------------//
                                    echo '<section id="MeuModal'.$id_ref.'" class="modal fade" tabindex="5" role="dialog" aria-labelledby="meuModelLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <header class="modal-header">
                                                <button class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                                <h3 id="meuModelLabel">Alterar Resposta da Questão?</h3>
                                            </header>
                                            <section class="modal-body">
                                                <form action="'.base_url().'questoes/resposta/'.$id_ref.'" method="post">
                                                    <div class="form-group">
                                                        '.form_label('Resposta:', 'resposta',array('class' => 'control-label')).'
                                                        '.form_textarea(array('style'=>'resize: none; width: 100%; height: 100px;','name'=>'resposta','id'=>'resposta','class'=>'form-control'),set_value('resposta',$resposta->resposta)).'
                                                        '.form_label('Valor:','valor',array('class' => 'control-label')).'
                                                        '.form_input(array('class' => 'form-control','name'=>'valor','id'=>'valor'),set_value('valor',$resposta->valor)).'
                                                        '.form_label('Considerações:','consideracoes',array('class' => 'control-label')).'
                                                        '.form_input(array('class' => 'form-control','name'=>'consideracoes','id'=>'consideracoes'),set_value('consideracoes',$resposta->consideracoes)).'                                                    
                                                    </div>
                                            </section>
                                            <footer class="modal-footer">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                                                <button id="submit" class="btn btn-primary">Salvar</button>
                                            </footer>
                                                </form>
                                        </div>  
                                    </div>
                                </section>';
//-------------Modal de alerta para excluir alternativa das questões -------------//
                                    echo '<section id="ModalExcluir'.$id_ref.'" class="modal fade" tabindex="5" role="dialog" aria-labelledby="meuModelLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <header class="modal-header">
                                                        <button class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                                        <h3 id="meuModelLabel">Excluir a Alternativa da Questão?</h3>
                                                    </header>
                                                        <section>

                                                        </section>
                                                    <footer class="modal-footer">
                                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                                                        <a href="'.base_url().'questoes/excluir/'.$id_ref.'" class="btn btn-danger" data-toggle="modal">Excluir</a>
                                                        
                                                    </footer>
                                                </div>  
                                            </div>
                                          </section>'
                                    ;
//--------------Final do Modal de Exclusão --------------------//
                                $lastcodigo++;
                                }
                             ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-2"><br>
                    <?php 
                        echo'<a href="#AddModal'.$lastcodigo.'-'.$resposta->codigo_perguntas.'-'.$resposta->codigo_sub_dimensao_perguntas.'-'.$resposta->codigo_dimensao_sub_dimensao_perguntas.'" class="btn btn-primary" data-toggle="modal">Adicionar Alternativa</a>';
                    ?>
                </div>
                <div class="col-lg-8">
                </div>
                <div class="col-lg-2"><br>
                    <button id="submit" class='btn btn-primary'>Salvar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-2">
                    
                </div>
                <div class="col-lg-5"></div>
            </div>
        </div>
    </fieldset>
    </form>
	</div>
</div>
</div>
<?php
    $attrFormulario = array('class'=>'form', 'nome'=> 'cadastro_usuario');
    $attrLabel = array('class' => 'col-lg-2 control-label');
        echo '<div id="AddModal'.$lastcodigo.'-'.$resposta->codigo_perguntas.'-'.$resposta->codigo_sub_dimensao_perguntas.'-'.$resposta->codigo_dimensao_sub_dimensao_perguntas.'" class="modal fade" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                <h3 id="meuModelLabel">Adicionar Alternativa:</h3><br>
                                <div class="form-group">';
                            echo '<form action="'.base_url().'questoes/alternativa/'.$lastcodigo.'-'.$resposta->codigo_perguntas.'-'.$resposta->codigo_sub_dimensao_perguntas.'-'.$resposta->codigo_dimensao_sub_dimensao_perguntas.'" method="post" class="form" name"cadastro_resposta" id"cadastro_resposta">';
                            echo form_label('Alternativa:','resposta',$attrLabel);
                            echo '<div class="col-lg-10">';
                            echo form_input(array('name'=>'resposta','id'=>'resposta','class'=>'form-control','placeholder'=>'Alternativa...'),set_value('resposta'));
                            echo '</div>';
                            echo form_label('Valor:','valor',$attrLabel);
                            echo '<div class="col-lg-10">';
                            echo form_input(array('type'=>'number','name'=>'valor','id'=>'valor','class'=>'form-control','placeholder'=>'Valor...'),set_value('valor'));
                            echo '</div>
                            ';

                        echo '</div>
                            <div class="modal-footer"><br>
                                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Fechar</button>
                                <button id="submit" class="btn btn-primary">Adicionar </button>

                            </form>
                            </div>                  
                        </div>
                    </div>
              </div>';
?>
<script>
    //Todos scripts dentro de Document.Ready são Jquery 
    $(document).ready(function() {
        var table = $('#consultar').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "oTableTools": {
                "sSwfPath": "/pmaq/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [ 
                    { 
                        "sExtends": "xls",
                        "sButtonText": "Exportar para Excel",
                        "sTitle": "Perguntas",
                        "mColumns": [0, 1, 2, 3]
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "Exportar para PDF",
                        "sTitle": "Pergunta",
                        "sPdfOrientation": "landscape",
                        "mColumns": [0, 1, 2, 3] 
                    } 
                ] 
            },
            "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros por página",
                "sZeroRecords": "Nenhum registro encontrado",
                "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
                "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                "sSearch": "Pesquisar: ",
                "oPaginate": {
                    "sFirst": "Início ",
                    "sPrevious": " Anterior ",
                    "sNext": " Próximo ",
                    "sLast": " Último "
                }
            },
            "aaSorting": [[0, 'desc']],
            "aoColumnDefs": [
                {"sType": "num-html", "aTargets": [0]}
            ]
        });
    });//fim jquery
</script>