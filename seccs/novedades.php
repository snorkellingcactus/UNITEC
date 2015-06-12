<div class="novedades">
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
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliRecv.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliBuilder.php');
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_Novedades.php';

			$formNovRecv=new FormCliRecv('Nov');
			$formNovRecv->SQL_Evts=new SQL_Evts_Novedades();

			$formNov=new FormCliBuilder('Nov' , 1);

			$formNovRecv->checks();
			$formNov->buildActionForm();
		}

		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		global $con;

		$novedades=$con->query('select * from Novedades order by Fecha desc');
		$novedades=fetch_all($novedades , MYSQLI_ASSOC);

		$cantidad=count($novedades);

		if(!$cantidad)
		{
			?>
				<p>Sin novedades</p>
			<?php
		}
		else
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Include_Context.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/jBBCode1_3_0/JBBCode/Parser.php';


			$novedadHTML=new Include_Context('esq/novedad.php');

			for($i=0;$i<$cantidad;$i++)
			{
				$novAct=$novedades[$i];

				$imagen=$con->query('select Url from Imagenes where ID='.$novAct['ImagenID']);
				if($imagen)
				{
					$imagen=fetch_all($imagen , MYSQLI_ASSOC)[0]['Url'];
				}
				else
				{
					$imagen='http://loquesea';
				}

				$titulo=getTraduccion($novAct['TituloID'] , $_SESSION['lang']);
				$descripcion=getTraduccion($novAct['DescripcionID'] , $_SESSION['lang']);

				$parser=new JBBCode\Parser();
				
				include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/parser_definiciones.php';

				$parser->parse($descripcion);

				$descripcion=$parser->getAsText();

				if(isset($formNov))
				{
					$novedadHTML->formBuilder=$formNov;
				}
				$novedadHTML->ID=$novAct['ID'];
				$novedadHTML->Imagen=$imagen;
				$novedadHTML->Titulo=$titulo;
				$novedadHTML->Descripcion=substr($descripcion , 0 , 500);
				$novedadHTML->Fecha=$novAct['Fecha'];

				if
				(
					isset($formNovRecv->afectados) &&
					in_array($novAct['TituloID'] , $formNovRecv->afectados)
				)
				{
					$novedadHTML->afectado=true;
				}
				else
				{
					$novedadHTML->afectado=false;
				}
				$novedadHTML->getContent();
			}
		}
 
	?>
</div>