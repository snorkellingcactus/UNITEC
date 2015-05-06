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

	global $raiz;

	include_once $raiz.'php/conexion.php';
	include_once $raiz.'php/SQL_Obj.php';
	include_once $raiz.'php/Img.php';
	include_once $raiz.'php/Contenido.php';
	include_once $raiz.'php/Foraneas.php';
	include_once $raiz.'php/Gal_HTML.php';
	include_once $raiz.'php/Inc_Esq.php';
	include_once $raiz.'php/nTraduccion.php';
	
	$modoAdmin=isset($_SESSION['adminID']);

	//Diferencias en modo admin.
	if($modoAdmin)
	{
		if(isset($_POST['form']) && $_POST['form']==='accionesGal')
		{
			//Elimina Imágenes Seleccionadas.
			if(isset($_POST['eConID']))
			{
				$iMax=count($_POST['eConID']);

				for($i=0;$i<$iMax;$i++)
				{
					$con->query('delete from Contenidos where ID='.$_POST['eConID'][$i]);
				}
			}
		}

		//Se rellenó el formulario de nueva imagen, la inserto en la bd.
		if(isset($_POST['nImg']))
		{
			$iMax=count($_POST['Titulo']);
			
			for($i=0;$i<$iMax;$i++)
			{
				//Creo la imagen y le asigno las propiedades.
				$img=new Img($con);
//				$img->Titulo=$_POST['Titulo'][$i];
				$img->Url=$_POST['Url'][$i];
				$img->Alt=$_POST['Alt'][$i];

				$img->insForaneas
				(
					nTraduccion
					(
						$_POST['Titulo'][$i],
						$_POST['Lenguaje'][$i]
					),
					[
						'TituloID'=>'ContenidoID'
					]
				);
			
				//La inserto en la bd.
				$img->insSQL();

				//echo '<pre>';echo print_r($img);echo '</pre>';
			}
		}
		//Incluyo las acciones para la selección.
		$fAction='index.php#gal';
		$fId='Gal';
		$cMax=30;

		include $raiz.'forms/seleccion.php';
		include $raiz.'forms/acciones.php';
	}
	
	//:::::::::::::::::::::::::::::::HTML::::::::::::::::::::::::::::::::::::
	//Valores para las clases col-xx-xx de las imágenes.
	$imgEsq=new Inc_Esq("esq/gal_img.php");

	$Gal=new Gal_HTML
	(
		'	SELECT Imagenes.*
			FROM Imagenes
			WHERE 1
		',
		$con,
		$imgEsq
	);
	//Genero el código HTML de la galería.
	echo $Gal->gen();
?>