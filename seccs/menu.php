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

				for($s=0;$s<$sMax;$s++)
				{
					$nMenu=new SQL_Obj
					(
						$con,
						'Menu',
						[
							'ID',
							'ContenidoID',
							'SeccionID',
							'Url',
							'Prioridad',
							'Visible'
						]
					);

					$nMenu->getAsoc
					(
						[
							'Url'=>$_POST['Url'][$s],
							'Prioridad'=>$_POST['Prioridad'][$s],
							'Visible'=>$_POST['Visible'][$s],
						]
					);

					$nMenu->insForaneas
					(
						nTraduccion
						(
							$_POST['Titulo'][$s],
							$_SESSION['lang']
						),
						[
							'ContenidoID'=>'ContenidoID'
						]
					);

					$nMenu->insSQL();
				}
			}

		}
		if(isset($_SESSION['form']) && $_SESSION['form']==='accionesMenu' && isset($_SESSION['accion']))
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';

			$sMax=count($_SESSION['conID']);

			if($_SESSION['accion']==='elimina')
			{
				for($s=0;$s<$sMax;$s++)
				{
					$con->query
					(
						'	DELETE FROM Contenidos
							WHERE ID='.$_SESSION['conID'][$s]
					);
				}
			}

			if($_SESSION['accion']==='edita')
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';

				$iMax=count($_POST['Titulo']);
				for($i=0;$i<$iMax;$i++)
				{
					updTraduccion($_POST['Titulo'][$i] , $_SESSION['conID'][$i] , $_SESSION['lang']);
					$nMenu=new SQL_Obj
					(
						$con,
						'Menu',
						[
							'ID',
							'ContenidoID',
							'SeccionID',
							'Url',
							'Prioridad',
							'Visible'
						]
					);
					$nMenu->getAsoc
					(
						[
							'Prioridad'=>$_POST['Prioridad'][$i],
							'Url'=>$_POST['Url'][$i],
							'Visible'=>$_POST['Visible'][$i]
						]
					);

					$nMenu->updSQL(false , ['ContenidoID'=>$_SESSION['conID'][$i]]);
				}
			}

			unset($_SESSION['form'] , $_SESSION['accion'] , $_SESSION['conID'] , $sMax);
		}
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
						$fId='Menu';
						$cMax=5;
						include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/acciones.php';
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