<section id="gal">
	<h1 class="titulo">Galería de Fotos</h1>
	<form id="vImg" method="POST" action="#gal"></form>

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
			//Incluyo las acciones para la selección.
			$fAction='gal';
			$fId='accionesGal';

			include 'forms/acciones.php';

			//Incluyo las acciones posibles.
			?>
				<p class="acciones">Acciones:
					<select form="<?php echo $fId ?>" name="cantidad">
						<?php
							for($i=1;$i<=30;$i++)
							{
								?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php
							}
						?>
					</select>
					<input type="submit" name="nuevas" value="Nuevas" form="<?php echo $fId ?>">
				</p>
			<?php

			//Elimina Imágenes Seleccionadas.
			if(isset($_POST['eImgID']))
			{
				$iMax=count($_POST['eImgID']);

				for($i=0;$i<$iMax;$i++)
				{
					$con->query('delete from Imagenes where ID='.$_POST['eImgID'][$i]);
				}
			}
			//echo '<h2><font color="white">'.$fId.'</font></h2>';
			//Se rellenó el formulario de nueva imagen, la inserto en la bd.
			if
			(
				isset($_POST['Titulo'])	&&
				isset($_POST['form'])	&&
				$_POST['form']==$fId
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
			if
			(
				isset($_POST['nuevas'])	&&
				isset($_POST['form'])	&&
				$_POST['form']==$fId
			)
			{
				$_SESSION['cantidad']=$_POST['cantidad'];
				?>
					<iframe width="100%" height="100%" src="forms/nueva_imagen.php"></iframe>
				<?php

			}
		}
		//Si se pasó por URL un ID de imagen, abro el visor para mostrarla.
		if(isset($_POST['vImgId']))
		{
			$_SESSION['vImgID']		= intval($_POST['vImgId']);		//Trato de pasar el ID de imagen a número.
			$_SESSION['vImgLst']	= serialize($Gal->imgLst);		//Reestablezco la lista de imágenes.

			unset($_POST['vImgId']);

			echo '<iframe width="100%" height="100%" src="./seccs/visor.php"></iframe>';
		}
	?>
</section>