<?
	if(!empty($_SESSION['adminID']))
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php');
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Menu.php';

		$formMenuRecv=new FormCliRecv('Menu');
		$formMenuRecv->SQL_Evts=new SQL_Evts_Menu();
		$formMenuRecv->checks();

		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormCliBuilder.php');

		$formMenu=new FormCliBuilder('Menu' , 10);
	}
?>
<div class="menu col-xs-12 col-md-2 col-sm-2 col-lg-2">
		<!--	:::::::::Menú:::::::::	-->
		<nav>
			<ul>
				<?php
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

					global $con;

					$opciones=$con->query
					(
						'	SELECT Menu.* FROM Menu
							WHERE 1
							ORDER BY Prioridad DESC
						'
					);

					$opciones=fetch_all($opciones , MYSQLI_ASSOC);

					$sMax=count($opciones);

					for($s=0;$s<$sMax;$s++)
					{
						$opcion=$opciones[$s];

						$nombre=getTraduccion($opcion['ContenidoID'] , $_SESSION['lang']);

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
									"<?php echo $opcion['Url']?>"
									<?php echo $clase ?>
								>
									<?php echo $nombre?>
								</a>
								<?php 
									if(!empty($_SESSION['adminID']))
									{
										$formMenu->buildActionCheckBox($opcion['ContenidoID']);
									}
								?>
							</li>
						<?php
					}

					if(isset($_SESSION['adminID']))
					{
						//Incluyo las acciones posibles.
						$formMenu->buildActionForm();
					}
				?>
			</ul>
		</nav>
		<!-- Logo -->
		<div class="hidden-xs">
			<h2>
				<img src="img/logo_unitec.png" alt="Unitec Logo" width="80" height="80"/>
				UNITEC
			</h2>
		</div>
</div>