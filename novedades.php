<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Un visor de imágenes con comentarios." />

		<?php
			$raiz='/Web/Pasantía/edetec/';
		?>

		<link rel="stylesheet" type="text/css" href="<?php echo $raiz ?>bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $raiz ?>forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $raiz ?>seccs/visor.css" />

		<title>visor de imágenes</title>
	</head>
	<body>
<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Comentario.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Visor.php';
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

	$visor	= new Visor
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT *
					FROM Novedades
					WHERE 1
					ORDER BY Prioridad
				'
			),
			MYSQLI_ASSOC
		)
	);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

	$iMax=count($visor->recLst);
	for($i=0;$i<$iMax;$i++)
	{
		$nov=& $visor->recLst[$i];
		$nov['TituloCon']=getTraduccion($nov['TituloID'],$_SESSION['lang']);
		$nov['ImagenUrl']=fetch_all
		(
			$con->query
			(
				'	SELECT Url
					FROM Imagenes
					WHERE ID='.$nov['ImagenID']
			),
			MYSQLI_NUM
		)[0][0];
	}
	$esq=$visor->recSel;

	$esq['DescripcionCon']=getTraduccion($esq['DescripcionID'],$_SESSION['lang']);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/jBBCode1_3_0/JBBCode/Parser.php';

	$parser=new JBBCode\Parser();

	$parser->addCodeDefinitionSet(new JBBCode\MainCodeDefinitionSet());

	$parser->parse($esq['DescripcionCon']);

	$esq['DescripcionCon']=str_replace("\n" , "<br>" , $parser->getAsHtml());

	$vNotSig=$visor->indexRecN($visor->nRecSel+1);
	$vNotAnt=$visor->indexRecN($visor->nRecSel-1);
?>
			<div class="novedades col-lg-10 col-md-10 col-sm-10 col-xs-10">
				<!-- Imagen -->
				<img src="<?php echo $esq['ImagenUrl']?>" class="shadow col-xs-12 col-sm-5 col-md-5 col-lg-5">

				<!-- Título -->
				<h1>
						<?php echo $esq['TituloCon'] ?>
				</h1>
				<p class="sangria">
					<?php echo $esq['DescripcionCon'];?>
				</p>
			</div>
			<div class="clearfix"></div>
			<!-- Comentarios -->
			<div class="comentarios col-lg-10 col-md-10 col-sm-10 col-xs-10" >
				<?php
					include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormBuilder.php');

					$formNov=new FormBuilder('Com' , 0);
					//Incluyo las acciones posibles.
					$formNov->buildActionForm();

					//Genero los comentarios.
					GenComGrp($esq['TituloID'] , $con);

					if(!isset($_POST['comConID']))
					{
						include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/nuevo_coment.php');
					}
				?>
			</div>
			<div class="clearfix"></div>
	</body>
</html>