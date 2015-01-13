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
include 'php/cal/Cal_Cfg.php';
include 'php/cal/Cal_Gen_HTML.php';

$CalCfg=new Cal_Cfg();
$GenHTML=new Cal_Gen_HTML($CalCfg);

if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}
?>
<!--	:::::::::Calendario:::::::::	-->
<section class='calendario' id='cal'>
	<h1 class="titulo hidden-xs"> Calendario de Eventos </h1>
	<h1 class="subtitulo visible-xs"> Calendario de Eventos </h1>
	<h1 class='titulo'>
		<?php
			echo $GenHTML->ano(); 
		?>
	</h1>

		<?php

			$consulta='select * from Eventos';

			if(isset($_GET['mes']) && !is_nan(intVal($_GET['mes'])))
			{
				$mes=intVal($_GET['mes']);

				//Seteo el mes en el generador HTML.
				$GenHTML->mes($mes);

				

				$fecha=$GenHTML->fecha;

				$mesAct=$fecha['year'].'-'.$fecha['mon'].'-00 00:00:00';
				$mesSig=$fecha['year'].'-'.($fecha['mon']+1).'-00 00:00:00';

				$consulta=$consulta.' where Tiempo between "'.$mesAct.'" and "'.$mesSig.'"';
			}

			include('php/conexion.php');

			$eventos=$con->query($consulta.' order by tiempo asc');
			
			$eventos=$eventos->fetch_all(MYSQLI_ASSOC);

			$cantEventos=count($eventos);

			if($cantEventos)						//Si hay eventos los muestro.
			{
				$desc='';

				for($i=0;$i<$cantEventos;$i++)
				{
					$evtAct=$eventos[$i];
					$fecha=getdate(strtotime($evtAct['Tiempo']));

					//Simulación de eventos.
					$CalCfg->adEvento
					(
						$fecha,
						htmlentities($evtAct['Nombre']),
						htmlentities($evtAct['Descripcion'])
						
					);


					ob_start();
					?>
							<h3> Dia <?php echo $fecha['mday'] ?>
							 	:
								 <?php echo $evtAct['Nombre'] ?>
							</h3>
							<p>
								<?php echo $evtAct['Descripcion'] ?>
							</p>
					<?php

					$desc=$desc.ob_get_contents();
					ob_end_clean();
				}

				if(isset($mes))
				{
					?>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<?php $GenHTML->genTable() ?>;
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
				<!--Contenedor de la descripción de la mitad del ancho. -->
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="desc">

				<?php
					echo $desc;
				}
				else
				{
					?>
						<h3>Ningún evento este mes.</h3>
					<?php
				}


				?>
				</div>
			</div>
</section>