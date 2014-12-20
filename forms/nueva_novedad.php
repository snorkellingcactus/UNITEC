<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor_form.css" />
		<link rel="stylesheet" type="text/css" href="nueva_imagen.css" />
	</head>
	<body>
		<?php
			if(session_status()==PHP_SESSION_NONE)
			{
				session_start();
			}
			if($_SESSION['cache']==0)
			{
				$_SESSION['cache']=1;
			}
			else
			{
				$_SESSION['cache']=0;
			}
		?>
		<form action="../index.php#nov" method="POST">
			<h2>Nueva Novedad</h2>					
			Titulo:<input type="text" name="novTitulo" />
			Descripcion:<input type="text" name="novDescripcion" />
			Imagen:<input type="text" name="novImagen" />

			<input type="submit" name="novNueva" value="Ok" />

			<a href="../index.php?cache=<?php echo $_SESSION['cache'] ?>#nov" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" target="_parent">Cancelar</a>
		</form>
	</body>
</html>