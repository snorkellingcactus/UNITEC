<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Grupo de novedades de unitec." />

		<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="/seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="/seccs/galeria.css" />

		<title><?php echo gettext('Edetec - Novedades') ?></title>
	</head>
	<body>
<?php
	$rw=1;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Obj.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Comentario.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/VisorNovedades.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

	detectLang();
	detectLab();

	$mainNov=false;

	if(isset($_GET['vRecID']))
	{
		$vRecID=intVal($_GET['vRecID']);

		$notStr='AND Novedades.ID != '.$vRecID;

		$mainNov=fetch_all
		(
			$con->query
			(
				'	SELECT Novedades.* FROM `Novedades`
					WHERE ID='.intVal($_GET['vRecID'])
			),
			MYSQLI_ASSOC
		)[0];
	}
	else
	{
		$notStr='';
	}

	$recLst=getPriorizados
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Novedades.* FROM `Novedades`
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID=Novedades.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.ID='.$_SESSION['lab'].'
					WHERE TagsTarget.TagID=Laboratorios.TagID '.$notStr.'
					ORDER BY Fecha DESC
					LIMIT 5
				'
			),
			MYSQLI_ASSOC
		)
	);

	$visorHTML=new VisorNovedades();

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

	$visorHTML->add
	(
		$mainNov['ID'],
		$mainNov['ImagenID'],
		$mainNov['TituloID'],
		$mainNov['DescripcionID']
	);

	$selected=$mainNov['TituloID'];
	

	$sugeridas=new DOMTag('section');

	$iMax=count($recLst);

	$i=0;
	while(isset($recLst[$i]))
	{
		$nov=& $recLst[$i];

		$container=new DOMTag('div');
		$container->classList->add('gImg');
		$container->col=['xs'=>12 , 'sm'=>6 , 'md'=>4 , 'lg'=>3];

		$link=new DOMTag('a');

		$text=new DOMTag
		(
			'p',
			getTraduccion
			(
				$nov['TituloID'] ,
				$_SESSION['lang']
			)
		);

		$img=new DOMTag('img');
		//$img->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ];

		//Extraido de esq/novedad.php

		$fechaStr=new DateTime();
		$fechaStr->createFromFormat('Y-m-d H:i:s' , $nov['Fecha']);

		$fechaYmd=strftime
		(
			'%Y-%m-%d',
			$fechaStr->getTimestamp()
		);

		$sugeridas->appendChild
		(
			$container->appendChild
			(
				$link->appendChild($text)->appendChild
				(
					$img->setAttribute
					(
						'src' ,
						$visorHTML->formatUrlB($nov['ImagenID'])
					)
				)->setAttribute
				(
					'href',
					$link='/'.getLangCode().'/espacios/'.getLabName().'/novedades/'.$fechaYmd.'/'.urlencode(str_replace('/' , ' ' , getTraduccion($nov['TituloID'] , $_SESSION['lang']))).'-'.$nov['ID']
				)
			)
		);

		++$i;
	}

	echo $visorHTML->getContent();

	if($i)
	{
		$sugeridas->classList->add('sugeridas')->add('novedades');
		$sugeridas->col=['lg'=>10 , 'md'=>10 , 'sm'=>10 , 'xs'=>10];

		echo $sugeridas->getHTML();
	}
	
	$comentariosHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/esq/visor_comentarios.php');
	$comentariosHTML->ContenidoID=$selected;
	$comentariosHTML->getContent();
?>
	</body>
</html>