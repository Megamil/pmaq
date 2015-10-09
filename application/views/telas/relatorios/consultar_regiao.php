</div>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    google.load("visualization", "1", {"packages":["corechart"]});
    
    </script>
    <?php
        foreach ($ubs_regiao as $linha) {
            $resultado = $this->model_perguntas->checkLogResultadosUnidade($linha->id_unidade);
            if ($resultado != NULL) {
                $array = array (
                    'por_dimensao' => unserialize($resultado->json_ref),
                    'log' => 1
                );          
                $this->session->set_userdata($array);
                $dados = array (
                    'titulo' => 'Sistema do PMAQ',
                    'tela' => 'questionario/visualizando',
                    'dados' => $array['por_dimensao'],
                    'unidade' => $linha->id_unidade
                );
                $this->load->view('telas/questionario/visualizando2', $dados);
            }
        }
    ?>
    <div>