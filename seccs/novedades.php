<section id='nov'>
	<h1 class="titulo">Novedades</h1>
	<form id="accionesNov" method="POST" action="php/accion.php" target="_blank">
		<input type="hidden" name="form" value="accionesNov"/>
	</form>
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
				$fAction='#nov';
				$fId='reloadNov';

				include 'forms/acciones.php';
				
				//Incluyo las acciones para las novedades.
				?>
					<p class="acciones">
						Acciones:
						<input type="submit" value="Nueva" name="nuevas" form="accionesNov"/>
					</p>
				<?php
		}

		//Si se rellenó el formulario nueva novedad la envío a la bd.
		if(isset($_POST['nNov']))
		{
			include_once 'php/conexion.php';
			include_once 'php/Novedad.php';
			include_once 'php/Contenido.php';
			include_once 'php/Img.php';
			include_once 'php/Foraneas.php';
			$iMax=count('nNov');
			for($i=0;$i<$iMax;$i++)
			{
				$grupo=$con->query('select ifnull(max(Grupo),0) as Grupo from Contenido');
				$grupo=$grupo->fetch_all(MYSQLI_ASSOC)[0]['Grupo']+1;

				$titulo=new Contenido
				(
					$con,
					[
						'Contenido'=>htmlentities($_POST['Titulo'][$i]),
						'Grupo'=>$grupo
					]
				);
				$titulo->insSQL();

				$grupo=$con->query('select ifnull(max(Grupo),0) as Grupo from Contenido');
				$grupo=$grupo->fetch_all(MYSQLI_ASSOC)[0]['Grupo']+1;

				$descripcion=new Contenido
				(
					$con,
					[
						'Contenido'=>htmlentities($_POST['Descripcion'][$i]),
						'Grupo'=>$grupo
					]
				);
				$descripcion->insSQL();

				$horaLoc=getdate();

				$nov=new Novedad($con);

				$nov->Imagen=$_POST['Imagen'][$i];
				$nov->Fecha=$horaLoc['year'].'-'.$horaLoc['mon'].'-'.$horaLoc['mday'];

				$nov->Descripcion=$descripcion->Grupo;
				$nov->Titulo=$titulo->Grupo;

				$nov->insSQL();
			}
		}

		//Acciones con las seleccionadas.
		if(isset($_POST['novID']))
		{
			if(isset($_POST['elimina']))
			{
				include_once 'php/conexion.php';

				$iMax=count($_POST['novID']);
				for($i=0;$i<$iMax;$i++)
				{
					$contenidos=$con->query('select Titulo , Descripcion from Novedades where ID='.$_POST['novID'][$i]);
					$contenidos=$contenidos->fetch_all(MYSQLI_ASSOC)[0];

					$con->query('delete from Novedades where ID='.$_POST['novID'][$i]);
					$con->query('delete from Contenido where Grupo='.$contenidos['Titulo'].' or Grupo='.$contenidos['Descripcion']);
				}
			}
		}

		include_once 'php/conexion.php';

		$novedades=$con->query('select * from Novedades order by Fecha desc');
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
			include_once 'php/jBBCode1_3_0/JBBCode/Parser.php';


			$novedadesHTML=new Inc_Esq('esq/novedad.php');

			for($i=0;$i<$cantidad;$i++)
			{
				$novAct=$novedades[$i];

				$imagen=$con->query('select Url from Imagenes where ID='.$novAct['Imagen']);
				if($imagen)
				{
					$imagen=$imagen->fetch_all(MYSQLI_ASSOC)[0]['Url'];
				}
				else
				{
					$imagen='http://loquesea';
				}

				$titulo=$con->query
				(
					'
					select Contenido,
					CASE Lenguaje
					WHEN '.$_SESSION['lang'].' THEN 0
					ELSE 1
					END AS Ord
					from Contenido
					where Grupo='.$novAct['Titulo'].
					'
					ORDER BY Ord
					LIMIT 1
					'
				);
				$descripcion=$con->query
				(
					'
					select Contenido,
					CASE Lenguaje
					WHEN '.$_SESSION['lang'].' THEN 0
					ELSE 1
					END AS Ord
					from Contenido
					where Grupo='.$novAct['Descripcion'].
					'
					ORDER BY Ord
					LIMIT 1
					'
				);

				$descripcion=$descripcion->fetch_all(MYSQLI_ASSOC)[0]['Contenido'];
				$titulo=$titulo->fetch_all(MYSQLI_ASSOC)[0]['Contenido'];

				$parser=new JBBCode\Parser();
				
				include_once('php/parser_definiciones.php');

				$parser->parse($descripcion);

				$descripcion=$parser->getAsHtml();

				$novedad=new Novedad
				(
					$con,
					[
						'ID'=>$novAct['ID'],
						'Imagen'=>$imagen,
						'Titulo'=>$titulo,
						'Descripcion'=>$descripcion,
						'Fecha'=>$novAct['Fecha']
					]
				);

				$buff=$buff.$novedadesHTML->recorre($novedad);
			}
		}

		echo $buff;
     
	?>
</section>