<div class="col-lg-10 center">
    <div class="well bs-docs-example">
    	<?php 
    		$atribForm = array ('class'=>'form-horizontal');
    			echo form_open("usuarios/editar/$usuario->id_cad_users",$atribForm);
    		$attr_label = array ('class' => 'col-lg-2 control-label',);
    		
    		echo "<div class=\"form-group\">";

				echo validation_errors('<div class="alert alert-dismissable alert-danger""><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
					if ($this->session->flashdata('edicaook')) {
						echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('edicaook').'</div>';
					}
				
				echo form_label('Nome do Usuario', 'nome', $attr_label);
					echo "<div class=\"col-lg-10\">";
						echo form_input(array('name' => 'nome','id' => 'nome', 'class' => 'form-control'),set_value('nome',$usuario->nome),'autofocus');
					echo "</div>";

				echo form_label('Senha Atual', 'senha', $attr_label);
					echo "<div class=\"col-lg-10\">";
						echo form_password(array('name' => 'senha', 'id'=> 'senha', 'class' => 'form-control'),set_value('senha',$usuario->senha));
					echo "</div>";
					
				echo form_label('Nova Senha', 'new_senha', $attr_label);
					echo "<div class=\"col-lg-10\">";
						echo form_password(array('name' => 'new_senha', 'id'=> 'new_senha', 'class' => 'form-control'),set_value('new_senha');
					echo "</div>";
					
				echo form_label('Confirmação da Nova Senha', 'conf_new_senha', $attr_label);
					echo "<div class=\"col-lg-10\">";
						echo form_password(array('name' => 'conf_new_senha', 'id'=> 'conf_new_senha', 'class' => 'form-control'),set_value('conf_new_senha');
					echo "</div>";
					
			echo "</div>";
		
			echo "<div class=\"col-lg-5\">";

				echo "</div>";
						
					echo "<div class=\"col-lg-2\">";
					    echo form_submit(array ('name' => 'cadastrar', 'class' => 'btn btn-primary align-center'),'Alterar');
					echo "</div>";
					
					echo "<div class=\"col-lg-2\">";
						echo '<a href="'.base_url("usuarios/consultar").'" class="btn btn-danger">Cancelar</a>'; 
					echo "</div>";
		?>
	</div>