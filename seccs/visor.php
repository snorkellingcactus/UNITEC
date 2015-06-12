<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Un visor de imágenes con comentarios." />

		<?php
			$raiz='/Web/Pasantía/edetec/';
		?>

		<link rel="stylesheet" type="text/css" href="<?php echo $raiz ?>bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $raiz ?>seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $raiz ?>forms/forms.css" />

		<title>Visor de imágenes</title>
	</head>
	<body>
<?php

	//Si todavía no se inicio sesion, se inicia.
	if(session_status()==PHP_SESSION_NONE)
	{
		session_start();
	}

	$rw=1;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Visor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

	$visor	= new Visor
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT TituloID, Url,ID,AltID
					FROM Imagenes
					WHERE 1
					ORDER BY Prioridad ASC
				'
			),
			MYSQLI_ASSOC
		)
	);
	global $vRecID;
	
	$vRecID=$visor->recSel['TituloID'];

	$iMax=count($visor->recLst);
	for($i=0;$i<$iMax;$i++)
	{
		$imgAct=& $visor->recLst[$i];
		$imgAct['TituloCon']=getTraduccion($imgAct['TituloID'] , $_SESSION['lang']);
		$imgAct['AltCon']=getTraduccion($imgAct['AltID'] , $_SESSION['lang']);
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Include_Context.php';

	$imagenHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/esq/visor_imagenes.php');
	$comentariosHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/esq/visor_comentarios.php');
	$comentariosHTML->ContenidoID=$vRecID;

	$imagenHTML->data=$visor->recSel;

	$imagenHTML->vRecSig=$visor->indexRecN($visor->nRecSel+1);
	$imagenHTML->vRecAnt=$visor->indexRecN($visor->nRecSel-1);

	$imagenHTML->getContent();
	$comentariosHTML->getContent();

?>
	</body>
</html>