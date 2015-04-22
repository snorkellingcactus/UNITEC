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
		'select * from Imagenes',
		$con,
		new NULL_Gen_HTML()
	);

	$esq=$Visor->imgSel;

	//Operaciones cuando se llenó un formulario de nuevo comentario.
	if(!empty($_POST['comContenido']))
	{
		//Include necesario para manejar llaves foráneas.
		include_once '../php/Contenido.php';
		include_once '../php/Foraneas.php';

		//Creo un objeto comentario.
		$FechaAct=getdate();
		$Fecha=	$FechaAct['year'].'-'
				.$FechaAct['mon'].'-'
				.$FechaAct['mday'].' '
				.$FechaAct['hours'].':'
				.$FechaAct['minutes'].':'
				.$FechaAct['seconds'];

		if(!isset($esq->Comentarios))
		{
			$grupoCom=$con->query('select ifnull(max(GrupoID),0) as GrupoID from Comentarios');
			$grupoCom=fetch_all($grupoCom , MYSQLI_ASSOC)[0]['GrupoID']+1;
		}
		else
		{
			$grupoCom=$esq->Comentarios;
		}
		
		$Comentario=new Coment
		(
			$con,
			[
				'GrupoID'=>$grupoCom,
				'Fecha'=>$Fecha
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
			$Comentario->Nombre=htmlentities($_POST['comNomUsuario']);
		}
		if(isset($_SESSION['comResID']))
		{
			$Comentario->GrupoRes=$_SESSION['comResID'];

			$con->query('update `Comentarios` set Respondido=1 where ID='.$_SESSION['comResID']);

			unset($_SESSION['comResID']);
		}
		//Inserto el comentario en la BD.
		$Comentario->insSQL();

		if(!isset($esq->Comentarios))
		{
			$esq->Comentarios=$grupoCom;

			$esq->updSQL('Comentarios');
		}

		//Esto hace que se ancle el comentario al que está siendo respondido.
		//La idea es que se ancle el comentario recién creado, para lo que
		//a futuro hay que modificar insSQL() para que actualize el ID.
		$_SESSION['comRes']=$Comentario->ID;
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
	//unset($_POST['vImgId']);

	$vImgSig=$Visor->indexImgN($Visor->nImgSel+1);
	$vImgAnt=$Visor->indexImgN($Visor->nImgSel-1);
?>
			<!-- Título -->
			<h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php echo $esq->Titulo ?>
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
					include('../forms/seleccion.php');

					//Genero los comentarios.
					echo GenComGrp($esq->Comentarios , $con);

					if(!isset($_POST['comResID']))
					{
						include('../forms/nuevo_coment.php');
					}
				?>
			</div>
			<div class="clearfix"></div>
	</body>
</html>