<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor_form.css" />
		<link rel="stylesheet" type="text/css" href="nueva_novedad.css" />

		<!-- Load jQuery  -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

		<!-- Load WysiBB JS and Theme -->
		<script src="http://cdn.wysibb.com/js/jquery.wysibb.min.js"></script>
		<link rel="stylesheet" href="http://cdn.wysibb.com/css/default/wbbtheme.css" />

		<!-- Init WysiBB BBCode editor -->
		<script>
		$(function()
			{
				$("#editor").wysibb();
			}
		 )
		</script>
	</head>
	<body>
		<?php
			if(session_status()==PHP_SESSION_NONE)
			{
				session_start();
			}
			$cache=$_SESSION['cache'];
		?>
		<form action="../index.php?cache=<?php echo $_SESSION['cache'] ?>#nov" method="POST" target="_parent">			
			<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label for="Titulo">Titulo:</label>
			</p>
			<input type="text" name="novTitulo" class="col-xs-12 col-sm-8 col-md-8 col-lg-8"/>
			<div class="clearfix"></div>

			<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label for="Descripcion">Descripcion:</label>
			</p>
			<div class="clearfix"></div>
			<textarea id="editor" name="novDescripcion" class="col-xs-12 col-sm-8 col-md-8 col-lg-8" rows='7'/></textarea>
			<div class="clearfix"></div>

			<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label for="Imagen">Imagen:</label>
			</p>
			<div class="overhidden">
				<?php
					include_once '../php/conexion.php';

					$Imgs=$con->query('select * from Imagenes where 1');
					$Imgs=$Imgs->fetch_all(MYSQLI_ASSOC);

					$cantidad=count($Imgs);

					if($cantidad)
					{

						for($i=0;$i<$cantidad;$i++)
						{
							$Img=$Imgs[$i];
							?>
								<div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">
									<input name="novImagen" type="radio" value="<?php echo $Img['ID'] ?>" <?php if($i===0){echo 'checked="checked"';}?> />
									<img src="<?php echo $Img['Url']?>" />
								</div>
							<?php
						}
					}
				?>
			</div>
			<div class="clearfix"></div>

			<button type="submit" name="novNueva" class="col-xs-6 col-sm-6 col-md-6 col-lg-6"/>
			Aceptar
			</button>

			<a href="../index.php?cache=<?php echo $cache ?>#nov" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" target="_parent">Cancelar</a>
		</form>
	</body>
</html>