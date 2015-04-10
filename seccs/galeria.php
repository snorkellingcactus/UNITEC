<form id="vImg" method="POST" action="seccs/visor.php" target="_blank"></form>
<form id="accionesGal" method="POST" action="php/accion.php" target="_blank">
	<input type="hidden" name="form" value="accionesGal"/>
</form>
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

	include_once 'php/conexion.php';
	include_once 'php/SQL_Obj.php';
	include_once 'php/Img.php';
	include_once 'php/Gal_HTML.php';
	include_once 'php/Inc_Esq.php';
	
	$modoAdmin=isset($_SESSION['adminID']);

	//Diferencias en modo admin.
	if($modoAdmin)
	{
		//Elimina Imágenes Seleccionadas.
		if(isset($_POST['eImgID']))
		{
			$iMax=count($_POST['eImgID']);

			for($i=0;$i<$iMax;$i++)
			{
				$con->query('delete from Imagenes where ID='.$_POST['eImgID'][$i]);
			}
		}
		//Se rellenó el formulario de nueva imagen, la inserto en la bd.
		if
		(
			isset($_POST['Titulo'])	&&
			isset($_POST['nImg'])
		)
		{
			$iMax=count($_POST['Titulo']);
			
			for($i=0;$i<$iMax;$i++)
			{
				//Creo la imagen y le asigno las propiedades.
				$Img=new Img($con);
				$Img->Titulo=$_POST['Titulo'][$i];
				$Img->Url=$_POST['Url'][$i];
				$Img->Alt=$_POST['Alt'][$i];
			
				//La inserto en la bd.
				$Img->insSQL();
			}
		}
		//Incluyo las acciones para la selección.
		$fAction='index.php#gal';
		$fId='Gal';
		$cMax=30;

		include 'forms/seleccion.php';
		include 'forms/acciones.php';
	}
	
	//:::::::::::::::::::::::::::::::HTML::::::::::::::::::::::::::::::::::::
	//Valores para las clases col-xx-xx de las imágenes.
	$imgEsq=new Inc_Esq("esq/gal_img.php");

	$Gal=new Gal_HTML
	(
		'select * from Imagenes where 1',
		$con,
		$imgEsq
	);
	//Genero el código HTML de la galería.
	echo $Gal->gen();
?>