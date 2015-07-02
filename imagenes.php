<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Galería de imágenes de unitec." />

		<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="forms/forms.css" />

		<title>Visor de imágenes</title>
	</head>
	<body>
		<?php

			//Si todavía no se inicio sesion, se inicia.
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
			start_session_if_not();

			$rw=1;
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Visor.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/getTraduccion.php';

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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Visor.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';

			$visorHTML=new Visor
			(
				false,
				new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/esq/visor_imagenes.php')
			);

			$iMax=count($recLst);
			for($i=0;$i<$iMax;$i++)
			{
				$imgAct=& $recLst[$i];
				$imgAct['TituloCon']=getTraduccion($imgAct['TituloID'] , $_SESSION['lang']);
				$imgAct['AltCon']=getTraduccion($imgAct['AltID'] , $_SESSION['lang']);
				$imgAct['vRecID']=$imgAct['TituloID'];

				$visorHTML->addRec($imgAct);
			}

			$visorHTML->getContent();
			$comentariosHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/esq/visor_comentarios.php');
			$comentariosHTML->ContenidoID=$visorHTML->recSel['vRecID'];
			$comentariosHTML->getContent();
		?>
	</body>
</html>