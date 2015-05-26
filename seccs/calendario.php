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
				//Incluyo las acciones para la selección.
				$fAction='#cal';
				$fId='Cal';
				$cMax=30;

				//Incluyo las acciones posibles.
				include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/acciones.php';
			

				if(isset($_POST['nEvt']))
				{

					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Contenido.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Evento.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Traduccion.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';

					//$fallas=[];
					//$fallasLn=0;

					$cantidad=count($_POST['Titulo']);

					if(isset($_SESSION['accion'])  && $_SESSION['accion']==='edita')
					{
						$evento=new Evento($con);

						for($i=0;$i<$cantidad;$i++)
						{
							$evento->getAsoc
							(
								[
									'Tiempo'=>$_POST['Ano'][$i].'-'.$_POST['Mes'][$i].'-'.$_POST['Dia'][$i].' '.$_POST['Horas'][$i].':'.$_POST['Minutos'][$i],
									'Nombre'=>$_POST['Titulo'][$i],
									'Visible'=>$_POST['Visible'][$i],
									'Prioridad'=>$_POST['Prioridad'][$i]
								]
							);

							updTraduccion($_POST['Descripcion'][$i] , $_SESSION['conID'][$i] , $_SESSION['lang']);

							echo '<pre>A insertar: ';print_r($evento);echo '</pre>';

							$evento->updSQL
							(
								false,
								[
									'DescripcionID'=>$_SESSION['conID'][$i]
								]
							);
						}
					}
					else
					{
						for($i=0;$i<$cantidad;$i++)
						{
							//$grupo=$con->query('select ifnull(max(Grupo),0) as Grupo from Contenido');
							
							//$grupo=fetch_all($grupo , MYSQLI_ASSOC)[0]['Grupo']+1;

							$fecha=date
							(
								'Y-m-d H:i:s',
								mktime
								(
									$_POST['Horas'][$i],
									$_POST['Minutos'][$i],
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
									
									'Nombre'=>htmlentities($_POST['Titulo'][$i]),
									'Tiempo'=>$fecha
								]
							);
							$evento->insForaneas
							(

								nTraduccion
								(
									$_POST['Descripcion'][$i],
									$_POST['Lenguaje'][$i]
								),
								[
									'DescripcionID'=>'ContenidoID'
								]
							);

							$evento->insSQL();
						}
					}
					unset($_SESSION['conID'] , $_SESSION['form'] , $_SESSION['accion']);
				}

				if(isset($_SESSION['form']) && $_SESSION['form']==='accionesCal' && $_SESSION['accion']==='elimina')
				{
					$iMax=count($_SESSION['conID']);
					for($i=0;$i<$iMax;$i++)
					{
						echo '<pre>Elimina Evento: '.'delete from Contenidos where ID='.$_SESSION['conID'][$i].'</pre>';
						$con->query('delete from Contenidos where ID='.$_SESSION['conID'][$i]);
					}

					unset($_SESSION['conID'] , $_SESSION['form'] , $_SESSION['elimina']);
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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';

			$eventos=$con->query($consulta.' order by Tiempo asc');
			
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
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ul class="desc">

				<?php
					echo $desc;
				?>
				</ul>
			</div>
</div>