<!DOCTYPE HTML >
<?php

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
		<link rel="stylesheet" type="text/css" href="./seccs/organigrama.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/calendario.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/sobre_unitec.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/novedades.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/galeria.css" />
		<link rel="stylesheet" type="text/css" href="./bootstrap.min.css" />

		<title>Unitec</title>
	</head>
	<body>

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

				$consulta=$consulta->fetch_all(MYSQLI_ASSOC);

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

				function separa($match , $str)
				{
					$max=strLen($str);
					$res=array();
					$len=0;
					$buff='';

					for($i=0;$i<$max;$i++)
					{
						$letra=$str[$i];

						if($letra===$match)
						{
							$res[$len]=$buff;

							$buff='';
							++$len;
						}
						else
						{
							$buff=$buff.$letra;
						}
					}

					$res[$len]=$buff;

					return $res;
				}

				//Convierte un string como el siguiente:
				//"jj.bb.aa"
				//En un objeto:
				//[
				//	'jj'=>
				//	[
				//		'bb'=>
				//		[
				//			'aa'=>[]
				//		]
				//	]
				//]
				function &strStructObj($str , & $obj)
				{
					$sMax=count($str);
					$intacto=true;

					for($s=0;$s<$sMax;$s++)
					{
						$clave=$str[$s];

						if(!isset($obj[$clave]))
						{
							$obj[$clave]=array();
							$intacto=false;
						}
						if($s<$sMax-1)
						{
							$obj=& $obj[$clave];
						}
					}
					if($intacto)
					{
						if(!isset($obj[$clave][0]))
						{
							$obj[$clave]=array($obj[$clave]);
						}

						$obj[$clave][count($obj[$clave])]=array();
					}

					return $obj[$clave];
				}
				//Sirve como complemento a un array tratado con strStructObj.
				//En el futuro se mezclará con strStructObj.
				function domObj($obj , & $res)
				{
					$puntero=$res;

					if(isset($obj['Dominio']))
					{
						$puntero=&strStructObj(separa('.',$obj['Dominio']) , $res);
					}
					foreach($obj as $clave=>$valor)
					{
						if($clave==='Dominio')
						{
							continue;
						}
						else
						{
							if(isset($puntero['0']))
							{
								$puntero[count($puntero)-1][$clave]=$valor;
							}
							else
							{
								$puntero[$clave]=$valor;
							}
						}
					}
				}

				//Devuelve el contenido al pasarle su ID.
				function getCont($contID)
				{
					global $con;

					$contenido=$con->query('select Contenido from Contenido where ID='.$contID);

					if($contenido)
					{
						$contenido=$contenido->fetch_all(MYSQLI_NUM)[0][0];

						return $contenido;
					}

					return '';
				}

				//Incluye dinamicamente secciones.
				function incluye($includes)
				{
					$orden=[];

					foreach($includes as $clave=>$valor)
					{
						if(isset($valor['orden']))
						{
							$orden[$valor['orden']['Valor']]=$valor;
						}
					}

					$jMax=count($orden);

					for($j=0;$j<$jMax;$j++)
					{
						$incAct=$orden[$j];

						if($incAct['visible']['Valor']==='1')
						{
							$tipo=$incAct['Tipo'];
							$valor=$incAct['Valor'];

							switch($tipo)
							{
								case '0':
									if(isset($incAct['css_id']['Valor']))
									{
										$id=$incAct['css_id']['Valor']
										?>
											<section id="<?php echo $id?>">
										<?php
											if(isset($incAct['inc']))
											{
												incluye($incAct['inc']);
											}
										?>
											</section>
										<?php
									}
								break;
								case '1':
									global $con;
									include($valor);
								break;
								case '2':
									echo getCont($valor);
								break;
							}
						}
					}
				}

				//Obtengo las opciones.
				$Opciones=$con->query('select Dominio,Valor,Tipo from Opciones where Dominio like "edetec.seccion%"');

				if($Opciones)
				{
					$Opciones=$Opciones->fetch_all(MYSQLI_ASSOC);

					$iMax=count($Opciones);

					$cfg=array();

					for($i=0;$i<$iMax;$i++)
					{
						domObj($Opciones[$i] , $cfg);
					}

					$secciones=$cfg['edetec']['seccion'];

					incluye($secciones);
				}


				/*
				include_once('./seccs/atajos.php');
				include_once('./seccs/sobre_unitec.php');
				include_once('./seccs/novedades.php');
				include_once('./seccs/organigrama.php');
				include_once('./seccs/calendario.php');
				include_once('./seccs/galeria.php');
				*/
			?>
		</main>

		<footer class="footer"><small>powered by bootstrap</small></footer>
	</body>
</html>
