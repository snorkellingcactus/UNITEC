<?
	if(!empty($_SESSION['adminID']))
	{
		if(isset($_POST['nMenu']))
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';
			if(!isset($_SESSION['accion']) && !isset($_SESSION['form']))
			{
				$sMax=count($_POST['Titulo']);

				
			}

		}
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormBuilder.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_Menu.php';

		$formMenu=new FormBuilder('Menu' , 10);
		$formMenu->SQL_Evts=new SQL_Evts_Menu();
		$formMenu->checks();
	}
?>
<div class="menu col-xs-12 col-md-2 col-sm-2 col-lg-2">
		<!--	:::::::::Menú:::::::::	-->
		<nav>
			<ul>
				<?php
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

					global $con;

					$opciones=$con->query
					(
						'	SELECT Menu.* FROM Menu
							WHERE 1
							ORDER BY Prioridad ASC
						'
					);

					$opciones=fetch_all($opciones , MYSQLI_ASSOC);

					$sMax=count($opciones);

					for($s=0;$s<$sMax;$s++)
					{
						$opcion=$opciones[$s];

						$nombre=getTraduccion($opcion['ContenidoID'] , $_SESSION['lang']);

						?>
							<li>
								<a href="<?php echo $opcion['Url']?>"><?php echo $nombre?></a>
								<?php 
									if(!empty($_SESSION['adminID']))
									{
										?>
											<input type="checkbox" name="conID[]" value="<?php echo $opcion['ContenidoID'] ?>" form="accionesMenu">
										<?php
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