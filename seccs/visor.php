<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Un visor de imágenes con comentarios." />

		<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="visor.css" />
		<link rel="stylesheet" type="text/css" href="../forms/forms.css" />

		<title>Visor de imágenes</title>
	</head>
	<body>
<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Img.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Comentario.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Gal_HTML.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Gal_HTML_Visor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/NULL_Gen_HTML.php';

	//Si todavía no se inicio sesion, se inicia.
	if(session_status()==PHP_SESSION_NONE)
	{
		session_start();
	}

	if(!isset($_SESSION['cache']))
	{
		$_SESSION['cache']=0;
	}
	if(isset($_GET['cache']))
	{
		$_SESSION['cache']=!$_GET['cache']||0;
	}
	
	$Visor	= new Gal_HTML_Visor
	(
		'	SELECT *
			FROM Imagenes
			WHERE 1
		',
		$con,
		new NULL_Gen_HTML()
	);

	$esq=$Visor->imgSel;

	//Operaciones cuando se llenó un formulario de nuevo comentario.
	if(!empty($_POST['comContenido']))
	{
		//Include necesario para manejar llaves foráneas.
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Contenido.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foraneas.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';

		//Creo un objeto comentario.
		$FechaAct=getdate();
		$Fecha=	$FechaAct['year'].'-'
				.$FechaAct['mon'].'-'
				.$FechaAct['mday'].' '
				.$FechaAct['hours'].':'
				.$FechaAct['minutes'].':'
				.$FechaAct['seconds'];
		
		$Comentario=new Comentario($con);
		//Indico que tiene como foráneo un objeto Contenido.
		$Comentario->insForaneas
		(
			nTraduccion
			(
				$_POST['comContenido'],
				$_SESSION['lang']
			),
			[
				'ContenidoID'=>'ContenidoID'
			]
		);

		if(isset($_POST['comNomUsuario']))
		{
			$Comentario->Nombre=htmlentities($_POST['comNomUsuario']);
		}
		if(isset($_SESSION['comConID']))
		{
			$Comentario->PadreID=$_SESSION['comConID'];

			unset($_SESSION['comConID']);
		}
		else
		{
			$Comentario->PadreID=$esq->TituloID;
		}
		$Comentario->RaizID=$esq->TituloID;
		$Comentario->Fecha=$Fecha;
/*
		echo '<pre>A insertar:';
		print_r('<br>Comentario : ');
		print_r($Comentario);
		echo '</pre>';
*/
		//Inserto el comentario en la BD.
		$Comentario->insSQL();

		//Esto hace que se ancle el comentario al que está siendo respondido.
		//La idea es que se ancle el comentario recién creado, para lo que
		//a futuro hay que modificar insSQL() para que actualize el ID.
		$_SESSION['comConID']=$Comentario->ContenidoID;
	}
	else
	{
		if(isset($_SESSION['comConID']))
		{
			unset($_SESSION['comConID']);
		}
	}

	//Elimino comentarios seleccionados.
	if(isset($_SESSION['form']) && $_SESSION['form']==='accionesCom' && isset($_SESSION['conID']))
	{
		$conID=$_SESSION['conID'];

		$iMax=count($conID);
		for($i=0;$i<$iMax;$i++)
		{
			$con->query('DELETE FROM Contenidos WHERE ID='.$conID[$i]);

			echo '<pre>'.'DELETE FROM Contenidos WHERE ID='.$conID[$i].'</pre>';
		}

		unset($_SESSION['conID'] , $_SESSION['form']);
	}
	//unset($_POST['vImgId']);

	$vImgSig=$Visor->indexImgN($Visor->nImgSel+1);
	$vImgAnt=$Visor->indexImgN($Visor->nImgSel-1);
?>
			<!-- Título -->
			<h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php echo $esq->TituloCon ?>
			</h2>
			
			<!-- Imagen y controles -->
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8 imgCont">
					<a href="visor.php?vImg=<?php echo $vImgAnt ?>#gal" class="flecha" title="Imagen Anterior" >
						<img src="../img/flecha_i.png" alt="Flecha hacia la izquierda"/>
					</a>

					<img src="<?php echo $esq->Url ?>" alt="<?php echo $esq->Alt ?>"/>					

					<a href="visor.php?vImg=<?php echo $vImgSig ?>#gal"  class="flecha" title="Imagen Siguiente">
						<img src="../img/flecha_d.png" alt="Flecha hacia la derecha"/>
					</a>
			</div>
			<div class="clearfix"></div>
			<!-- Comentarios -->
			<div class="comentarios col-lg-10 col-md-10 col-sm-10 col-xs-10" >
				<?php
					$fId='Com';
					$omitirNuevas=true;

					include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/acciones.php');

					//Genero los comentarios.
					GenComGrp($esq->TituloID , $con);

					if(!isset($_POST['comConID']))
					{
						include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/nuevo_coment.php');
					}
				?>
			</div>
			<div class="clearfix"></div>
	</body>
</html>