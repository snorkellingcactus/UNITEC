<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Galería de imágenes de unitec." />

		<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="/forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="/seccs/galeria.css" />

		<title><?php echo gettext('Visor de imágenes')?></title>
	</head>
	<body>
		<?php
	
		$jj=new DateTime();
/*
			echo '<pre>GET:';
			print_r($_GET);
			echo '</pre>';
			$jj=new DateTime(date('Y-m-d H:i:s'));
			echo '<pre>Datetime:';
			print_r($jj->format('Y-m-d'));
			echo '</pre>';
*/
			//Si todavía no se inicio sesion, se inicia.
			$rw=1;
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
			detectLang();
			detectLab();
/*
			echo '<pre>GET:';
			print_r($_GET);
			echo '</pre>';
			echo '<pre>GET:';
			print_r($_SERVER['QUERY_STRING']);
			echo '</pre>';
*/			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/VisorImagenes.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			$recLst=fetch_all
			(
				$con->query
				(
					'	SELECT Imagenes.*
						FROM Imagenes
						LEFT OUTER JOIN TagsTarget
						ON TagsTarget.GrupoID=Imagenes.TagsGrpID
						LEFT OUTER JOIN Laboratorios
						ON Laboratorios.ID='.$_SESSION['lab'].'
						WHERE TagsTarget.TagID=Laboratorios.TagID
						ORDER BY Imagenes.Prioridad DESC
					'
				),
				MYSQLI_ASSOC
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Visor.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';

			$visorHTML=new VisorImagenes();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

			$i=0;
			while(isset($recLst[$i]))
			{
				$imgAct=& $recLst[$i];
				
				if($visorHTML->add($imgAct['ID'] , $imgAct['AltID'] , $imgAct['TituloID'] , $imgAct['Fecha']))
				{
					$selected=$imgAct['TituloID'];
				}
				++$i;
			}

			echo $visorHTML->getContent();

			//echo $selector->getHTML();
			if(isset($selected))
			{
				$comentariosHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/esq/visor_comentarios.php');
				$comentariosHTML->ContenidoID=$selected;
				$comentariosHTML->getContent();
			}
		?>
	</body>
</html>