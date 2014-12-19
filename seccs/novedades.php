<section id='nov'>
	<h1 class="titulo">Novedades</h1>

	<?php
		if(!empty($_SESSION['adminID']))
		{
				$fAction='nov';
				$fId='accionesNov';

				include 'forms/acciones.php';
		}

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

		if(!empty($_SESSION['adminID']))
		{
			?>
				<form action="#" method="POST">
					<h2>Nueva Novedad</h2>					
					Titulo:<input type="text" name="novTitulo" />
					Descripcion:<input type="text" name="novDescripcion" />
					Imagen:<input type="text" name="novImagen" />

					<input type="submit" name="novNueva" value="Ok" />
				</form>
			<?php
		}
     
	?>
</section>