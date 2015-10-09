<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/jquery-ui.css">
<script src="<?php echo base_url(); ?>padrao/js/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#accordion" ).accordion({
            collapsible: true,
            heightStyle: "content"
        });
    });
</script>
<div class="col-lg-10 center">
    <div class="well bs-docs-example">
        <!-- Painel Callapsavel Inicio -->
        <div id="accordion">
            <?php
                foreach($respondidos -> result() as $linha){
                    $dimesoes = $this->model_perguntas->obter_dimensao($linha->id_unidade_unidade);
                    $sub_dimensoes = $this->model_perguntas->obter_sub_dimensao($linha->id_unidade_unidade);
                    echo '<h3>' . $linha->nome_unidade . '</h3>';
                    echo '<div>';
                    foreach($dimesoes->result() as $dimensao){
                        echo '  
                        <script>

                        $(function() { 
                            $("#accordion'.$linha->id_unidade_unidade.'-'.$dimensao->id_dimensao.'" )
                            .accordion({  
                                collapsible: true,
                                heightStyle: "content"   
                            });  
                        });

                        </script>';

                        echo '
                        <div id="accordion'.$linha->id_unidade_unidade.'-'.$dimensao->id_dimensao.'">
                            <h3>Dimensão '.$dimensao->id_dimensao.'-'.$dimensao->dimensao.'</h3>
                                <div>';
                        foreach($sub_dimensoes->result() as $sub_dimensao) {
                            $perguntas = $this->model_perguntas->obter_pergunta_resposta($linha->id_unidade_unidade,$sub_dimensao->id_sub_dimensao,$dimensao->id_dimensao);
                                echo '  <script>
                                            $(function() { 
                                                $("#accordion'.$dimensao->id_dimensao.'-'.$linha->id_unidade_unidade.'-'.$sub_dimensao->id_sub_dimensao.'")
                                                .accordion({  
                                                    collapsible: true, 
                                                    heightStyle: "content"   
                                                });  
                                            });
                                        </script>

                                        <div id="accordion'.$dimensao->id_dimensao.'-'.$linha->id_unidade_unidade.'-'.$sub_dimensao->id_sub_dimensao.'">
                                            <h3>Sub-Dimensão '.$sub_dimensao->id_sub_dimensao.'-'.$sub_dimensao->sub_dimensao.'</h3>
                                                <div>';
                                                foreach($perguntas->result() as $pergunta) {
                                                    echo '<p>' . $pergunta->pergunta . ' -> ' . $pergunta->resposta . '</p></br>';
                                                }
                                echo '          </div>
                                        </div>';
                        }

                        echo '  </div>
                        </div>';
                    }
                    echo'</div>';
                }
            ?>
        </div>
        <!-- Painel Callapsavel Fim -->
    </div>
</div>
</div>
</div>
<div class="col-lg-1"></div>
<div class="row">
    <div class="col-lg-10 center">
        <div class="well bs-docs-example">
            <div id="tabs-1">
                <table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
                    <thead> 
                        <tr>
                            <th class="span3">Unidade</th>
                            <th class="span3">Dimensão</th>
                            <th class="span3">Sub Dimensão</th>
                            <th class="span2">Pergunta</th>
                            <th class="span3">Resposta</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($respondidos -> result() as $linha){
                        $dimesoes = $this->model_perguntas->obter_dimensao($linha->id_unidade_unidade);
                        $sub_dimensoes = $this->model_perguntas->obter_sub_dimensao($linha->id_unidade_unidade);
                        foreach($dimesoes->result() as $dimensao){                            
                            foreach($sub_dimensoes->result() as $sub_dimensao) {
                                $perguntas = $this->model_perguntas->obter_pergunta_resposta($linha->id_unidade_unidade,$sub_dimensao->id_sub_dimensao,$dimensao->id_dimensao);
                                foreach($perguntas->result() as $pergunta) {
                                    echo "<tr class='gradeA'>";
                                    echo "<td><center>$linha->nome_unidade</center></td>";
                                    echo "<td><center>$dimensao->id_dimensao-$dimensao->dimensao</center></td>";
                                    echo "<td><center>$sub_dimensao->id_sub_dimensao-$sub_dimensao->sub_dimensao</center></td>";
                                    echo "<td><center>$pergunta->pergunta</center></td>";
                                    echo "<td><center>$pergunta->resposta</center></td>";
                                }
                            }
                        }
                    }
                     ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
//Todos scripts dentro de Document.Ready são Jquery 
$(document).ready(function() { 
    $('#consultar_usuarios').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"Tlfr>t<"F"ip>',
        "oTableTools": {
            "sSwfPath": "/pmaq/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
            "aButtons": [ 
                { 
                    "sExtends": "xls",
                    "sButtonText": "Exportar para Excel",
                    "sTitle": "Questoes Respondidas",
                    "mColumns": [0, 1, 2]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "Exportar para PDF",
                    "sTitle": "Questoes Respondidas",
                    "sPdfOrientation": "landscape",
                    "mColumns": [0, 1, 2] 
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