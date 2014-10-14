<?php
include	'php/conexion.php';
	if(isset($_POST['contrasena'])&&isset($_POST['Nombre']))
	{
		$consulta=$con->query('select * from Usuarios where Contrasena="'.sha1($_POST['contrasena']).'"');
		
		if($con->affected_rows>0)
		{
			$consulta=$consulta->fetch_all(MYSQLI_NUM)[0];
		}
		else
		{
			echo "El usuario no existe.<br>";
			echo sha1($_POST['contrasena']);
		}
	}
?>
<div class="container-fluid" style="padding: 0">
<div class="cacho col-xs-10 col-sm-9 col-md-7 col-lg-7"> 
	<h2>Login:</h2>
	<form method="POST" action="#">
		<p class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
			<label for='Nombre (o email)'>Nombre:</label>
		</p>
		<input type='text' name='Nombre' class='col-xs-12 col-sm-7 col-md-7 col-lg-7'/>
		<div class="clearfix"></div>
		<p class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
			<label for='Contraseña'>Contraseña:</label>
		</p>
		<input type='password' name='contrasena' class='col-xs-12 col-sm-7 col-md-7 col-lg-7'/>
		<div class="clearfix col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
		<button type='submit' class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>0K</button>
	</form>
</div>
</div>