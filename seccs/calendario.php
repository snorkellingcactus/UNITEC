<?php
/*:::::::::::RECORDATORIO::::::::::
"seconds"
"minutes"
"hours"
"mday"
"wday"
"mon"
"year"
"yday"
"weekday"
"month"
:::::::::::::::::::::::::::::::::*/
include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/cal/Cal_Cfg.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/cal/Cal_Gen_HTML.php';

$CalCfg=new Cal_Cfg();
$GenHTML=new Cal_Gen_HTML($CalCfg);

if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}
?>
<!--	:::::::::Calendario:::::::::	-->
<div class='calendario' id='cal'>
	<h1 class='titulo'>
		<?php
			echo $GenHTML->ano(); 
		?>
	</h1>

		<?php
			if(!empty($_SESSION['adminID']))
			{
				include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliRecv.php');
				include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliBuilder.php');
				include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_Eventos.php';

				$formCalRecv=new FormCliRecv('Cal');
				$formCalRecv->SQL_Evts=new SQL_Evts_Eventos();
				//Incluyo las acciones posibles.
				//$formSec->buildActionForm();

				$formCalRecv->checks();

				$formCal=new FormCliBuilder('Cal' , 30);
				$formCal->buildActionForm();
			}
			$consulta='SELECT * FROM Eventos';

			if(isset($_GET['mes']) && !is_nan(intVal($_GET['mes'])))
			{
				$mes=intVal($_GET['mes']);

				//Seteo el mes en el generador HTML.
				$GenHTML->mes($mes);

				

				$fecha=$GenHTML->fecha;

				$mesAct=DateTime::createFromFormat
				(
					'Y-m-d',
					$fecha['year'].'-'.$fecha['mon'].'-01'
				);

				$mesSig=new DateTime();
				$mesSig->setTimestamp($mesAct->getTimestamp());
				$mesSig->add(new DateInterval('P1M'));

				$mesAct=$mesAct->format('Y-m-d 00:00:00');
				$mesSig=$mesSig->format('Y-m-d 00:00:00');

				$consulta=$consulta.' where Tiempo between "'.$mesAct.'" and "'.$mesSig.'"';
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			global $con;

			$eventos=$con->query($consulta.' ORDER BY Tiempo,Prioridad ASC');

			//echo '<pre>Consulta eventos:';print_r($consulta.' ORDER BY Prioridad, Tiempo ASC');echo '</pre>';
			
			$eventos=fetch_all($eventos , MYSQLI_ASSOC);

			$cantEventos=count($eventos);

			if($cantEventos)						//Si hay eventos los muestro.
			{
				$desc='';

				for($i=0;$i<$cantEventos;$i++)
				{
					$evtAct=$eventos[$i];
					$fecha=getdate(strtotime($evtAct['Tiempo']));

					$evtAct['Descripcion']=getTraduccion
					(
						$evtAct['DescripcionID'],
						$_SESSION['lang']
					);

					//Simulación de eventos.
					$CalCfg->adEvento
					(
						$fecha,
						htmlentities($evtAct['Nombre']),
						$evtAct['Descripcion']
					);

					$fechaMin=$fecha['minutes'];
					if(strlen($fechaMin)<2)
					{
						$fechaMin='0'.$fechaMin;
					}

					$fechaText=$CalCfg->dias[$fecha['wday']].' '.$fecha['mday'].' de '.$CalCfg->meses[$fecha['mon']-1].' '.$fecha['hours'].':'.$fechaMin;

					ob_start();
					?>
						<li>
							<p class="fecha">
									<?php echo $fechaText?>
							</p>
							<h3>
								 <?php
								 echo htmlentities($evtAct['Nombre']);

								 if(!empty($_SESSION['adminID']))
								 {
								 	?>
								 		<input type="checkbox" name="conID[]" value="<?php echo $evtAct['DescripcionID']?>" form="accionesCal"/>
								 	<?php
								 }
								 ?>

							</h3>
							<p>
								<?php echo $evtAct['Descripcion'] ?>
							</p>
						</li>
					<?php

					$desc=$desc.ob_get_contents();
					ob_end_clean();
				}
			}
			else
			{
				ob_start()
				?>
					<h3>Ningún evento este mes.</h3>
				<?php
				$desc=ob_get_contents();
				ob_end_clean();
			}

			if(isset($mes))
			{
				?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<?php $GenHTML->genTable() ?>
					</div>
				<?php
			}
			else
			{
				for($m=1;$m<13;$m+=1)
				{
					?>
						<div class="col-xs-12 col-sm-6 col-md-4" col-lg-4>
							<?php

								$GenHTML->mes($m);

								$GenHTML->genTable();
							?>
						</div>
					<?php
					if($m%3==0)
					{
						?>
							<div class="clearfix visible-md visible-lg"></div>
						<?php
					}
					if($m%2==0)
					{
						?>
							<div class="clearfix visible-sm"></div>
						<?php
					}
				}
			}
				?>
				<div class="clearfix visible-xs"></div>
				<!--Contenedor de la descripción de la mitad del ancho. -->
				<div class="desc col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ul>

				<?php
					echo $desc;
				?>
				</ul>
			</div>
</div>