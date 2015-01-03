<section id='nov'>
	<h1 class="titulo">Novedades</h1>

	<?php
		//::::::::::Variables de Sesion::::::::::::::
		if(session_status()==PHP_SESSION_NONE)
		{
			session_start();
		}
		//Cache por defecto vale 0.
		if(!isset($_SESSION['cache']))
		{
			$_SESSION['cache']=0;
		}
		//Invierto el valor boleano de cache.
		if(isset($_GET['cache']))
		{
			$_SESSION['cache']=!$_GET['cache']||0;
		}


		//:::::::::HTML y Diálogos:::::::::::
		//Diferencias al ser admin.
		if(!empty($_SESSION['adminID']))
		{
				//De momento se especifica el ancla de la url action del form con la variable
				//fAction y el id del form con fId.
				$fAction='nov';
				$fId='accionesNov';
				
				//Incluyo el diálogo nueva novedad si se solicitó.
				if(isset($_POST['gNNovDiag']))
				{
					?>
						<iframe width="100%" height="100%" src="forms/nueva_novedad.php"></iframe>
					<?php
				}
				else
				{
					//Incluyo las acciones para las novedades.
					?>
						<p class="acciones">
							Acciones:
							<input type="submit" value="nueva" name="gNNovDiag" form="<?php echo $fId ?>"/>
						</p>
					<?php
				}

				include 'forms/acciones.php';				
		}

		//Si se rellenó el formulario nueva novedad la envío a la bd.
		if(isset($_POST['novNueva']))
		{
			include_once 'php/Novedad.php';
			include_once 'php/Contenido.php';
			include_once 'php/Img.php';
			include_once 'php/Foraneas.php';

			$nov=new Novedad($con);

			$nov->insForaneas
			(
				new Img
				(
					$con,
					[
						'Url'=>$_POST['novImagen']
					]
				),
				[
					'Imagen'=>'ID'
				]
			);

			$nov->insForaneas
			(
				new Contenido
				(
					$con,
					[
						'Contenido'=>$_POST['novTitulo']
					]
				),
				[
					'Titulo'=>'ID'
				]
			);
			$nov->insForaneas
			(
				new Contenido
				(
					$con,
					[
						'Contenido'=>$_POST['novDescripcion']
					]
				),
				[
					'Descripcion'=>'ID'
				]
			);

			$nov->insSQL();
		}

		//Acciones con las seleccionadas.
		if(isset($_POST['novID']))
		{
			if(isset($_POST['eliminar']))
			{
				include_once 'php/conexion.php';

				$iMax=count($_POST['novID']);
				for($i=0;$i<$iMax;$i++)
				{
					$con->query('delete from Novedades where ID='.$_POST['novID'][$i]);
				}
			}
		}

		include_once 'php/conexion.php';

		$novedades=$con->query('select * from Novedades');
		$novedades=$novedades->fetch_all(MYSQLI_ASSOC);

		$cantidad=count($novedades);
		$buff='';

		if(!$cantidad || !$novedades)
		{
			$buff='<p>Sin novedades</p>';
		}
		else
		{
			include_once 'php/Inc_Esq.php';
			include_once 'php/Novedad.php';

			$novedadesHTML=new Inc_Esq('esq/novedad.php');

			for($i=0;$i<$cantidad;$i++)
			{
				$novAct=$novedades[$i];

				$imagen=$con->query('select Url from Imagenes where ID='.$novAct['Imagen']);
				$imagen=$imagen->fetch_all(MYSQLI_ASSOC)[0]['Url'];

				$titulo=$con->query('select Contenido from Contenido where ID='.$novAct['Titulo']);
				$titulo=$titulo->fetch_all(MYSQLI_ASSOC)[0]['Contenido'];

				$descripcion=$con->query('select Contenido from Contenido where ID='.$novAct['Descripcion']);
				$descripcion=$descripcion->fetch_all(MYSQLI_ASSOC)[0]['Contenido'];

				$novedad=new Novedad
				(
					$con,
					[
						'ID'=>$novAct['ID'],
						'Imagen'=>$imagen,
						'Titulo'=>$titulo,
						'Descripcion'=>$descripcion
					]
				);

				$buff=$buff.$novedadesHTML->recorre($novedad);
			}
		}

		echo $buff;
     
	?>
</section>