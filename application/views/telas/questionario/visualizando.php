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
<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
      // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(getData);
    function getData() {
        jQuery.ajax({
            url: <?php echo "'".base_url().'Calcular/dataJson/'.$unidade."'"; ?>,
            type: 'GET',
            dataType: 'json',
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function( data , jqXHR ) {
                if( data == "null" ) {
                    // just in case
                } else {
                    drawGraph( data );
                }
            },
            error: function( textStatus ) {
                console.log( "error. damm." );
            }
        });
    }
    function drawGraph( data ) {
        for(var i = data.length; i > 0; i--) {
            data[i] = data[i - 1];
        }
        data[0] = ['Dimensão', 'Resultado(em %)'];
        console.log(data);
        var chartData = google.visualization.arrayToDataTable( data );

        var options = {
        title: 'Resultador por dimensão',
        subTitle:'Representa a porcentagem do total possivel.',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Resultador por dimensão',
          minValue: 0,
          maxValue:100
        },
        vAxis: {
          title: 'Dimensões'
        }
      };

        var chart = new google.visualization.BarChart( document.getElementById( 'chart_div' ) );

        chart.draw( chartData , options );
    }
</script>  
<div id="accordion">      
    <div class="col-lg-10 center">
    	<div class="well bs-docs-example">
            <div class="col-lg-4">  </div>
                <h1><?php print_r($this->model_ubs->get_unidade($unidade)); ?></h1>
                 <div id="chart_div"></div>
                     <?php 
                        $attrFormulario = array('class'=>'form', 'nome'=> 'cadastro_usuario');
                        $attrLabel = array('class' => 'col-lg-2 control-label');
                        echo validation_errors('<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>','</p></div>');
                        if($this->session->userdata('cadastro_ok')){
                            echo'<p>'.$this->session->userdata('cadastro_ok').'</p>';
                        }
                        if ($data = $this->session->userdata('log')!=1) {
                            echo form_open('calcular/salvar');
                            echo form_hidden('id_unidade', $unidade);
                            echo form_hidden('responsavel', $this->session->userdata('responsavel'));
                            echo form_hidden('valores', 'dados');
                            echo '<div class="col-lg-4"></div><div class="col-lg-2"><input type="button" name="btnVolta" value="Voltar" onclick="javascript:window.history.back();" class="btn btn-info" /></div>';
                            echo '<div class="col-lg-2">';
                            echo form_submit('salvar', 'Gravar Resultado','class = "btn btn-primary"');
                            echo '</div>';
                        }
                     ?>
        </div>
    </div>
</div>