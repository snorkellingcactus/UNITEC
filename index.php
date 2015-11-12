<!DOCTYPE HTML >
<?php
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT );
//Si todavía no se inicio sesion, se inicia.

//error_reporting(E_ALL & ~E_DEPRECATED  & ~E_STRICT);
ini_set("display_errors", "On");

include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';


if(isset($_GET['sesdest']))
{
	session_start();
	session_destroy();
	session_start();
}
/*
if(!isset($_SESSION['cache']))
{
	$_SESSION['cache']=0;
}
*/
detectLang();

unset($_SESSION['form'] , $_SESSION['conID'] , $_SESSION['accion']);

function echoLang($langSQLRes)
{
	//Primeras dos letras.
	$langName=$langSQLRes['Pais'][0].$langSQLRes['Pais'][1];
	?>
		<!-- Revisar -->
		<img aria-hidden="true" src="/img/idiomas/<?php echo $langName.'.png' ?>" alt="" />
	<?php 

	echo utf8_encode($langSQLRes['Nombre']);
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
detectLab();
if($_SESSION['lab']===false && isset($_SESSION['adminID']))
{
	global $organigrama;
	ob_start();
	?>
		<section>
			<?php
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
				$inc=new Include_Context('seccs/organigrama.php');
				$inc->getContent();
			?>
		</section>
	<?php
	$organigrama=ob_get_contents();
	ob_end_clean();

	detectLab();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
global $con;

$lang=getenv('LANG');

?>
<html lang="<?php echo $lang?>">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="<?php echo gettext('Página principal Unitec.')?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    
		<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="/index.css" />
		<link rel="stylesheet" type="text/css" href="/forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="/header.css" />
		<link rel="stylesheet" type="text/css" href="/seccs/menu.css" />
		<link rel="stylesheet" type="text/css" href="/seccs/contacto.css" />
		
		<?php
			if($_SESSION['lab']!==false)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/head_include.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

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

				$titulo=getTraduccion
				(
					fetch_all
					(
						$con->query
						(
							'	SELECT NombreID
								FROM Laboratorios
								WHERE ID='.$_SESSION['lab']
						),
						MYSQLI_NUM
					)[0][0],
					$_SESSION['lang']
				);
			}
			else
			{
				$titulo='NoLab';
			}
		?>
		<link rel="stylesheet" type="text/css" href="/bootstrap.css" />

		<script type="text/javascript" src="/js/head.js"></script>
		<script type="text/javascript" src="/index.js"></script>

		<title><?php echo $titulo?></title>
	</head>
	<body onLoad="JavaScript:inicializa()" tabindex="1">
		<?php
/*
			echo '<pre>SESSION:';
			print_r
			(
				$_SESSION
			);	
			echo '</pre>';
*/
		?>

		<!--:::::::::::::::Atajos de teclado:::::::::::::::-->

		<div class="header hidden-xs" id="header">
			<nav role="navigation">
				<ul role="menu" tabindex="1">
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
								<li role="menuitem">
									<?php
										if($i!==0)
										{
											?>
												<a rel="alternate" href="index.php?lang=<?php echo $langAct['ID'] ?>" hreflang="<?php echo $langShort ?>" lang="<?php echo $langShort ?>" tabindex="1">
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
			<a href="/inicio_sesion.php"><?php echo gettext('Iniciar Sesión') ?></a>
		</div>

		<?php
			include_once("./seccs/menu.php");
		?>
		<main class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
			<?php
				if($_SESSION['lab']!==false)
				{
					if(isset($_GET['vRecID']))
					{
						$noLimit=$_GET['vRecID'];
						$condicion=' Secciones.ID='.$noLimit;
					}
					else
					{
						$noLimit=false;
						$condicion='Secciones.PadreID IS NULL';
					}
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/seccionesHTML.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

					//Obtengo las opciones.

					seccionesHTML
					(
						getPriorizados
						(
							fetch_all
							(
								$con->query
								(
									'	SELECT Secciones.ID,Secciones.Visible,Secciones.HTMLID, Secciones.PrioridadesGrpID
										FROM Secciones
										LEFT OUTER JOIN TagsTarget
										ON TagsTarget.GrupoID=Secciones.TagsGrpID
										LEFT OUTER JOIN Laboratorios
										ON Laboratorios.ID='.$_SESSION['lab'].'
										WHERE '.$condicion.'
										AND TagsTarget.TagID=Laboratorios.TagID
									'
								),
								MYSQLI_ASSOC
							)
						),
						$noLimit
					);

					if(isset($_SESSION['adminID']))
					{
						/*
						$formSec->cMax=1;
						$formSec->buildActionForm(NULL , 'sec',NULL);
						*/

						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddBase.php';

						$formCliSecAdd=new FormCliSecAddBase('accionesSec' , 'sec' , gettext('Nueva Sección'));
						echo $formCliSecAdd->getHTML();
					}
				}
				else
				{
					if(isset($organigrama))
					{
						echo $organigrama;
					}
				}
			?>
		</main>

		<footer class="header">
			<div class="contenedor footer">
				<?php
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';

					$contacto=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/seccs/contacto.php');					

					$formSecRecv=new FormCliRecv('Mail');
					$formSecRecv->SQL_Evts=false;
					$formSecRecv->checks();

					$mapa=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/seccs/mapa.php');
					
					$formSecRecv=new FormCliRecv('Maps');
					$formSecRecv->SQL_Evts=false;
					$formSecRecv->checks();

					if(isset($_SESSION['lab']))
					{
					    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
					    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

					    $lab=new Laboratorio();
					    $lab->getSQL(['ID'=>$_SESSION['lab']]);

					    $contacto->labName=getTraduccion($lab->NombreID , $_SESSION['lang']);

					    $info=
					    [
					        'DireccionID' =>$lab->DireccionID,
					        'Mail'=>$lab->Mail ,
					        'Telefono'=> $lab->Telefono,
					        'Latitud'=> $lab->Latitud,
					        'Longitud'=> $lab->Longitud
					    ];

					    $social=
					    [
					        'Facebook' => $lab->Facebook,
					        'Twitter' => $lab->Twitter,
					    ];

					    function replaceIfEmpty(&$array , $lab)
					    {
					        foreach($array as $clave=>$valor)
					        {
					            if(empty($valor))
					            {
					                $array[$clave]=$lab->$clave;
					            }
					        }
					    }
					    $defaultLab=getDefaultLab()[0]['ID'];



					    if($lab->ID!=$defaultLab)
					    {
					        $lab->getSQL
					        (
					            ['ID'=>$defaultLab]
					        );

					        replaceIfEmpty($info , $lab);
					        replaceIfEmpty($social , $lab);
					    }

					    $info['DireccionID']=getTraduccion($info['DireccionID'] , $_SESSION['lang']);
					    
					    $mapa->latLong=$info['Latitud'].' , '.$info['Longitud'];
					    $contacto->info=$info;
					    $contacto->social=$social;
					}
					else
					{
					    echo '<pre>NoLab!';
					    echo '</pre>';
					}

					$contacto->getContent();
					$mapa->getContent();
				?>
				<div class="clearfix"></div>
				<small>Powered by Bootstrap</small>
				<script type="text/javascript" src="/footer.js"></script>
			</div>
		</footer>
	</body>
</html>
