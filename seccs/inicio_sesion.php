<?php
	if(isset($_POST['contrasena'])&&isset($_POST['Nombre']))
	{
		include_once("php/conexion.php");	//Me conecto a la db en la tabla unitec.
		
		$consulta=mysql_query('select Contrasena from usuarios where Nombre="'.$_POST['Nombre'].'"');
		
		if($consulta!=0)
		{
			$consulta=mysql_fetch_array($consulta);
		}
		
		mysql_close($Conexion);
		
		if($consulta==0)
		{
			echo "El usuario no existe.<br>";
		}
		else
		{
			foreach($consulta as $clave => $valor)
			{
				echo "Clave ".$clave." = Valor ".$valor.'<br>';
			}
			if(sha1($_POST['contrasena'])==$consulta['Contrasena'])
			{
				echo "Datos válidos.<br>";
			}
			else
			{
				echo sha1($_POST['contrasena']).' != '.$consulta['Contrasena'];
			}
		}
	}
?>
<section>
	<h2>Login:</h2>;
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
</section>