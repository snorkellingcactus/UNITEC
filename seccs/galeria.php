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
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Img.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Contenido.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foraneas.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Gal_HTML.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Inc_Esq.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Traduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';
	
	$modoAdmin=isset($_SESSION['adminID']);

	//Diferencias en modo admin.
	if($modoAdmin)
	{
		//Se rellenó el formulario de nueva imagen, la inserto en la bd.
		if(isset($_POST['nImg']))
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';

			$iMax=count($_POST['Titulo']);

			if(isset($_SESSION['accion'])  && $_SESSION['accion']==='edita')
			{
				$nImg=new Img($con);

				for($i=0;$i<$iMax;$i++)
				{

					$nImg->getAsoc
					(
						[
							'Url'=>$_POST['Url'][$i],
							'Alt'=>$_POST['Alt'][$i],
							'Prioridad'=>$_POST['Prioridad'][$i],
							'Visible'=>$_POST['Visible'][$i],
							'TituloID'=>$_SESSION['conID'][$i]
						]
					);

					$nImg->updSQL(false , ['TituloID']);

					updTraduccion($_POST['Titulo'][$i] , $nImg->TituloID , $_SESSION['lang']);
				}
			}
			else
			{
			
				for($i=0;$i<$iMax;$i++)
				{
					//Creo la imagen y le asigno las propiedades.
					$img=new Img($con);
	//				$img->Titulo=$_POST['Titulo'][$i];
					$img->Url=$_POST['Url'][$i];
					$img->Alt=$_POST['Alt'][$i];
					$img->LenguajeID=$_POST['Lenguaje'][$i];

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

			unset($_SESSION['form'] , $_SESSION['conID']);
		}
		if(isset($_SESSION['form']) && $_SESSION['form']==='accionesGal' && $_SESSION['accion']==='elimina')
		{
			//Elimina Imágenes Seleccionadas.
			$iMax=count($_SESSION['conID']);

			for($i=0;$i<$iMax;$i++)
			{
				$con->query('delete from Contenidos where ID='.$_SESSION['conID'][$i]);
			}

			unset($_SESSION['conID'] , $_SESSION['form'] , $_SESSION['accion']);
		}
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Include_Context.php');
		
		$formAcciones=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/acciones.php');
		//Incluyo las acciones para la selección.
		$formAcciones->data=
		[
			'fAction'=>'#gal',
			'fId'=>'Gal',
			'cMax'=>30
		];
		//Incluyo las acciones posibles.
		$formAcciones->getContent();
	}
	
	//:::::::::::::::::::::::::::::::HTML::::::::::::::::::::::::::::::::::::
	//Valores para las clases col-xx-xx de las imágenes.
	$imgEsq=new Inc_Esq("esq/gal_img.php");

	$Gal=new Gal_HTML
	(
		'	SELECT Imagenes.*
			FROM Imagenes
			WHERE 1
			ORDER BY Prioridad
		',
		$con,
		$imgEsq
	);
	//Genero el código HTML de la galería.
	echo $Gal->gen();
?>
<div class="clearfix"></div>