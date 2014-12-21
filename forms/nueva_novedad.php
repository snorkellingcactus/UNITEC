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
			$cache=!$_SESSION['cache'];
		?>
		<form action="../index.php#nov" method="POST">			
			<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label for="Titulo">Titulo:</label>
			</p>
			<input type="text" name="novTitulo" class="col-xs-12 col-sm-8 col-md-8 col-lg-8"/>
			<div class="clearfix"></div>

			<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label for="Descripcion">Descripcion:</label>
			</p>
			<input type="text" name="novDescripcion" class="col-xs-12 col-sm-8 col-md-8 col-lg-8"/>
			<div class="clearfix"></div>

			<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label for="Imagen">Imagen:</label>
			</p>
			<input type="text" name="novImagen" class="col-xs-12 col-sm-8 col-md-8 col-lg-8"/>
			<div class="clearfix"></div>

			<button type="submit" name="novNueva" class="col-xs-6 col-sm-6 col-md-6 col-lg-6"/>
			Aceptar
			</button>

			<a href="../index.php?cache=<?php echo $cache ?>#nov" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" target="_parent">Cancelar</a>
		</form>
	</body>
</html>