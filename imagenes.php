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

			$recLst=fetch_all
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
			);

			$iMax=count($recLst);
			for($i=0;$i<$iMax;$i++)
			{
				$imgAct=& $recLst[$i];
				$imgAct['TituloCon']=getTraduccion($imgAct['TituloID'] , $_SESSION['lang']);
				$imgAct['AltCon']=getTraduccion($imgAct['AltID'] , $_SESSION['lang']);
				$imgAct['vRecID']=$imgAct['TituloID'];
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Include_Context.php';

			$visorHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/esq/visor.php');
			$visorHTML->include=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/esq/visor_imagenes.php');
			$visorHTML->recLst=$recLst;

			$visorHTML->getContent();
		?>
	</body>
</html>