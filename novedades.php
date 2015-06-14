<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Grupo de novedades de unitec." />

		<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="seccs/visor.css" />

		<title>Edetec - Novedades</title>
	</head>
	<body>
<?php
	$rw=1;
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Obj.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Comentario.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Visor.php';
	//Si todavía no se inicio sesion, se inicia.
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();

	$recLst=fetch_all
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
	);

	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/getTraduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/jBBCode1_3_0/JBBCode/Parser.php';

	$iMax=count($recLst);
	for($i=0;$i<$iMax;$i++)
	{
		$nov=& $recLst[$i];
		$nov['TituloCon']=getTraduccion($nov['TituloID'],$_SESSION['lang']);
		$nov['DescripcionCon']=getTraduccion($nov['DescripcionID'],$_SESSION['lang']);

		$parser=new JBBCode\Parser();

		$parser->addCodeDefinitionSet(new JBBCode\MainCodeDefinitionSet());

		$parser->parse($nov['DescripcionCon']);

		$nov['DescripcionCon']=str_replace("\n" , "<br>" , $parser->getAsHtml());

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
		$nov['vRecID']=$nov['TituloID'];
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Include_Context.php';

	$visorHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '//esq/visor.php');
	$visorHTML->include=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '//esq/visor_novedades.php');
	$visorHTML->recLst=$recLst;

	$visorHTML->getContent();
?>
	</body>
</html>