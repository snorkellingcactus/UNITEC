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
		<form method="POST" action="../index.php?cache=<?php echo $_SESSION['cache'] ?>#cal" target="_parent">
		<?php
			$iMax=$_SESSION['cantidad'];

			for($i=0;$i<$iMax;$i++)
			{
				?>
				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<label for="Fecha">Fecha:</label>
				</p>
				<div class="fecha col-xs-12 col-sm-8 col-md-8 col-lg-8">
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<label for="Ano">Año</label>
						<input type="number" name="Ano[]"/>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
						<label for="Mes">Mes</label>
						<input type="number" name="Mes[]"/>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
						<label for="Dia">Dia</label>
						<input type="number" name="Dia[]"/>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
						<label for="Hora">Hora</label>
						<input type="number" name="Hora[]"/>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
						<label for="Minuto">Minuto</label>
						<input type="number" name="Minuto[]"/>
					</div>
				</div>

				<div class="clearfix"></div>

				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<label for="Titulo">Titulo:</label>
				</p>
				<input type="text" name="Titulo[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="clearfix"></div>

				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<label for="Descripcion">Descripcion:</label>
				</p>
				<textarea name="Descripcion[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8"></textarea>
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

						for($j=0;$j<$jMax;$j++)
						{
							?>
								<option value="<?php echo $consulta[$j]['ID'] ?>"><?php echo $consulta[$j]['Nombre'] ;?></option>
							<?php
						}
					?>
				</select>
				<div class="clearfix fin"></div>
			<?php
			}
			unset($_SESSION['cantidad']);

			?>
				
			<button type="submit" name="form" value="accionesCal" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Aceptar</button>
		
			<a href="../index.php?cache=<?php echo $cache ?>#cal" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" target="_parent">Cancelar</a>
		</form>
	</body>
</html>