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
include $_SERVER['DOCUMENT_ROOT'] . '/php/cal/Cal_Cfg.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php/cal/Cal_Gen_HTML.php';

$CalCfg=new Cal_Cfg();
$GenHTML=new Cal_Gen_HTML($CalCfg);

include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
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
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCal.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Eventos.php';

				$formCalRecv=new FormCliRecv('Cal');
				$formCalRecv->SQL_Evts=new SQL_Evts_Eventos();
				//Incluyo las acciones posibles.

				$formCalRecv->checks();
				
				$formCal=new FormCliCal();
				echo $formCal->getHTML();
			}
			$consulta='SELECT * FROM Eventos';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';
			
			$vista=getValFromNombreID('vista' , $this->opcGrpID , $this->opcSetsID);
			if(is_array($vista) && $vista[0]!=='true')
			{
				$vista=false;
			}
			else
			{
				$vista=true;
			}

			if($vista)
			{
				$mes=intVal(getdate()['mon']);

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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
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

					$evtAct['Descripcion']=htmlentities
					(
						getTraduccion
						(
							$evtAct['DescripcionID'],
							$_SESSION['lang']
						)
					);
					$evtAct['Nombre']=htmlentities
					(
						getTraduccion
						(
							$evtAct['NombreID'],
							$_SESSION['lang']
						)
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
					$fechaText=sprintf
					(
						/*
							Ej: Lunes 5 de Febrero a las 5:00
						*/
						gettext('%1$s %2$s de %3$s a las %4$s:%5$s'),
						$CalCfg->dias[$fecha['wday']],
						$fecha['mday'],
						$CalCfg->meses[$fecha['mon']-1],
						$fecha['hours'],
						$fechaMin
					);
					$clase='';
					if
					(
						isset($formCalRecv->afectados)	&&
						in_array($evtAct['DescripcionID'] , $formCalRecv->afectados)
					)
					{
						$clase='class="target"'
						?>
							<span id="targeted"></span>
						<?php
					}

					ob_start();
					?>
						<li <?php echo $clase ?>>
							<p class="fecha">
									<?php echo $fechaText?>
							</p>
							<h3>
								 <?php
								 echo htmlentities($evtAct['Nombre']);

								 if(!empty($_SESSION['adminID']))
								 {
								 	echo $formCal->buildActionCheckBox($evtAct['DescripcionID'])->getHTML();
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
					<h3><?php echo gettext('Ningún evento este mes.')?></h3>
				<?php
				$desc=ob_get_contents();
				ob_end_clean();
			}

			if(isset($mes))
			{
				?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<?php $GenHTML->genTable() ?>

						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-screader">
							<div class="calRef">
								<span><?php echo gettext('Evento') ?></span>
								<span class="evento"></span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-screader">
							<div class="calRef">
								<span><?php echo gettext('Dia Actual')?></span>
								<span class="hoy"></span>
							</div>
						</div>
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