<!--Load the AJAX API-->
    <?php $script = '
    <script type="text/javascript">      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(getData'.$unidade.');
    function getData'.$unidade.'() {
        jQuery.ajax({
            url: "'.base_url().'Calcular/dataJson/'.$unidade.'",
            type: "GET",
            dataType: "json",
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function( data'.$unidade.' , jqXHR ) {
                if( data'.$unidade.' == "null" ) {
                    console.log( "error. damm." );
                } else {
                    drawGraph'.$unidade.'( data'.$unidade.' );
                }
            },
            error: function( textStatus ) {
                console.log( "error. damm." );
            }
        });
    }
    function drawGraph'.$unidade.'( data'.$unidade.' ) {
        for(var i = data'.$unidade.'.length; i > 0; i--) {
            data'.$unidade.'[i] = data'.$unidade.'[i - 1];
        }
        data'.$unidade.'[0] = ["Dimensão", "Resultado(em %)"];
        console.log(data'.$unidade.');
        var chartData'.$unidade.' = google.visualization.arrayToDataTable( data'.$unidade.' );

        var options'.$unidade.' = {
            title: "Resultador por dimensão",
            subTitle:"Representa a porcentagem do total possivel.",
            chartArea: {width: "50%"},
            hAxis: {
                title: "Resultador por dimensão",
                minValue: 0,
                maxValue:100
            },
            vAxis: {
                title: "Dimensões"
            }
        };

        var chart'.$unidade.' = new google.visualization.BarChart( document.getElementById( "chart'.$unidade.'" ) );

        chart'.$unidade.'.draw( chartData'.$unidade.' , options'.$unidade.' );
    }
</script>'; 
print_r($script)?>
<div class="row">        
    <div class="col-lg-1"></div>
    <div class="col-lg-10 center">
        <div class="well bs-docs-example">
            <h1><?php print_r($this->model_ubs->get_unidade($unidade)); ?></h1>
            <?php echo '<div id="chart'.$unidade.'"></div>'; ?>
        </div>
    </div>
</div>  