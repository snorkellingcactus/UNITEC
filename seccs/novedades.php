<div class="novedades">
	<?php
		//::::::::::Variables de Sesion::::::::::::::
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
		start_session_if_not();
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
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormCliBuilder.php');
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Novedades.php';

			$formNovRecv=new FormCliRecv('Nov');
			$formNovRecv->SQL_Evts=new SQL_Evts_Novedades();

			$formNov=new FormCliBuilder('Nov' , 1);

			$formNovRecv->checks();
			$formNov->buildActionForm();
		}

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
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
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/jBBCode1_3_0/JBBCode/Parser.php';


			$novedadHTML=new Include_Context('esq/novedad.php');

			for($i=0;$i<$cantidad;$i++)
			{
				$novAct=$novedades[$i];

				$titulo=getTraduccion($novAct['TituloID'] , $_SESSION['lang']);
				$descripcion=getTraduccion($novAct['DescripcionID'] , $_SESSION['lang']);

				$parser=new JBBCode\Parser();
				
				$parser->addCodeDefinitionSet(new JBBCode\MainCodeDefinitionSet());

				$parser->parse($descripcion);

				$descripcion=str_replace("\n" , "<br>" , $parser->getAsText());;

				if(isset($formNov))
				{
					$novedadHTML->formBuilder=$formNov;
				}

				$imgAct=fetch_all
				(
					$con->query
					(
						'	SELECT AltID,Url
							FROM Imagenes
							WHERE ID='.$novAct['ImagenID']
					),
					MYSQLI_ASSOC
				)[0];

				$novedadHTML->ID=$novAct['ID'];
				$novedadHTML->Titulo=$titulo;
				$novedadHTML->Descripcion=substr($descripcion , 0 , 500);
				$novedadHTML->Fecha=$novAct['Fecha'];
				$novedadHTML->ImagenID=$novAct['ImagenID'];
				$novedadHTML->ImagenAlt=getTraduccion($imgAct['AltID'] , $_SESSION['lang']);
				$novedadHTML->ImagenUrl=$imgAct['Url'];

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