<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="visor.css" />
		<link rel="stylesheet" type="text/css" href="visor_form.css" />
	</head>
	<body>
<?php

	include_once '../php/conexion.php';
	include_once '../php/SQL_Obj.php';
	include_once '../php/Img.php';
	include_once '../php/Coment.php';
	include_once '../php/Gal_HTML.php';
	include_once '../php/Gal_HTML_Visor.php';
	include_once '../php/NULL_Gen_HTML.php';

	//Si todavía no se inicio sesion, se inicia.
	if(session_status()==PHP_SESSION_NONE)
	{
		session_start();
	}

	//Variable utilizada para corregir un error con enlaces que contienen
	//anclas y variables get. Si el enlace es siempre el mismo, no refresca
	//el código PHP. La variable cache alterna entre 0 y 1 para evitar el problema.
	$_SESSION['cache']=!$_SESSION['cache'];

	//Operaciones cuando se llenó un formulario de nuevo comentario.
	if(isset($_POST['comContenido']))
	{
		//Include necesario para manejar llaves foráneas.
		include_once '../php/Contenido.php';
		include_once '../php/Foraneas.php';

		//Creo un objeto comentario.
		$Coment=new Coment
		(
			$con,
			[
				'GrupoID'=>$_SESSION['vImgID']
			]
		);
		//Indico que tiene como foráneo un objeto Contenido.
		$Coment->insForaneas
		(
			new Contenido
			(
				$con,
				[
					'Contenido'=>htmlentities($_POST['comContenido'])
				]
			),
			[
				'Contenido'=>'ID'
			]
		);
		//Inserto el comentario en la BD.
		$Coment->insSQL();
	}
	
	$Visor	= new Gal_HTML_Visor
	(
		unserialize($_SESSION['vImgLst']),
		new NULL_Gen_HTML()
	);

	$esq=$Visor->imgSel;
?>
			<h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php echo $esq->Titulo ?>
						<a href="../index.php?&cache=<?php echo $_SESSION['cache']?>#gal" target="_parent" class="cerrar">X</a>
			</h2>
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 flecha">
				<a href="visor.php?vInc=-1&cache=<?php echo $_SESSION['cache']?>#gal" >
					<img src="../img/flecha_i.png" />
				</a>
			</div>
			
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8 imgCont">
				<img width="100%" height="100%" src="<?php echo $esq->Url ?>" alt="<?php echo $esq->Alt ?>"/>					
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 flecha">
				<a href="visor.php?vInc=1&cache=<?php echo $_SESSION['cache']?>#gal" >
					<img src="../img/flecha_d.png" />
				</a>
			</div>
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				<div class="comentarios col-lg-10 col-md-10 col-sm-10 col-xs-10" >
							<?php
								include_once '../php/Inc_Esq.php';

								//Genero los comentarios.
								$comentsMod=new Inc_Esq('../esq/coment.php');

								$comentBuff='';
								$consulta=$con->query('select Contenido from Comentarios where GrupoID='.$_SESSION['vImgID']);
								$consulta=$consulta->fetch_all(MYSQLI_ASSOC);
								$contenido=[];
								$cantidad=count($consulta);
							
								if(!$cantidad)
								{
									$comentBuff='<p>Sin comentarios</p>';
								}
								else
								{
									for($i=0;$i<$cantidad;$i++)
									{
										$consulta[$i]=$con->query('select Contenido from Contenido where ID='.$consulta[$i]['Contenido']);
										$consulta[$i]=new Coment($con,$consulta[$i]->fetch_all(MYSQL_ASSOC)[0]);
										$comentBuff=$comentBuff.$comentsMod->recorre($consulta[$i]);
									}
								}
		
								echo $comentBuff;

								echo file_get_contents('../forms/nuevo_coment.php');
							?>
				</div>
	</body>
</html>