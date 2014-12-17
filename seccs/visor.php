<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Un visor de imágenes con comentarios." />

		<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="visor.css" />
		<link rel="stylesheet" type="text/css" href="visor_form.css" />

		<title>Visor de imágenes</title>
	</head>
	<body>
<?php

	include_once '../php/conexion.php';
	include_once '../php/SQL_Obj.php';
	include_once '../php/Img.php';
	include_once '../php/Coment.php';
	include_once '../php/Gal_HTML.php';
	include_once '../php/Gal_HTML_Visor.php';
	include_once '../php/NULL_Gen_HTML.php';

	//Si todavía no se inicio sesion, se inicia.
	if(session_status()==PHP_SESSION_NONE)
	{
		session_start();
	}

	//Variable utilizada para corregir un error con enlaces que contienen
	//anclas y variables get. Si el enlace es siempre el mismo, no refresca
	//el código PHP. La variable cache alterna entre 0 y 1 para evitar el problema.
	$_SESSION['cache']=!$_SESSION['cache'];

	//Operaciones cuando se llenó un formulario de nuevo comentario.
	if(!empty($_POST['comContenido']))
	{
		//Include necesario para manejar llaves foráneas.
		include_once '../php/Contenido.php';
		include_once '../php/Foraneas.php';

		//Creo un objeto comentario.
		$Comentario=new Coment
		(
			$con,
			[
				'GrupoID'=>$_SESSION['vImgID']
			]
		);
		//Indico que tiene como foráneo un objeto Contenido.
		$Comentario->insForaneas
		(
			new Contenido
			(
				$con,
				[
					'Contenido'=>htmlentities($_POST['comContenido'])
				]
			),
			[
				'Contenido'=>'ID'
			]
		);

		if(isset($_POST['comNomUsuario']))
		{
			$Comentario->NombreUsuario=htmlentities($_POST['comNomUsuario']);
		}
		if(isset($_SESSION['comResID']))
		{
			$Comentario->GrupoRes=$_SESSION['comResID'];

			$con->query('update `Comentarios` set Respondido=1 where ID='.$_SESSION['comResID']);

			unset($_SESSION['comResID']);
		}
		//Inserto el comentario en la BD.
		$Comentario->insSQL();
	}
	else
	{
		if(isset($_SESSION['comResID']))
		{
			unset($_SESSION['comResID']);
		}
	}

	//Elimino comentarios seleccionados.
	if(isset($_POST['comID']))
	{
		if(isset($_POST['elimina']))
		{
			$iMax=count($_POST['comID']);

			for($i=0;$i<$iMax;$i++)
			{
				$con->query('delete from Comentarios where ID='.$_POST['comID'][$i]);
			}
		}
	}
	
	$Visor	= new Gal_HTML_Visor
	(
		unserialize($_SESSION['vImgLst']),
		new NULL_Gen_HTML()
	);

	$esq=$Visor->imgSel;

	if(isset($_POST['comID']))
	{
	}
?>
			<!-- Título -->
			<h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php echo $esq->Titulo ?>
						<a href="../index.php?&amp;cache=<?php echo $_SESSION['cache']?>#gal" target="_parent" class="cerrar" title="Cerrar Visor">X</a>
			</h2>
			
			<!-- Imagen y controles -->
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8 imgCont">
					<a href="visor.php?vInc=-1&amp;cache=<?php echo $_SESSION['cache']?>#gal" class="flecha" title="Imagen Anterior" >
						<img src="../img/flecha_i.png" alt="Flecha hacia la izquierda"/>
					</a>

					<img src="<?php echo $esq->Url ?>" alt="<?php echo $esq->Alt ?>"/>					

					<a href="visor.php?vInc=1&amp;cache=<?php echo $_SESSION['cache']?>#gal"  class="flecha" title="Imagen Siguiente">
						<img src="../img/flecha_d.png" alt="Flecha hacia la derecha"/>
					</a>
			</div>

			<!-- Elemento que actúa de margen para el centrado del contenedor de los comentarios -->
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 col-1"></div>

			<!-- Comentarios -->
			<div class="comentarios col-lg-10 col-md-10 col-sm-10 col-xs-10" >
				<?php
					include('../forms/acciones.php');

					//Genero los comentarios.
					echo GenComGrp($_SESSION['vImgID'] , $con);

					include('../forms/nuevo_coment.php');
				?>
			</div>
	</body>
</html>