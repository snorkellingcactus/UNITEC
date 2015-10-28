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
			//include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormCliBuilder.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliNov.php');
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Novedades.php';

			$formNovRecv=new FormCliRecv('Nov');
			$formNovRecv->SQL_Evts=new SQL_Evts_Novedades();

			$formNovRecv->checks();
			
			$formNov=new FormCliNov();
			echo $formNov->getHTML();
		}

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;

		$novedades=fetch_all
		(
			$con->query
			(
				'	SELECT *
					FROM Novedades
					ORDER BY Fecha DESC'
			),
			MYSQLI_ASSOC
		);

		if(!isset($novedades[0]))
		{
			?>
				<p><?php echo gettext('Sin novedades') ?></p>
			<?php
		}
		else
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/html2text/html2text.php';


			$novedadHTML=new Include_Context('esq/novedad.php');


			$i=0;
			while(isset($novedades[$i]))
			{
				$novAct=$novedades[$i];

				if(isset($formNov))
				{
					$novedadHTML->formBuilder=$formNov;
				}

				$novedadHTML->ID=$novAct['ID'];
				$novedadHTML->Titulo=getTraduccion($novAct['TituloID'] , $_SESSION['lang']);
				$novedadHTML->Descripcion=substr
				(
					convert_html_to_text
					(
						getTraduccion
						(
							$novAct['DescripcionID'],
							$_SESSION['lang']
						)
					),
					0,
					500
				)
				; //A futuro guardar en la db una version en texto plano.
				$novedadHTML->Fecha=$novAct['Fecha'];
				$novedadHTML->ImagenID=$novAct['ImagenID'];
				$novedadHTML->ImagenAlt=getTraduccion
				(
					fetch_all
					(
						$con->query
						(
							'	SELECT AltID
								FROM Imagenes
								WHERE ID='.$novAct['ImagenID']
						),
						MYSQLI_NUM
					)[0][0],
					$_SESSION['lang']
				);

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

				++$i;
			}
		}
 
	?>
</div>