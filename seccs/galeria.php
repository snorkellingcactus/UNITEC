<?php
	include 'php/Gal_HTML.php';
	include	'php/conexion.php';

	//Variable utilizada para corregir un error con enlaces que contienen
	//anclas y variables get. Si el enlace es siempre el mismo, no refresca
	//el código PHP. La variable cache alterna entre 0 y 1 para evitar el problema.
	if(!isset($_SESSION['cache']))
	{
		$_SESSION['cache']=0;
	}
	//Variable con el numero de imagen que se va a mostrar.
	if(!isset($_SESSION['gImg']))
	{
		$_SESSION['gImg']=0;
	}

	//Obtengo las imágenes.
	$res=$con->query('select * from Imagenes');
	$Imgs=$res->fetch_all(MYSQLI_ASSOC);
?>
<section id="gal">
	<h1 class="titulo">Galería de Fotos</h1>
	<?php
		//Creo objetos Img en base al array asociativo obtenido.
		$iMax=count($Imgs);
		for($i=0;$i<$iMax;$i++)
		{
			$props=$Imgs[$i];
			$Imgs[$i]=new Img($con , $Imgs[$i]);
		}
		//Se rellenó el formulario de nueva imagen, la agrego a la lista
		//de imágenes a desplegar.
		if(isset($_POST['Titulo']))
		{
			//Creo la imagen y le asigno las propiedades.
			$Imgs[$i]=new Img($con);
			$Imgs[$i]->Titulo=$_POST['Titulo'];
			$Imgs[$i]->Url=$_POST['Url'];
			$Imgs[$i]->Alt=$_POST['Alt'];

			//La inserto en la bd.
			$Imgs[$i]->insSQL();
		}

		//:::::::::::::::::::::::::::::::HTML::::::::::::::::::::::::::::::::::::
		$bootstrap=[12,6,4,3];				// xs , sm , md , lg

		$_SESSION['cache']=!$_SESSION['cache'];		//Si cache era 0 ahora es 1, y viceversa.
		$Gal=new Gal_HTML
		(
			$Imgs,
			new Mod_HTML
			(
				[
					"<a class='col-xs-".$bootstrap[0].' col-sm-'.$bootstrap[1].
					' col-md-'.$bootstrap[2].' col-lg-'.$bootstrap[3].              
					"' href=\"index.php?gImgID=",
					'#gal" ><p>',
					'</p><img src="',
					'" width="200" height="200" /></a>'
				],
				[
					'ID',
					'Titulo',
					'Url'
				]
			),
			new Mod_HTML
			(
				[
					'
					<div class="difumina"></div>
					<div class="visor">
					<a href="index.php#gal" class="cerrar">X</a>
						<div class="imgCont">
							<h2>',
							'</h2>
							<a href="index.php?gInc=-1&cache='.$_SESSION['cache'].'#gal" ><img src="img/flecha_i.png" /></a>
							<img width="570" height="570" src="',
							'" alt="',
							'" class="visible-md visible-lg"/>
							<img width="570" height="570" src="',
							'" alt="',
							'" class="visible-sm"/>
							<img width="200" height="200" src="',
							'" alt="',
							'" class="visible-xs"/>
							<a href="index.php?gInc=1&cache='.$_SESSION['cache'].'#gal" ><img src="img/flecha_d.png" /></a>
						</div>
					</div>
					<div class="comentarios">
					</div>
					'
					
				],
				[
					'Titulo',
					'Url',
					'Alt',
					'Url',
					'Alt',
					'Url',
					'Alt'
				]
			)
		);
		
		
		$Gal->imgSel=$_SESSION['gImg'];		//Indico el número de imagen a desplegar.
		
		//Si se pasó un incremento del número de imagen por GET lo aplico.
		if(isset($_GET['gInc']))
		{
			$_SESSION['gImg']=$Gal->incImgN($_GET['gInc']);
			$Gal->genVisor=1;
		}
		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		//En el visor.
		if(isset($_GET['gImgID']))
		{
			$Gal->disc='ID';
			$Gal->discVal=$_GET['gImgID'];
			$Gal->genVisor=1;
		}
		//Genero el código HTML de la galería.
		echo $Gal->gen();
		
		$_SESSION['gImg']=$Gal->imgSel;
		
		//Creo el boton nueva imagen.
		$nImg=new Img
		(
			$con,
			[
				'Titulo'=>'Nueva Imagen',
				'Url'	=>'img/nueva_imagen.png'
			]
		);
		$nImgMod=new Mod_HTML
		(
			[
				"<a class='col-xs-".$bootstrap[0].' col-sm-'.$bootstrap[1].
				' col-md-'.$bootstrap[2].' col-lg-'.$bootstrap[3].              
				"' href=\"index.php?gNImgDiag=1#gal\" ><p>",
				'</p><img src="',
				'" width="200" height="200" /></a>'				
			],
			[
				'Titulo',
				'Url'
			]
		);
		echo $nImgMod->gen($nImg);
		
		if(isset($_GET['gNImgDiag']))
		{
			echo	'
				<div class="difumina">
				</div>
				<div class="visor">
						<form method="POST" action="index.php#gal">
							<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<label for="Titulo">Titulo:</label>
							</p>
							<input type="text" name="Titulo" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="clearfix"></div>

							<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<label for="Url">Url:</label>
							</p>
							<input type="text" name="Url" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="clearfix"></div>

							<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">		
								<label for="Alt" >Alt:</label>
							</p>
							<input type="text" name="Alt" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="clearfix"></div>

							<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">		
								<label for="Lenguaje">Lenguaje:</label>
							</p>
							<select name="Lenguaje" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
								<option value="es_ar" selected>es_ar</option>
								<option value="en">en</option>
							</select>
							<div class="clearfix"></div>

							<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">	
								<label for="Comentarios">Comentarios:</label>
							</p>
							<input type="text" name="Comentarios" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="clearfix"></div>
							
							<input type="submit" value="Aceptar" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

							<a href="index.php#gal" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Cancelar</a>
						</form>
				</div>
				';
		}
	?>
</section>