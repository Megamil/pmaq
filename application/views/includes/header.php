<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Sistema de Acamados"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>padrao/img/favicon.ico"/>
	<title><?php echo $titulo; ?></title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Link's para CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/bootstrap-material.min.css" media="screen" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>/padrao/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/jquery.dataTables.min.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/jquery.dataTables_themeroller.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/bootstrap-multiselect.css" type="text/css"/>
		<link href="<?php echo base_url(); ?>padrao/css/estilo.css" rel="stylesheet">

	
	<!-- Link's para JS -->
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>/padrao/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
	 	<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/bootstrap-multiselect.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/maskedinput.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/additional-methods.js"></script>
       

       <?php header('Access-Control-Allow-Origin: *'); ?>

</head>

<!--Barra superior fixa-->
	<div class="navbar navbar-fixed-top navbar-inverse">
				<!-- essa classe é usada como aldenador para o conteudo colapsavel -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			    </button>
			    <a class="navbar-brand" href=<?php echo base_url(); ?>>Inicio</a>
			</div>
				<!--Tudo que for escondido a menos de 940px-->
				<div class="navbar-collapse collapse navbar-inverse-collapse">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Questionário
							<b class="caret"></b></a> <!--Seta de expansão-->
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo base_url('questionario/iniciar'); ?>">Iniciar uma nova resolução</a>
								</li>
							</ul>
						</li>
						<li class=" dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">Questões
							<b class="caret"></b></a> <!--Seta de expansão-->
												
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo base_url('questoes/nova')?>">Cadastrar Questões</a>
								</li>
								<li>
									<a href="<?php echo base_url('questoes/consultar')?>">Consultar/Alterar</a>
								</li>
							</ul>

						</li>
						<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							Usuários
							<b class="caret"></b></a> <!--Seta de expansão-->
												
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo base_url('usuarios/cadastrar')?>">Cadastrar</a>
								</li>
								<li>
									<a href="<?php echo base_url('usuarios/consultar')?>">Consultar/Alterar</a>
								</li>
								<li>
									<a href="<?php echo base_url('usuarios/filtro_permissao')?>">Permissões</a>
								</li>
							</ul>

						</li>

						<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							Relatório
							<b class="caret"></b></a> <!--Seta de expansão-->
												
							<ul class="dropdown-menu">
								<!-- <li><a href="<?php echo base_url('relatorios/geral')?>">Todos</a></li> -->
								<li><a href="<?php echo base_url('questionario/consultar_respondidos'); ?>">Consultar Respondidos pelo Usuário Atual</a></li>
								<li><a href="<?php echo base_url('questionario/resultado'); ?>">Consultar Resultados</a></li>
								<?php if($this->session->userdata('user_group') != 3) { echo "<li><a href=".base_url('relatorios/consultar_resultados').">Resultados por unidade</a></li>"; } ?>
								<?php if($this->session->userdata('user_group') != 3) { echo "<li><a href=".base_url('relatorios/regiao').">Resultados por região</a></li>"; } ?>
								<li><a href="<?php echo base_url('relatorios/relatorio_subdimensoes')?>">Resultados por Sub dimensão</a></li>
							</ul>

						</li>
					</ul> <!-- finaliza a primeira parte do menu -->
			<!-- INICIO IDENTIFICACAO DO TIPO DO USUÁRIO -->
					<div class="navbar-header">	
						<ul class="nav navbar-nav">
					      	<li>
								<?php 
									$logado = $this->model_users->grupopermissao();

									foreach ($logado as $grupo){

										if ($grupo->id_grupo_user == $this->session->userdata('user_group')){
											echo '<a href:"#">Tipo usuário: '.$grupo->nome_grupo.'</a>';
										}

									}
								?>
							</li>
						</ul>
					</div>	
			<!-- FINAL IDENTIFICACAO DO TIPO DO USUÁRIO -->		

						<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="<?php echo base_url('login/asenha');?>">ALTERAR SENHA</a>
						</li>

						<li>
							<a href="<?php echo base_url('login/logoff');?>">SAIR &nbsp&nbsp&nbsp</a>
						</li>
						</ul>
				</div>
	</div>
	
	<!-- Cabeçalho -->
		<!--Cabeçalho copiado da Globo Bootstrap-->
	<header class="jumbotron subhead" id="overview">
		<div class="container">
			<h2 style="text-align:center; text-shadow: 3px  3px 5px black;"> 

				<?php 

					if($titulo != '') {

						echo '<font color ="ffffff">'.$titulo.'</font>';

					} else {

						echo '<font color ="ffffff">Programa de Melhoria do Acesso e da Qualidade da Atenção Básica</font>';

					}
				?>
				
			</h2>
		</div>
	</header>

<body>

<div class="row">
	<div class="col-lg-1"></div>
<!-- ////////////////////////////////////////////////////////////Final do header//////////////////////////////////////////////////////////////////-->