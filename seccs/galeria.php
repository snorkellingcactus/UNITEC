<?php
	include 'php/Gal_HTML.php';

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
	$con=new mysqli('localhost' , 'root' , 's2r9v3->149' , 'edetec');
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

		//Diseño.
		$bootstrap=[12,6,4,3];		// xs , sm , md , lg

		$_SESSION['cache']=!$_SESSION['cache'];		//Si cache era 0 ahora es 1, y viceversa.
		$Gal=new Gal_HTML
		(
			$Imgs,
			new Mod_HTML
			(
				[
					"<a class='col-xs-".$bootstrap[0].' col-sm-'.$bootstrap[1].
					' col-md-'.$bootstrap[2].' col-lg-'.$bootstrap[3].              
					"' href=\"",
					'" ><p>',
					'</p><img src="',
					'" width="200" height="200" /></a></div>'
				],
				[
					'Url',
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
						<div class="imgCont">
							<a href="index.php?gInc=-1&cache='.$_SESSION['cache'].'#gal" ><img src="img/flecha_i.png" /></a>
							<img width="600" height="600" src="',
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
			$_SESSION['gImg']=$Gal->dspImg($_GET['gInc']);
		}
		//Genero el código HTML de la galería.
		echo $Gal->gen();
		
		$nImg=new Img
		(
			$con,
			[
				'Url'=>'http://tombraiders.net/stella/images/TRA/tra_mummies.jpg',
				'Ancho'=>500,
				'Alto'=>500,
				'Titulo'=>'Hola Mundo'
			]
		);
	
	?>
</section>