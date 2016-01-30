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
else
{
	$logo='/img/logos/'.$_SESSION['lab'].'.png';
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
global $con;

$lang=substr(getenv('LANG'), 0 , 2);

?>
<html lang="<?php echo $lang?>">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="<?php echo gettext('Página principal Unitec.')?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    
		<link rel="icon" type="image/png" href="<?php echo $logo?>"  />
		<link rel="shortcut icon" type="image/ico" href="<?php echo $logo?>"  />
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

				$headers=fetch_all
				(
					$con->query
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
					),
					MYSQLI_NUM
				);
/*
				echo '<pre>Archivos de cabecera:';
				print_r($headers);
				echo '</pre>';
*/


				$h=0;
				while(isset($headers[$h]))
				{
					head_include
					(
						$headers[$h][0]
					);
					++$h;
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
		<script type="text/javascript" src="/js/compactaLabels.js"></script>
		<script type="text/javascript" src="/index.js"></script>

		<title><?php echo $titulo?></title>
	</head>
	<body onLoad="JavaScript:inicializa()" tabindex="1">

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
							$langShort=substr($langAct['Pais'] , 0 , 2);
							?>
								<li role="menuitem">
									<?php
										if($i!==0)
										{
											?>
												<a rel="alternate" href="<?php echo getLabUrl(getLabName($_SESSION['lab']) , $langShort)?>" lang="<?php echo $langShort ?>" tabindex="1">
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
			<nav>
				<?php
					function echoLabHead($lName)
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

						$a=new DOMTag('a' , $lName);
						$a->setAttribute('href' , getLabUrl($lName));
						echo $a->getHTML();
					}
					
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

					//Revisar . Seguro se pueda hacer mejor ya que getLabTagTree usa implode
					//y acá se hace la inversa con explode. Quizá con DOMArbol.
					
					$labs=explode(',' , getLabTagTree($_SESSION['lab']));

					echo '<i class="minimapa">';
					echo htmlentities('>');

					$len=count($labs);
					for($i=$len;$i>0;$i--)
					{
						echoLabHead(' '.trim($labs[$i-1]));
						if($i>1)
						{
							echo htmlentities(' /');
						}
					}
					echo '</i>';
				?>
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

					$condVisible='';
					if(!isset($_SESSION['adminID']))
					{
						$condVisible='AND Visible=1';
					}

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
										'.$condVisible
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
				<?php
					class FooterContainer extends DOMTag
					{
						function __construct()
						{
							parent::__construct('div');

							$this->classList->add('FooterContainer');
							$this->col=['xs'=>12 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];
						}
					}

					class Footer extends FooterContainer
					{
						function __construct()
						{
							parent::__construct();

							$this->classList->add('Footer');
							$this->col=['xs'=>false , 'sm'=>false , 'md'=>false , 'lg'=>false];
						}
					}

					$footer=new Footer();

					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';

					$formSecRecv=new FormCliRecv('Mail');
					$formSecRecv->SQL_Evts=false;
					$formSecRecv->checks();
					
					$formSecRecv=new FormCliRecv('Mapa');
					$formSecRecv->SQL_Evts=false;
					$formSecRecv->checks();

					if(isset($_SESSION['lab']))
					{
					    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
					    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

					    $lab=new Laboratorio();
					    $lab->getSQL(['ID'=>$_SESSION['lab']]);

					    $labName=getTraduccion($lab->NombreID , $_SESSION['lang']);

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
					    
					    $latLong=$info['Latitud'].' , '.$info['Longitud'];
					}

					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMail.php';

					$divInfo=new FooterContainer();
					$titulo=new DOMTag('h1' , gettext('Nos interesa tu opinión!'));
					$divMail=new FooterContainer();

					$titulo->col=$divMail->col;

					$divMail->appendChild
					(
						new FormCliMail()
					);

					if(!empty($social['Facebook']))
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoFacebook.php';

						$f=new FooterInfoFacebook($social['Facebook']);

						$f->col=['xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

						$divInfo->appendChild($f);
					}
					if(!empty($social['Twitter']))
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoTwitter.php';

						$f=new FooterInfoTwitter($social['Twitter']);

						$f->col=['xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

						$divInfo->appendChild($f);
					}

					if(!empty($social['Facebook']) || !empty($social['Twitter']))
					{
						$divInfo->appendChild(new ClearFix());
					}

					if(!empty($info['Telefono']))
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoTelefono.php';

						$f=new FooterInfoTelefono($info['Telefono']);

						$f->col=['xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

						$divInfo->appendChild($f);
					}
					if(!empty($info['Mail']))
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoMail.php';

						$f=new FooterInfoMail($info['Mail']);

						$f->col=['xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

						$divInfo->appendChild($f);
					}
					if(!empty($info['DireccionID']))
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoDireccion.php';

						$f=new FooterInfoDireccion($info['DireccionID']);

						$f->col=['xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

						$divInfo->appendChild($f);
					}

					$mapa=new FooterContainer();

				    $imgMapa=new DOMTag('img');
				    $imgMapa->classList->add('map-canvas');

				    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMapa.php';

				    $gMapsDiag=new FooterContainer();
				    $gMapsDiag->setAttribute('id' , 'gmapsDiag');

				    $pRuta=new DOMTag('div');
				    $pRuta->col=['xs'=>12 , 'sm'=>12 , 'md'=>5 , 'lg'=>5];

				    echo $footer->appendChild
				    (
				    	$titulo
				    )->appendChild
				    (
				    	new ClearFix()
				    )->appendChild
				    (
				    	$divMail
				    )->appendChild
				    (
				    	$divInfo
				    )->appendChild
				    (
				    	new ClearFix()
				    )->appendChild
				    (
				    	$mapa->appendChild
					    (
					        $imgMapa->setAttribute('id' , 'map-canvas')->setAttribute
					        (
					            'src', 
					            'https://maps.googleapis.com/maps/api/staticmap?center='.$latLong.'&zoom=17&size=500x500&maptype=roadmap&markers=color:red%7Clabel:A%7C'.$latLong.'&key=AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk' 
					        )->setAttribute
					        (
					            'alt',
					            sprintf
					            (
					                gettext('Mapa de la ubicación de %s'),
					                $labName
					            )
					        )
					    )
				    )->appendChild
				    (
				    	$gMapsDiag->appendChild
					    (
					        $pRuta->setAttribute('id' , 'panel_ruta')->appendChild
					        (
					            new DOMTag
					            (
					                'button',
					                gettext('Especificar otro origen')
					            )
					        )
					    )->appendChild
					    (
					        new FormCliMapa()
					    )
				    )->getHTML();
				?>
				<div class="clearfix"></div>
				<small>Powered by Bootstrap</small>
				<script type="text/javascript" src="/footer.js"></script>
		</footer>
	</body>
</html>
