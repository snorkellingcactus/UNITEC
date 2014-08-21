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
?>
<!--	:::::::::Calendario:::::::::	-->
<section class='calendario' id='cal'>
	<h1 class='ano'>
		<?php
			echo $GenHTML->ano(); 
		?>
	</h1>
		<?php
			//Simulación de eventos.
			$CalCfg->adEvento
			(
				
				getdate(mktime(0,0,0,3,6)),
				'Hoy , un dia como el resto',
				'Lorem ipsum dolor is amet...'
				
			);
			$CalCfg->adEvento
			(
				
				getdate(mktime(0,0,0,8,12)),
				'Hoy , un dia como el resto',
				'Lorem ipsum dolor is amet...'
				
			);
			$CalCfg->adEvento
			(
				
				getdate(),
				'Hoy , otro dia como el resto',
				'Lorem ipsum dolor is amet...'
			);
			
			if(isset($_GET['mes']) && !is_nan(intVal($_GET['mes'])))
			{
				$mes=intVal($_GET['mes']);
				//Seteo el mes en el generador HTML.
				$GenHTML->mes($mes);
				
				echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';	//Contenedor del mes de la mitad del ancho.
				echo $GenHTML->genTable();					////Genero la tabla del mes.
				echo '</div>';

				
				echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><div class="desc">';//Contenedor de la descripción de la mitad del ancho.
				$CalCfg->verif=[0,0,1,0,1];					//Verifica el mes y el año.
				$eventos=$CalCfg->eventosEnFecha
				(
					[
						'mon'=>$mes,
						'year'=>$CalCfg->fecha['year']
					]
				);
				$cantEventos=count($eventos);
				if($cantEventos)						//Si hay eventos los muestro.
				{
					for($i=0;$i<$cantEventos;$i++)
					{
						$evtAct=$eventos[$i];
						echo '<h3> Dia '.$evtAct[0]['mday'].' : '.$evtAct[1].'</h3>';
						echo '<p>'.$evtAct[2].'</p>';
					}
				}
				else
				{
					echo '<h3>Ningún evento este mes.</h3>';
				}
				echo '</div></div>';
			}
			else
			{
				//Separadores cada sierto número de tablas dependiendo del tamaño de pantalla.
				for($m=1;$m<13;$m+=1)
				{
					echo '<div class="col-xs-12 col-sm-6 col-md-4" col-lg-4>';
	
					$GenHTML->mes($m);
					echo $GenHTML->genTable();
					echo '</div>';
					if($m%3==0)
					{
						echo '<div class="clearfix visible-md visible-lg"></div>';
					}
					if($m%2==0)
					{
						echo '<div class="clearfix visible-sm"></div>';
					}
					echo '<div class="clearfix visible-xs"></div>';
				}	
			}
		?>
</section>