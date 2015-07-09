<!DOCTYPE HTML >
<?php
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT );
//Si todavía no se inicio sesion, se inicia.

//error_reporting(E_ALL & ~E_DEPRECATED  & ~E_STRICT);
ini_set("display_errors", "On");

include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();

/*
if(isset($_GET['sesdest']))
{
	session_destroy();
	session_start();
}
*/
if(!isset($_SESSION['cache']))
{
	$_SESSION['cache']=0;
}
if(!isset($_SESSION['lang']))
{
	$_SESSION['lang']=1;
}
if(isset($_GET['lang']))
{
	$_SESSION['lang']=intVal($_GET['lang']);
}
if(isset($_POST['Cancela']))
{
	unset($_SESSION['form'] , $_SESSION['conID'] , $_SESSION['accion']);
}
function echoLang($langSQLRes)
{
	?>
		<img src="img/idiomas/<?php echo $langSQLRes['Pais'].'.png' ?>" alt="Cambiar al idioma <?php echo utf8_encode($langSQLRes['Nombre']) ?>" />
	<?php 

	echo utf8_encode($langSQLRes['Nombre']);
}

if(isset($_SESSION['adminID']))
{				
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	$formSecRecv=new FormCliRecv('Sec');
	$formSecRecv->SQL_Evts=new SQL_Evts_Secciones();

	$formSecRecv->checks();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
global $con;
$lang=
fetch_all
(
	$con->query
	(
		'	SELECT Pais
			FROM Lenguajes
			WHERE ID='.$_SESSION['lang']
	),
	MYSQL_NUM
)[0][0]
?>
<html lang="<?php echo $lang?>">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Página principal Unitec." />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    
		<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="./index.css" />
		<link rel="stylesheet" type="text/css" href="./forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="./header.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/menu.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/contacto.css" />
		
		<?php
			include_once($_SERVER['DOCUMENT_ROOT'] . '//php/head_include.php');
			
			$headers=$con->query
			(
				'	SELECT Modulos.Archivo FROM Modulos ,
						(
							SELECT Secciones.ModuloID FROM `Secciones` , 
							(
								SELECT ID from Secciones
								WHERE PadreID IS NULL
							) AS Secs
							WHERE Secciones.PadreID=Secs.ID
							AND Secciones.ModuloID IS NOT NULL
						) AS sub 
						WHERE Modulos.PadreID=sub.ModuloID
				'
			);
			$headers=fetch_all($headers , MYSQLI_NUM);
/*
			echo '<pre>Archivos de cabecera:';
			print_r($headers);
			echo '</pre>';
*/
			$hMax=count($headers);

			for($h=0;$h<$hMax;$h++)
			{
				head_include($header=$headers[$h][0]);
			}
		?>
		<link rel="stylesheet" type="text/css" href="./bootstrap.css" />

		<script type="text/javascript" src="js/head.js"></script>
		<script type="text/javascript" src="index.js"></script>

		<title>Unitec</title>
	</head>
	<body onLoad="JavaScript:inicializa()">

		<!--:::::::::::::::Atajos de teclado:::::::::::::::-->

		<div class="header hidden-xs">
			<nav>
				<ul>
					<?php
						$consulta=$con->query
						(
							'	SELECT * , 
								CASE ID
								WHEN '.$_SESSION['lang'].' THEN 0
								ELSE 1 END AS ord
								FROM `Lenguajes`
								ORDER BY ord
							'
						);

						$consulta=fetch_all($consulta , MYSQLI_ASSOC);

						$iMax=count($consulta);

						for($i=0;$i<$iMax;$i++)
						{
							$langAct=$consulta[$i];
							$langShort=$langAct['Pais'];
							?>
								<li>
									<?php
										if($i!==0)
										{
											?>
												<a rel="alternate" href="index.php?lang=<?php echo $langAct['ID'] ?>" hreflang="<?php echo $langShort ?>" lang="<?php echo $langShort ?>">
													<?php
														echoLang($langAct);
													?>
												</a>
											<?php
										}
										else
										{
											echoLang($langAct);
										}
									?>
								</li>
							<?php
						}
					?>
				</ul>
			</nav>
			<a href="./inicio_sesion.php">Iniciar Sesión</a>
		</div>
		<?php
			include_once("./seccs/menu.php");
		?>
		<main class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
			<?php

				$_GET['mes']=getdate()['mon'];	//Acá indicar mes que se muestra por defecto. Va a mostrarse el mes indicado -1.

				//Obtengo las opciones.
				$secciones=$con->query
				(
					'	SELECT ID,Visible,Prioridad,HTMLID
						FROM Secciones
						WHERE PadreID IS NULL
						ORDER BY Prioridad ASC
					'
				);
				$secciones=fetch_all($secciones , MYSQLI_ASSOC);

				$sMax=count($secciones);

				//SELECT s.ID as SecID,s.Modulo as ModID, m.Archivo as Modulo FROM `Secciones` as s , `Modulos` as m WHERE s.Modulo = m.ID 
				//SELECT s.Contenido as ConID, m.Contenido as Con FROM `Secciones` as s , `Contenido` as m WHERE s.Contenido = m.ID
					//$cfg=sqlResToCfg($Opciones);

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliBuilder.php';

				$formSec=new FormCliBuilder('Sec',0);
				$formSec->fType='Sec';

				for($s=0;$s<$sMax;$s++)
				{
					$seccion=$secciones[$s];

					$htmlID=$seccion['HTMLID'];
					$clase='';

					//$accionesSec=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '//forms/seccion_nuevo_contenido.php');

					if
					(
						isset($formSecRecv->afectados[0])	&&
						$formSecRecv->afectados[0]==$seccion['ID']
					)
					{
						$clase='class="target"';
						?>
							<span id='nSec'></span>
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
									$formSec->fId='nCon'.$s;
									$formSec->cMax=1;
									$formSec->buildActionForm($seccion['ID']);
									$formSec->cMax=0;

									$formSec->fId=NULL;
									$formSec->buildActionForm($seccion['ID'] , 'sec' , $s);
								}
							?>
						</div>
					<?php
					$includes=$con->query
					(
						'	SELECT Secciones.ID , Secciones.Visible , Secciones.Prioridad , Secciones.HTMLID, Modulos.Archivo, Contenidos.ID as ContenidoID
							FROM Secciones
							left outer JOIN Modulos
							ON Modulos.ID = Secciones.ModuloID
							left outer JOIN Contenidos
							ON Contenidos.ID = Secciones.ContenidoID
							WHERE Secciones.PadreID='.$seccion['ID'].'
							ORDER BY Prioridad asc
						'
					);
					$includes=fetch_all($includes , MYSQLI_ASSOC);

/*					echo '<pre>Includes: ';
					print_r($includes);
					echo '</pre>';
*/

					$fMax=count($includes);

					for($f=0;$f<$fMax;$f++)
					{
						//echo '<pre>Include N '.$f.'</pre>';

						$include=$includes[$f];
						$htmlID=$include['HTMLID'];

						if($include['ContenidoID']!==NULL)
						{

							include_once 'php/jBBCode1_3_0/JBBCode/Parser.php';

							$parser=new JBBCode\Parser();
		
							$parser->addCodeDefinitionSet(new JBBCode\MainCodeDefinitionSet());

							$parser->parse
							(
								getTraduccion($include['ContenidoID'] , $_SESSION['lang'])
							);

							$clase='';

							if
							(
								isset($formSecRecv->afectados[0]) &&
								$formSecRecv->afectados[0]==$include['ID'])
							{
								$clase='target';
								?>
									<span id='nSec'></span>
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
											$formSec->buildActionForm($include['ID'] , 'con' , $f);
										}
										
										echo str_replace("\n" , "<br>" , $parser->getAsHtml());
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
									<span id='nSec'></span>
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
											$formSec->buildActionForm($include['ID'] , 'inc' , $f);
										}
										$inc=new Include_Context($include['Archivo']);
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
				}

				if(isset($_SESSION['adminID']))
				{
					$formSec->cMax=1;
					$formSec->buildActionForm(NULL , 'sec',NULL);
				}
			?>
		</main>

		<footer class="header footer">
			<?php
				$contacto=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/seccs/contacto.php');
				$contacto->getContent();
			?>
			<small>Powered by Bootstrap</small>
			<script type="text/javascript" src="footer.js"></script>
		</footer>
	</body>
</html>
