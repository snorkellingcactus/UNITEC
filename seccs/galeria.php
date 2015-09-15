<form id="vImg" method="POST" action="Imagenes.php" target="_blank"></form>
<?php

	//Si todavía no se inicio sesion, se inicia.
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
	//Para pruebas, destruye la sesión actual.
	if(isset($_GET['sesdest']))
	{
		session_destroy();
	}
	//Cache por defecto vale 0.
	if(!isset($_SESSION['cache']))
	{
		$_SESSION['cache']=0;
	}
	if(isset($_SESSION['imgLst']))
	{
		unset($_SESSION['imgLst']);
	}
	if(isset($_GET['cache']))
	{
		$_SESSION['cache']=!$_GET['cache']||0;
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Contenido.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Gal_HTML.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Traduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
	
	$modoAdmin=isset($_SESSION['adminID']);

	//Diferencias en modo admin.
	if($modoAdmin)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliBuilder.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Imagenes.php';

		$formGalRecv=new FormCliRecv('Gal');
		$formGalRecv->SQL_Evts=new SQL_Evts_Imagenes();

		$formGalRecv->checks();

		$formGal=new FormCliBuilder('Gal' , 30);

		$formGal->buildActionForm();
	}
	
	//:::::::::::::::::::::::::::::::HTML::::::::::::::::::::::::::::::::::::
	//Valores para las clases col-xx-xx de las imágenes.
	global $con;
	
	$imgLst=$con->query
	(
		'	SELECT Imagenes.*
			FROM Imagenes
			WHERE 1
			ORDER BY Prioridad
		'
	);
	$imgLst=fetch_all($imgLst , MYSQLI_ASSOC);	//Respuesta SQL como array asociativo.

	$iMax=count($imgLst);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

	for($i=0;$i<$iMax;$i++)
	{
		$imgAct=& $imgLst[$i];

		$imgAct['TituloCon']=getTraduccion($imgAct['TituloID'] , $_SESSION['lang']);
		$imgAct['AltCon']=getTraduccion($imgAct['AltID'] , $_SESSION['lang']);
		$imgAct['afectado']=false;
		
		if(isset($formGal))
		{
			$imgAct['formBuilder']=$formGal;
		}
		if
		(
			!empty($formGalRecv->afectados) &&
			in_array($imgAct['ID'], $formGalRecv->afectados)
		)
		{
			$imgAct['afectado']=true;
		}
	}

	$Gal=new Gal_HTML
	(
		$imgLst,
		new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/esq/gal_img.php')
	);
	//Genero el código HTML de la galería.
	$Gal->gen();

?>
<div class="clearfix"></div>