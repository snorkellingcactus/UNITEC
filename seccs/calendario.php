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
			if(!empty($_SESSION['adminID']))
			{
				//Incluyo las acciones para la selección.
				$fAction='cal';
				$fId='accionesCal';

				include 'forms/acciones.php';

				//Incluyo las acciones posibles.
				?>
					<p class="acciones">Acciones:
						<?php include ('php/select.php') ?>
						<input type="submit" name="nuevas" value="Nuevas" form="<?php echo $fId ?>">
					</p>
				<?php


				if(isset($_POST['form'])&&$_POST['form']==$fId)
				{
					if(isset($_POST['nuevas']))
					{
						$_SESSION['cantidad']=$_POST['cantidad'];
						?>
							<iframe width="100%" height="100%" src="forms/nuevo_evento.php"></iframe>
						<?php
					}
					if(isset($_POST['elimina']))
					{
						$iMax=count($_POST['evtID']);
						for($i=0;$i<$iMax;$i++)
						{
							$con->query('delete from Eventos where ID='.$_POST['evtID'][$i]);
						}
					}
					if(isset($_POST['Titulo']))
					{

						include_once('php/conexion.php');
						include_once('php/SQL_Obj.php');
						include_once('php/Contenido.php');
						include_once('php/Evento.php');

						$fallas=[];
						$fallasLn=0;

						$cantidad=count($_POST['Titulo']);

						for($i=0;$i<$cantidad;$i++)
						{
							$grupo=$con->query('select ifnull(max(Grupo),0) as Grupo from Contenido');
							$grupo=$grupo->fetch_all(MYSQLI_ASSOC)[0]['Grupo']+1;

							$descripcion=new Contenido
							(
								$con,
								[
									'Contenido'=>htmlentities($_POST['Descripcion'][$i]),
									'Leguaje'=>$_POST['Lenguaje'][$i],
									'Grupo'=>$grupo
								]
							);

							$descripcion->insSQL();

							$fecha=date
							(
								'Y-m-d H:i:s',
								mktime
								(
									$_POST['Hora'][$i],
									$_POST['Minuto'][$i],
									0,
									$_POST['Mes'][$i],
									$_POST['Dia'][$i],
									$_POST['Ano'][$i]
								)
							);

							$evento=new Evento
							(
								$con,
								[
									'Descripcion'=>$descripcion->Grupo,
									'Nombre'=>htmlentities($_POST['Titulo'][$i]),
									'Tiempo'=>$fecha
								]
							);

							$evento->insSQL();
						}
					}
				}
			}
			$consulta='select * from Eventos';

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

				$mesAct=$mesAct->format('Y-m-d H:i:s');
				$mesSig=$mesSig->format('Y-m-d H:i:s');

				$consulta=$consulta.' where Tiempo between "'.$mesAct.'" and "'.$mesSig.'"';
			}

			include_once('php/conexion.php');

			$eventos=$con->query($consulta.' order by Tiempo asc');
			
			$eventos=$eventos->fetch_all(MYSQLI_ASSOC);

			$cantEventos=count($eventos);

			if($cantEventos)						//Si hay eventos los muestro.
			{
				$desc='';

				for($i=0;$i<$cantEventos;$i++)
				{
					$evtAct=$eventos[$i];
					$fecha=getdate(strtotime($evtAct['Tiempo']));

					$evtAct['Descripcion']=$con->query
					(
						'
						select Contenido,
						CASE Lenguaje
						WHEN '.$_SESSION['lang'].' THEN 0
						ELSE 1
						END AS Ord
						from Contenido
						where Grupo='.$evtAct['Descripcion'].
						'
						ORDER BY Ord
						LIMIT 1
						'
					);
					$evtAct['Descripcion']=$evtAct['Descripcion']->fetch_all(MYSQLI_NUM)[0][0];

					//Simulación de eventos.
					$CalCfg->adEvento
					(
						$fecha,
						htmlentities($evtAct['Nombre']),
						htmlentities($evtAct['Descripcion'])
					);


					ob_start();
					?>
							<h3> <?php echo substr($evtAct['Tiempo'],0,10)?>
							 	:
								 <?php
								 echo htmlentities($evtAct['Nombre']);

								 if(!empty($_SESSION['adminID']))
								 {
								 	?>
								 		<input type="checkbox" name="evtID[]" value="<?php echo $evtAct['ID']?>" form="<?php echo $fId?>"/>
								 	<?php
								 }
								 ?>

							</h3>
							<p>
								<?php echo htmlentities($evtAct['Descripcion']) ?>
							</p>
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
				<!--Contenedor de la descripción de la mitad del ancho. -->
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="desc">

				<?php
					echo $desc;
				?>
				</div>
			</div>
</section>