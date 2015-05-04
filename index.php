<!DOCTYPE HTML >
<?php
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT );
//Si todavía no se inicio sesion, se inicia.
if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}
//Si no se indicó resaltar ninguna opcion, se resalta el inicio (opcion 0).
if(!isset($_GET["OpcSel"]))
{
	$_GET["OpcSel"]=0;
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

//Resalta la función del menú correspondiente.
function resaltaOpcN($num)
{
	if($_GET["OpcSel"]==$num)
	{
		echo 'class="resaltaOpc"';
	}
}
function echoLang($langSQLRes)
{
	?>
		<img src="img/idiomas/<?php echo $langSQLRes['Pais'].'.png' ?>" alt="" />
	<?php 
		echo $langSQLRes['Nombre'];

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
			include_once('php/conexion.php');
			include_once('php/head_include.php');
			
			$headers=$con->query
			(
				'
					SELECT Modulos.Archivo FROM Modulos ,
					(
						SELECT Secciones.Modulo FROM `Secciones` , 
						(
							SELECT ID from Secciones
							WHERE Padre IS NULL
						) AS Secs
						WHERE Secciones.Padre=Secs.ID 
						AND Secciones.Modulo IS NOT NULL
					) AS sub 
					WHERE Modulos.Padre=sub.Modulo
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
				include_once('php/conexion.php');

				$consulta=$con->query
				(
					'
						SELECT * ,
						case ID 
							when '.$_SESSION['lang'].' then 0 
							else 1 end as ord FROM `Lenguajes` order by ord
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

				

				//Devuelve el contenido al pasarle su ID.
				function getCont($contID , &$id)
				{
					global $con;

					$contenido=$con->query('select Contenido,ID from Contenido where ID='.$contID);

					if($contenido)
					{
						$contenido=fetch_all($contenido , MYSQLI_NUM)[0];

						$id=$contenido[1];

						return $contenido[0];
					}

					return '';
				}
				
				function nSec($visible , $orden , $tipo , $valor)
				{
					include_once('php/SQL_Obj.php');
					global $con , $afectado;

					$TSec=new SQL_Obj($con, 'Secciones', ['Visible','Prioridad','Modulo','Contenido','Padre']);

					if(isset($_POST['secID']))
					{
						$TSec->Padre=$_POST['secID'];
					}
					if($tipo===1)
					{
						$TSec->Modulo=$valor;
					}
					if($tipo===2)
					{
						$TSec->Contenido=$valor;
					}

					$TSec->Prioridad=$orden;
					$TSec->Visible=$visible;

					echo '<pre>Consulta Secciones: ';print_r($TSec);echo '</pre>';

					$TSec->insSQL();
					//return;


					//A futuro: Generar IDs únicos cuando $nombre esté vacio.

					if($tipo===0)
					{
						$afectado=$TSec->ID;
					}
					if($tipo===1)
					{
						$afectado=$valor;
					}

					unset($TSec);
				}

				if(isset($_SESSION['adminID']))
				{
					if(isset($_POST['elimina']) && (isset($_POST['secID'])||isset($_POST['conID'])))
					{
						//echo '<pre>Elimina:<br>';

						$tipo=isset($_POST['conID']);

						if($tipo)
						{
							$consulta='delete from Secciones where ID='.$_POST['conID'];
						}
						else
						{
							$consulta='delete from Secciones where ID='.$_POST['secID'];
						}

						echo '<pre>Elimina : '.$consulta.'</pre>';

						$con->query($consulta);
					}

					if(isset($_POST['nSec']) || isset($_POST['nCon']))
					{
						//Buscar en el futuro la forma de no repetir este código:
						$inc='';
						$tipo=0;
						$valor=NULL;

						if(isset($_POST['secID']))
						{
							if(isset($_POST['Descripcion']))
							{
								$valor=htmlentities($_POST['Descripcion'][0]);

								$con->query('insert into Contenido (Contenido , Lenguaje) values ("'.$valor.'" , '.$_POST['Lenguaje'][0].')');

								global $afectado;

								$afectado=$valor=$con->insert_id;

								$tipo=2;
							}
							else
							{
								$valor=$_POST['Modulo'];
								$tipo=1;
							}
						}

						if($tipo)
						{
							$condicion=' Padre='.$_POST['secID'];
						}
						else
						{
							$condicion=' Contenido IS NULL AND Modulo IS NULL';
						}

						$lugar=$_POST['Lugar'];

						$prefijo=$lugar[0];
						$pOrden=intVal(substr($lugar , 1));
						$nOrden=0;

						$oMax=fetch_all($con->query('select max(Prioridad) from Secciones WHERE'.$condicion) , MYSQLI_NUM)[0][0];

						echo '<pre>Lugar: ';print_r($lugar);echo '</pre>';
						echo '<pre>Maxima Prioridad: ';print_r($oMax);echo '</pre>';

						if($prefijo=='b')
						{
							//El último + 1.
							$nOrden=$oMax+1;
						}
						else
						{
							$secciones=$con->query('SELECT * FROM Secciones WHERE Prioridad  >= '.$pOrden.' AND'.$condicion);
							$secciones=fetch_all($secciones , MYSQLI_ASSOC);
							//Si alguna seccion ocupa el lugar de la nueva la muevo a ella y
							//en el caso de que sea necesario a sus siguientes.

							$j=$pOrden;

							echo '<pre>Secciones a actualizar: ';print_r($secciones);echo '</pre>';

							while(isset($secciones[$j-$pOrden]) && $secciones[$j-$pOrden]['Prioridad']==$j && $j<=$oMax)
							{
								echo '<pre>J: '.$j.'</pre>';
								$nID=$secciones[$j-$pOrden]['ID'];

								$consulta='update Secciones set Prioridad='.($j+1).' where ID='.$nID;

								$con->query($consulta);

								echo '<pre>Actualiza Prioridades: ';print_r($consulta);echo '</pre>';

								++$j;
							}

							$nOrden=$pOrden;
						}


						echo '<pre> Propiedades determinadas:</pre>';
						echo '<pre>Prioridad:'	;	print_r($nOrden)				;	echo '</pre>';
						echo '<pre>Visible:'	;	print_r($_POST['Visible'][0])	;	echo '</pre>';
						echo '<pre>Tipo:'		;	print_r($tipo)					;	echo '</pre>';

						nSec($_POST['Visible'][0] , $nOrden , $tipo , $valor);
					}
				}

				//Obtengo las opciones.
				$secciones=$con->query
				(
					'
						SELECT ID,Visible,Prioridad
						FROM Secciones
						WHERE Padre IS NULL
						ORDER BY Prioridad asc
					'
				);
				$secciones=fetch_all($secciones , MYSQLI_ASSOC);

				$sMax=count($secciones);

				//SELECT s.ID as SecID,s.Modulo as ModID, m.Archivo as Modulo FROM `Secciones` as s , `Modulos` as m WHERE s.Modulo = m.ID 
				//SELECT s.Contenido as ConID, m.Contenido as Con FROM `Secciones` as s , `Contenido` as m WHERE s.Contenido = m.ID
					//$cfg=sqlResToCfg($Opciones);

				for($s=0;$s<$sMax;$s++)
				{
					global $afectado;

					$seccion=$secciones[$s];

					$id=$seccion['ID'];
					$clase='';
					$tipo=0;

					if(isset($_SESSION['adminID']) && isset($_POST['nSec']) && $afectado==$seccion['ID'])
					{
						?>
							<span id="nSec"></span>
						<?php
					}
/*							if($visible==='0')
					{
						$clase='class="oculta"';
					}
*/
					?>
						<section id="<?php echo $id?>" <?php echo $clase?>>

						<div class="clearfix">
							<?php
								include('forms/elimina_dominio.php');
								include('forms/seccion_nuevo_contenido.php');
							?>
						</div>
					<?php

					$includes=$con->query
					(
						'
						SELECT Secciones.ID , Secciones.Visible , Secciones.Prioridad , Modulos.Archivo, Contenido.Contenido
                        FROM Secciones
                        left outer JOIN Modulos
                        ON Modulos.ID = Secciones.Modulo
                        left outer JOIN Contenido
                        ON Contenido.ID = Secciones.Contenido
                        WHERE Secciones.Padre='.$seccion['ID'].'
                        order by Prioridad asc
						'
					);
					$includes=fetch_all($includes , MYSQLI_ASSOC);
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
						if($include['Contenido']!==NULL)
						{
							$tipo=2;
							$id=$include['ID'];

							include_once 'php/jBBCode1_3_0/JBBCode/Parser.php';

							$parser=new JBBCode\Parser();
		
							include('php/parser_definiciones.php');

							$parser->parse($include['Contenido']);

							global $afectado;

							include('forms/elimina_dominio.php');
							$clase='';
/*									if(isset($_POST['nCon']) && $afectado==$id)
							{
								$id='id="nCon"';
							}
							else
							{
								$id='';
							}
*/
							?>
								<div class="contenido <?php echo $clase?>" <?php echo $id?> >
									<?php
										echo $parser->getAsHtml();
									?>
								</div>
								<input type="hidden" name="lleno[]" value="<?php echo $f?>" form="nCon<?php echo $seccion['ID'] ?>">
							<?php
						}
						if($include['Archivo']!==NULL)
						{
							$tipo=1;
							$id=$include['ID'];

							global $con,$afectado;

							/*if($visible==='0')
							{
								?>
									<span class="oculta">
								<?php
							}*/

							include('forms/elimina_dominio.php');

							if(isset($_SESSION['adminID']) && $afectado===$include['Archivo'])
							{
								?>
									<span id="nCon"></span>
								<?php
							}
							include($include['Archivo']);
							/*if($visible==='0')
							{
								?>
									</span>
								<?php
							}*/
							?>
								<input type="hidden" name="lleno[]" value="<?php echo $f?>" form="nCon<?php echo $seccion['ID'] ?>">
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
					include('esq/nSec.php');
				}
			?>
		</main>

		<footer class="footer"><small>powered by bootstrap</small></footer>
	</body>
</html>
