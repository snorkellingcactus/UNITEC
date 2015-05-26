<!DOCTYPE HTML >
<?php
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT );
//Si todavía no se inicio sesion, se inicia.

//error_reporting(E_ALL & ~E_DEPRECATED  & ~E_STRICT);
ini_set("display_errors", "On");

if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}
if(!isset($_SESSION['cache']))
{
	$_SESSION['cache']=0;
}
if(!isset($_SESSION['lang']))
{
	$_SESSION['lang']=1;
}
if(isset($_POST['lang']))
{
	$_SESSION['lang']=$_POST['lang'];
}
function echoLang($langSQLRes)
{
	?>
		<img src="img/idiomas/<?php echo $langSQLRes['Pais'].'.png' ?>" alt="" />
	<?php 

	echo $langSQLRes['Nombre'];
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php');

function nSec($visible , $orden , $tipo , $valor , $edita=false)
{
	global $con , $afectado;
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php');

	$nSec=new SQL_Obj($con, 'Secciones', ['ID','Visible','Prioridad','ModuloID','ContenidoID','PadreID']);

	if(isset($_POST['conID']))
	{
		$nSec->PadreID=$_POST['conID'];
	}
	if($tipo===1)
	{
		$nSec->ModuloID=$valor;
	}
	if($tipo===2)
	{
		$nSec->ContenidoID=$valor;
	}

	$nSec->Prioridad=$orden;
	$nSec->Visible=$visible;

	if($edita!==false)
	{
		$nSec->updSQL(false,['ID'=>$edita]);
		$nSec->ID=$edita;
	}
	else
	{
		$nSec->insSQL();
	}

	$afectado=$nSec->ID;

	echo '<pre>Afectado = '.$afectado.'</pre>';
}

if(isset($_SESSION['adminID']))
{
/*
	echo '<pre>SESSION: ';
	print_r($_SESSION);
	echo '</pre>';

	echo '<pre>POST: ';
	print_r($_POST);
	echo '</pre>';
*/
	if(isset($_POST['nSec']) || isset($_POST['nCon']))
	{
		$lugar=$_POST['Lugar'];
		$prefijo=$lugar[0];
		$pOrden=intVal(substr($lugar , 1));

		$edita=isset($_SESSION['accion']) && $_SESSION['accion']==='edita';

		//Buscar en el futuro la forma de no repetir este código:
		$inc='';
		$tipo=0;
		$valor=NULL;

		if(isset($_POST['nCon']))
		{
			if(isset($_POST['Descripcion']))
			{
				if($edita)
				{
					$contenido=fetch_all
					(
						$con->query
						(
							'	SELECT ContenidoID
								FROM Secciones
								WHERE ID='.$_SESSION['conID']
						),
						MYSQLI_NUM
					)[0][0];
					include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php');

					updTraduccion($_POST['Descripcion'][0] , $contenido , $_SESSION['lang']);
				}
				else
				{
					include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php');

					$descripcion=nTraduccion($_POST['Descripcion'][0] , $_SESSION['lang']);

					$descripcion->insSQL();

					$valor=$descripcion->ContenidoID;

					$tipo=2;
				}
			}
			else
			{
				$valor=$_POST['Modulo'];
				$tipo=1;
			}
		}
		if($edita)
		{
			$padreID=fetch_all
			(
				$con->query
				(
					'	SELECT PadreID
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0];
		}
		else
		{
			$padreID=$_POST['conID'];
		}
		if($tipo)
		{	
			$condicion=' PadreID='.$padreID;
		}
		else
		{
			$condicion=' ContenidoID IS NULL AND ModuloID IS NULL';
		}

		$nOrden=0;

		if($prefijo=='b')
		{
			//El último + 1.
			$nOrden=fetch_all($con->query('select max(Prioridad) from Secciones WHERE'.$condicion) , MYSQLI_NUM)[0][0]+1;
		}
		else
		{
			$secciones=$con->query('SELECT * FROM Secciones WHERE '.$condicion.' ORDER BY Prioridad ASC');
			$secciones=fetch_all($secciones , MYSQLI_ASSOC);
			//Si alguna seccion ocupa el lugar de la nueva la muevo a ella y
			//en el caso de que sea necesario a sus siguientes.

			$j=$pOrden;
			$nOrden=intVal($secciones[$pOrden]['Prioridad']);
			$sMax=count($secciones);

			while($j<$sMax && $secciones[$j]['Prioridad']==($nOrden+$j-$pOrden))
			{

				if($edita && $secciones[$j]['ID']===$_SESSION['conID'])
				{
					$j++;
					continue;
				}
				$nID=$secciones[$j]['ID'];

				$consulta='update Secciones set Prioridad='.(intVal($secciones[$j]['Prioridad'])+1).' where ID='.$nID;

				$con->query($consulta);

				echo '<pre>';
				print_r($consulta);
				echo '</pre>';

				++$j;

				if($j>20)
				{
					die('fail');
				}
			}

			$nOrden=$nOrden;
		}
		if($edita)
		{
			$edita=$_SESSION['conID'];
			$_POST['conID']=$padreID;
		}
		nSec($_POST['Visible'][0] , $nOrden , $tipo , $valor , $edita);
		
	}

	if
	(
		isset($_SESSION['form']) &&
		(
			$_SESSION['form']==='accionesSec' ||
			$_SESSION['form']==='accionesCon'
		) &&
		$_SESSION['accion']==='elimina'
	)
	{
		//echo '<pre>Elimina:<br>';

		$tipo=isset($_SESSION['conID']);
		$secID=NULL;

		if($tipo)
		{
			$contenidoID=fetch_all
			(
				$con->query('SELECT ContenidoID FROM Secciones WHERE ID='.$_SESSION['conID']),
				MYSQLI_NUM
			)[0][0];

			if($contenidoID!==NULL)
			{
				//Existe una relacion ON DELETE CASCADE entre las tablas 
				//secciones->contenidos y traducciones->contenidos, de manera
				//que eliminando el contenido, automáticamente se elimina la sección
				//y las traducciones relacionadas.
				$con->query('DELETE FROM Contenidos WHERE ID='.$contenidoID);

				echo '<pre>'.'DELETE FROM Contenidos WHERE ID='.$contenidoID.'</pre>';
			}
			else
			{
				$secID=$_SESSION['conID'];
			}
			unset($_SESSION['conID']);
		}
		else
		{
			$secID=$_SESSION['secID'];
			unset($_SESSION['secID']);
		}
		if($secID!==NULL)
		{
			$con->query('DELETE FROM Secciones WHERE ID='.$secID);

			echo '<pre>'.'DELETE FROM Secciones WHERE ID='.$secID.'</pre>';
		}
	}
	unset($_SESSION['accion'] , $_SESSION['form'] , $_SESSION['conID']);
}
?>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Página principal Unitec." />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    
		<link rel="icon" type="image/png" href="./img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="./img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="./index.css" />
		<link rel="stylesheet" type="text/css" href="./forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="./header.css" />
		<link rel="stylesheet" type="text/css" href="./footer.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/menu.css" />
		
		<?php
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/head_include.php');
			
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
		<link rel="stylesheet" type="text/css" href="./bootstrap.min.css" />

		<script type="text/javascript" src="index.js"></script>

		<title>Unitec</title>
	</head>
	<body onLoad="JavaScript:cargaMenu()">

		<!--:::::::::::::::Atajos de teclado:::::::::::::::-->
		<a href="./index.php?OpcSel=0#sobre" accesskey="i"></a>
		<a href="./index.php?OpcSel=1#nov" accesskey="n"></a>
		<a href="./index.php?OpcSel=2#labs" accesskey="l"></a>
		<a href="./index.php?OpcSel=3#cal" accesskey="c"></a>
		<a href="./index.php?OpcSel=4#gal" accesskey="g"></a>

		<div class="header hidden-xs">
			<a href="./inicio_sesion.php">Iniciar Sesión</a>
			<div class="idioma">
			<?php
				global $afectado;
/*
				include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Contenido.php');

				$jj=new Contenido($con);

				$jj->insSQL();
				$jj->insSQL(['ID'=>5]);

				//$jj->omiteNULL=TRUE;

				echo '<pre>';
				//print_r($jj->remSQL());
				echo '</pre>';
*/
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

				$defLang=array_shift($consulta);

				echoLang($defLang);

				$iMax=count($consulta);

				if($iMax)
				{
			?>
				<div>
					<form id="lang" action="#" method="POST"></form>
					<?php
						for($i=0;$i<$iMax;$i++)
						{

							?>
								<p>
									<button form="lang" type="submit" name="lang" value="<?php echo $consulta[$i]['ID'] ?>">
										<?php
											echoLang($consulta[$i]);
										?>
									</button>
								</p>
							<?php
						}
					?>
				</div>
			</div>
			<?php
				}
			?>
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
					'	SELECT ID,Visible,Prioridad
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

				include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php');

				for($s=0;$s<$sMax;$s++)
				{
					global $afectado;

					$seccion=$secciones[$s];

					$id=$seccion['ID'];
					$clase='';
					$tipo=0;

					if(isset($_SESSION['adminID']) && isset($_POST['nSec']) && $afectado==$seccion['ID'])
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
						<section id="<?php echo $id?>" <?php echo $clase?>>

						<div class="clearfix">
							<?php
								$Orden=$s;
								include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/elimina_dominio.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/seccion_nuevo_contenido.php');
							?>
						</div>
					<?php

					$includes=$con->query
					(
						'	SELECT Secciones.ID , Secciones.Visible , Secciones.Prioridad , Modulos.Archivo, Contenidos.ID as ContenidoID
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
						$id=$include['ID'];
						$Orden=$f;

						if($include['ContenidoID']!==NULL)
						{
							$tipo=2;

							include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/elimina_dominio.php');


							include_once 'php/jBBCode1_3_0/JBBCode/Parser.php';

							$parser=new JBBCode\Parser();
		
							include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/parser_definiciones.php');

							$parser->parse
							(
								getTraduccion($include['ContenidoID'] , $_SESSION['lang'])
							);

							global $afectado;

							$clase='';

							if
							(
								isset($_SESSION['adminID'])		&&
								isset($_POST['nCon'])			&&
								$afectado==$include['ID'])
							{
								$clase='target';
								?>
									<span id='nCon'></span>
								<?php
							}

							?>
								<div class="contenido <?php echo $clase?>">
									<?php
										echo $parser->getAsHtml();
									?>
								</div>
								<input type="hidden" name="lleno[]" value="<?php echo $f?>" form="nCon<?php echo $s ?>">
							<?php
						}
						if($include['Archivo']!==NULL)
						{
							$tipo=1;

							global $con,$afectado;

							/*if($visible==='0')
							{
								?>
									<span class="oculta">
								<?php
							}*/

							include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/elimina_dominio.php');

							//echo '<pre>ModID = '.$id.'</pre>';

							$clase='';

							if
							(
								isset($_SESSION['adminID'])			&&
								isset($_POST['nCon'])				&&
								$afectado==$include['ID'])
							{
								$clase='target';

								?>
									<span id='nCon'></span>
								<?php
							}
							?>
								<div class="modulo <?php echo $clase?>" >
									<?php
										include($include['Archivo']);
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
								<input type="hidden" name="lleno[]" value="<?php echo $f?>" form="nCon<?php echo $s ?>">
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
					include($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/esq/nSec.php');
				}
			?>
		</main>

		<footer class="footer"><small>powered by bootstrap</small></footer>
	</body>
</html>
