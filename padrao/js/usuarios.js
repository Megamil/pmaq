$(document).ready(function() {
        $('#id_regiao').attr('disabled', 'disabled');
        $('#label_regiao').attr('disabled', 'disabled');
        $('#cnes').attr('disabled', 'disabled');
        $('#label_cnes').attr('disabled', 'disabled');
                habilitarperfil();
        $('#id_grupo_user').change(function() {
                habilitarperfil();

        });

       function habilitarperfil(){
        if ($('#id_grupo_user').val()==0 || $('#id_grupo_user').val()==1 || $('#id_grupo_user').val()==2 ) {

                $('#id_regiao').attr('disabled', 'disabled');
                $('#label_regiao').attr('disabled', 'disabled');
                $('#cnes').attr('disabled', 'disabled');
                $('#label_cnes').attr('disabled', 'disabled');

        }else if ($('#id_grupo_user').val()==4){

                $('#id_regiao').removeAttr("disabled");
                $('#label_regiao').removeAttr("disabled");
                $('#cnes').attr('disabled', 'disabled');
                $('#label_cnes').attr('disabled', 'disabled');

        }else{

                $('#id_regiao').attr('disabled', 'disabled');
                $('#label_regiao').attr('disabled', 'disabled');
                $('#cnes').removeAttr("disabled");
                $('#label_cnes').removeAttr("disabled");

        };
        }
})
