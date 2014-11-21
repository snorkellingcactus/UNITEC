<section id="gal">
	<h1 class="titulo">Galería de Fotos</h1>
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

		include_once 'php/conexion.php';
		include_once 'php/SQL_Obj.php';
		include_once 'php/Img.php';
		include_once 'php/Gal_HTML.php';
		include_once 'php/Inc_Esq.php';
		
		$modoAdmin=isset($_SESSION['adminID']);

		//Diferencias en modo admin.
		if($modoAdmin)
		{
			//Elimina Imagen.
			if(isset($_GET['eImgID']))
			{
				$con->query('delete from Imagenes where ID='.$_GET['eImgID']);
			}
			//Se rellenó el formulario de nueva imagen, la inserto en la bd.
			if(isset($_POST['Titulo']))
			{
				
				//Creo la imagen y le asigno las propiedades.
				$Img=new Img($con);
				$Img->Titulo=$_POST['Titulo'];
				$Img->Url=$_POST['Url'];
				$Img->Alt=$_POST['Alt'];
			
				//La inserto en la bd.
				$Img->insSQL();
			}
		}
		
		//:::::::::::::::::::::::::::::::HTML::::::::::::::::::::::::::::::::::::
		//Valores para las clases col-xx-xx de las imágenes.
		$imgEsq=new Inc_Esq("esq/gal_img.php");
		$Gal=new Gal_HTML
		(
			'select * from Imagenes',
			$con,
			$imgEsq
		);
		//Genero el código HTML de la galería.
		echo $Gal->gen();

		if($modoAdmin)
		{
			//Imprimo el boton nueva imagen.
			include("esq/gal_nImg.html");
			//Si se clickeó el botón nueva imagen, imprimo el formulario.
			if(isset($_GET['gNImgDiag']))
			{
				echo '<iframe width="100%" height="100%" src="forms/nueva_imagen.html"></iframe>';
			}
		}
		//Si se pasó por URL un ID de imagen, abro el visor para mostrarla.
		if(isset($_GET['vImgID']))
		{
			$_SESSION['vImgID']		= intval($_GET['vImgID']);		//Trato de pasar el ID de imagen a número.
			$_SESSION['vImgLst']	= serialize($Gal->imgLst);		//Reestablezco la lista de imágenes.

			echo '<iframe width="100%" height="100%" src="./seccs/visor.php"></iframe>';
		}
	?>
</section>