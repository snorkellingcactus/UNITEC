<form id="vImg" method="POST" action="seccs/visor.php" target="_blank"></form>
<?php

	//Si todavía no se inicio sesion, se inicia.
	if(session_status()==PHP_SESSION_NONE)
	{
		session_start();
	}
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

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Img.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Contenido.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foranea.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Gal_HTML.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Include_Context.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Traduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';
	
	$modoAdmin=isset($_SESSION['adminID']);

	//Diferencias en modo admin.
	if($modoAdmin)
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliRecv.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliBuilder.php');
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_Imagenes.php';

		$formGalRecv=new FormCliRecv('Gal');
		$formGalRecv->SQL_Evts=new SQL_Evts_Imagenes();

		$formGal=new FormCliBuilder('Gal' , 30);

		$formGalRecv->checks();

		$formGal->actionUrl='#gal';
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

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

	for($i=0;$i<$iMax;$i++)
	{
		$imgAct=& $imgLst[$i];

		$imgAct['TituloCon']=getTraduccion($imgAct['TituloID'] , $_SESSION['lang']);
		$imgAct['AltCon']=getTraduccion($imgAct['AltID'] , $_SESSION['lang']);
	}

	$Gal=new Gal_HTML
	(
		$imgLst,
		new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/esq/gal_img.php')
	);
	//Genero el código HTML de la galería.
	$Gal->gen();

?>
<div class="clearfix"></div>