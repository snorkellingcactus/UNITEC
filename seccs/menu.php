<?php
	if(!empty($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMenuOpc.php';
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

	global $con;
	if($_SESSION['lab']!==false)
	{
		$labName=fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.NombreID
					FROM Laboratorios
					WHERE ID='.$_SESSION['lab']
			),
			MYSQLI_NUM
		)[0][0];
		$labName=getTraduccion($labName, $_SESSION['lang']);
	}
	else
	{
		$labName='NoLab';
	}
?>
<div class="menu col-xs-12 col-md-2 col-sm-2 col-lg-2">
		<!--	:::::::::Menú:::::::::	-->
		<nav>
			<ul>
				<?php

					$opciones=$con->query
					(
						'	SELECT Menu.* FROM Menu
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Menu.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE TagsTarget.TagID=Laboratorios.TagID
							ORDER BY Prioridad ASC
						'
					);

					$opciones=fetch_all($opciones , MYSQLI_ASSOC);

					$sMax=count($opciones);

					for($s=0;$s<$sMax;$s++)
					{
						$opcion=$opciones[$s];

						$nombre=htmlentities(getTraduccion($opcion['ContenidoID'] , $_SESSION['lang']));

						if(isset($opcion['SeccionID']))
						{
							$opcion['Url']='#'.$opcion['SeccionID'];
						}

						$clase='';
						if
						(
							!empty($formMenuRecv->afectados)	&&
							in_array($opcion['ContenidoID'] , $formMenuRecv->afectados)
						)
						{
							$clase='class="target"';
						}

						?>
							<li>
								<a href=
									"<?php echo 'http://'.$_SERVER['SERVER_NAME'].$opcion['Url']?>"
									<?php
										echo $clase ;
										if(!empty($opcion['Atajo']))
										{
											?>
												accesskey="<?php echo $opcion['Atajo']?>"
											<?php
										}
									?>
								>
									<?php echo $nombre?>

									<?php 
										if(!empty($_SESSION['adminID']))
										{
											//$formMenu->fId='nMenu'.$s;
											//$formMenu->buildActionForm($opcion['ContenidoID'] , 'opc' , $s);
											$jj=new FormCliMenuOpc($opcion['ContenidoID'] , $s);
											echo $jj->getHTML();
										}
									?>
								</a>
							</li>
						<?php
					}
				?>
			</ul>
			<?php
				if(isset($_SESSION['adminID']))
				{
					/*
					$formMenu->fId='Menu';
					$formMenu->cMax=1;
					$formMenu->buildActionForm(NULL , 'opc',NULL);
					*/
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddBase.php';

					$formCliMenuAdd=new FormCliSecAddBase('accionesMenu' , 'opc' , gettext('Nueva Opción'));
					$formCliMenuAdd->classList->add('accionesMenu');
					
					echo $formCliMenuAdd->getHTML();
				}
			?>
		</nav>
		<!-- Logo -->
		<div class="hidden-xs">
			<a href="#header" accesskey="i">
				<h2>
					<img src="/img/logo_unitec.png" alt="<?php echo gettext('Unitec Logo')?>" width="80" height="80"/>
					<?php echo $labName?>
				</h2>
			</a>
		</div>
</div>