<?php
	function seccionesHTML($secciones , $noLimit)
	{
		//SELECT s.ID as SecID,s.Modulo as ModID, m.Archivo as Modulo FROM `Secciones` as s , `Modulos` as m WHERE s.Modulo = m.ID 
		//SELECT s.Contenido as ConID, m.Contenido as Con FROM `Secciones` as s , `Contenido` as m WHERE s.Contenido = m.ID
		//$cfg=sqlResToCfg($Opciones);

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliColSec.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliInc.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCon.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSep.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

		global $con;

		$s=0;
		while(isset($secciones[$s]))
		{
			$seccion=$secciones[$s];

			$htmlID=$seccion['HTMLID'];
			$clase='';

			if
			(
				isset($formSecRecv->afectados[0])	&&
				$formSecRecv->afectados[0]==$seccion['ID']
			)
			{
				$clase='class="target"';
				?>
					<span id='targeted'></span>
				<?php
			}
/*					if($visible==='0')
			{
				$clase='class="oculta"';
			}
*/
			?>
				<section 
					<?php
						if($htmlID!==NULL)
						{
							?>id="<?php echo $htmlID ?>"<?php
						}
						echo $clase;
					?>
				>

				<div class="clearfix">
					<?php
						if(isset($_SESSION['adminID']))
						{
							$formCliColSec=new FormCliColSec($seccion['ID'] , $s , $seccion['Visible']);
							echo $formCliColSec->getHTML();
						}
					?>
				</div>
			<?php
			//Revisar.A futuro seleccionar Seccion.Visible y discriminarlo SOLO si
			//existe o no adminID.

			$includes=getPriorizados
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT Secciones.ID , Secciones.Visible ,Secciones.PrioridadesGrpID, Secciones.HTMLID, Modulos.Archivo, Modulos.OpcGrpID, Modulos.OpcSetsGrpID, Contenidos.ID as ContenidoID
							FROM Secciones
							left outer JOIN Modulos
							ON Modulos.ID = Secciones.ModuloID
							left outer JOIN Contenidos
							ON Contenidos.ID = Secciones.ContenidoID
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Secciones.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE Secciones.PadreID='.$seccion['ID'].'
							AND TagsTarget.TagID=Laboratorios.TagID
						'
					),
					MYSQLI_ASSOC
				)
			);

/*
			echo '<pre>Includes: ';
			print_r($includes);
			echo '</pre>';
*/

			$fMax=count($includes);

			for($f=0;$f<$fMax;$f++)
			{
				//echo '<pre>Include N '.$f.'</pre>';

				$include=$includes[$f];
				$htmlID=$include['HTMLID'];

				$sep=new FormCliSep();

				if($include['ContenidoID']!==NULL)
				{

					$clase='';

					if
					(
						isset($formSecRecv->afectados[0]) &&
						$formSecRecv->afectados[0]==$include['ID'])
					{
						$clase='target';
						?>
							<span id='targeted'></span>
						<?php
					}

					?>
						<div class="contenido <?php echo $clase?>"
							<?php
								if($htmlID!==NULL)
								{
									?>id="<?php echo $htmlID ?>"<?php
								}
							?>
						>
							<?php
								if(!empty($_SESSION['adminID']))
								{
									$formCliCon=new FormCliCon($include['ID'] , $f , $include['Visible']);

									echo $sep->getHTML();
									echo $formCliCon->getHTML();
								}
								
								echo getTraduccion($include['ContenidoID'] , $_SESSION['lang']);
							?>
						</div>
					<?php
				}
				if($include['Archivo']!==NULL)
				{
					global $con;

					/*if($visible==='0')
					{
						?>
							<span class="oculta">
						<?php
					}*/

					$clase='';

					if
					(
						isset($formSecRecv->afectados[0])	&&
						$formSecRecv->afectados[0]==$include['ID']
					)
					{
						$clase='target';

						?>
							<span id='targeted'></span>
						<?php

					}

					?>
						<div class="modulo <?php echo $clase?>" 
							<?php
								if($htmlID!==NULL)
								{
									?>id="<?php echo $htmlID ?>"<?php
								}
							?>
						>
							<?php
								if(isset($_SESSION['adminID']))
								{
									//$formSec->buildActionForm($include['ID'] , 'inc' , $f);
									echo $sep->getHTML();
									$formCliInc=new FormCliInc($include['ID'] , $f , $include['Visible']);
									echo $formCliInc->getHTML();
								}
								$inc=new Include_Context($include['Archivo']);
								$inc->secID=$seccion['ID'];
								$inc->moduloID=$include['ID'];
								$inc->opcGrpID=$include['OpcGrpID'];
								$inc->opcSetsID=$include['OpcSetsGrpID'];
								if($seccion['ID']==$noLimit)
								{
									$inc->limit=false;
								}
								else
								{
									$inc->limit=true;
								}
								$inc->getContent();

							?>
						</div>
					<?php

					/*if($visible==='0')
					{
						?>
							</span>
						<?php
					}*/
					?>
						<div class="clearfix"></div>
					<?php
				}
			}
			?>
				</section>
			<?php

			++$s;
		}
	}
?>