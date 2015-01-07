<?php
	if(session_status()==PHP_SESSION_NONE)
	{
		session_start();
	}

	$cache=$_SESSION['cache'];
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor_form.css" />
		<link rel="stylesheet" type="text/css" href="nueva_imagen.css" />
	</head>
	<body>
		<form method="POST" action="../index.php?cache=<?php echo $_SESSION['cache'] ?>#gal" target="_parent">
		<?php
			$iMax=$_SESSION['cantidad'];

			for($i=0;$i<$iMax;$i++)
			{
				?>
				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<label for="Titulo">Titulo:</label>
				</p>
				<input type="text" name="Titulo[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="clearfix"></div>
			
				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<label for="Url">Url:</label>
				</p>
				<input type="text" name="Url[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="clearfix"></div>
			
				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">		
					<label for="Alt" >Alt:</label>
				</p>
				<input type="text" name="Alt[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="clearfix"></div>
			
				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">		
					<label for="Lenguaje">Lenguaje:</label>
				</p>
				<select name="Lenguaje[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<?php
						include_once('../php/conexion.php');

						$consulta=$con->query('select * from Lenguajes');
						$consulta=$consulta->fetch_all(MYSQLI_ASSOC);

						$jMax=count($consulta);

						for($j=0;$j<$iMax;$j++)
						{
							?>
								<option value="<?php echo $consulta[$j]['ID'] ?>"><?php echo $consulta[$j]['Nombre'] ?></option>
							<?
						}
					?>
				</select>
				<div class="clearfix"></div>
			
				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">	
					<label for="Comentarios">Comentarios:</label>
				</p>
				<input type="text" name="Comentarios[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="clearfix fin"></div>
			<?php
			}

			unset $_SESSION['cantidad'];
			?>
				
			<button type="submit" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Aceptar</button>
		
			<a href="../index.php?cache=<?php echo $cache ?>#gal" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" target="_parent">Cancelar</a>
		</form>
	</body>
</html>