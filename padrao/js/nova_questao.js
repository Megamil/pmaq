$(document).ready(function() {
    var table = $('#respostas').DataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"lr>t<"F"i>',
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
        }
    });
    var counter = 1;    
        document.getElementById('validator').value = '0';
    $('#addRow').on( 'click', function () {
        table.row.add( [
            '<input type="text" id="codigoaaa'+counter+'" name="codigoaaa'+counter+'" value="'+counter+'">',
            '<input type="text" id="resaaa'+counter+'" name="resaaa'+counter+'">',
            '<input type="text" id="valoraaa'+counter+'" name="valoraaa'+counter+'">',
            '<input type="text" id="consideracoesaaa'+counter+'" name="consideracoesaaa'+counter+'">'
        ] ).draw();        
        document.getElementById('validator').value = counter;
        counter++;
    } );
 	$('#submit').on( 'click', function() {
        var data = table.$('input, select').serialize();
        document.cadastro_questao.submit();
    } );
    $('#respostas tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#remover').on( 'click', function() {
        table.row('.selected').remove().draw( false );
    } );
    $.ajax({
    // url para o arquivo json.php
        url : "http://127.0.0.1:81/questoes/jsonNova",
    // dataType json
        dataType : "json",
    // função para de sucesso
        success : function(data){
            for($i=1, $j=0; $j < data.length; $i++,$j++){

                alert('sdad');
                table.row.add( [
                    '<input type="text" id="codigoaaa'+$i+'" name="codigoaaa'+$i+'" value="'+data[$j].codigoaaa+'">',
                    '<input type="text" id="resaaa'+$i+'" name="resaaa'+$i+'" value="'+data[$j].resaaa+'">',
                    '<input type="text" id="valoraaa'+$i+'" name="valoraaa'+$i+'" value="'+data[$j].valoraaa+'">',
                    '<input type="text" id="consideracoesaaa'+$i+'" name="consideracoesaaa'+$i+'" value="'+data[$j].consideracoesaaa+'">'
                ] ).draw();        
                document.getElementById('validator').value = $i;
                counter = $i;
            }
        }
    });//termina o ajax
} );