<?php
	//Variable utilizada para corregir un error con enlaces que contienen
	//anclas y variables get. Si el enlace es siempre el mismo, no refresca
	//el código PHP. La variable cache alterna entre 0 y 1 para evitar el problema.
	if(!isset($_SESSION['cache']))
	{
		$_SESSION['cache']=0;
	}
	if(isset($_GET['vImgID']))
	{
		$_SESSION['vGen']=1;
	}
	if(isset($_GET['vCierra']))
	{
		unset($_SESSION['vGen']);
	}
	
	$_SESSION['cache']=!$_SESSION['cache'];		//Si cache era 0 ahora es 1, y viceversa.

	include_once 'php/conexion.php';
	include_once 'php/Gal_HTML.php';
	include_once 'php/Coment.php';
	//Obtengo los comentarios.
	//$Coments=$con->query('select * from Comentarios');
	
?>
<section id="gal">
	<h1 class="titulo">Galería de Fotos</h1>
	<?php
		
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
		//Valores para las clases col-xx-xx de las imágenes.
		$imgBootstrap=new Arr_Gen_HTML
		(
			[
				' col-xs-',
				' col-sm-',
				' col-md-',
				' col-lg-',
				''
			],
			[12,6,4,3]
		);
		$Gal=new Gal_HTML
		(
			'select * from Imagenes',
			$con,
			new Obj_Gen_HTML
			(
				[       
					'<a class="','" href="index.php?vImgID=','#gal" >
						<p>','</p>
						<img src="','" width="200" height="200" />
					</a>
					'
				],
				[
					$imgBootstrap,
					'ID',
					'Titulo',
					'Url'
				]
			)
		);
		if(isset($_SESSION['vGen']))
		{
			$Gal->creaVisor
			(
				new Obj_Gen_HTML
				(
					[
						'
						<div class="difumina"></div>
						<div class="visor">
							<div class="row">
								
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2" style="margin-top:22%">
									<a href="index.php?vInc=-1&cache='.$_SESSION['cache'].'#gal" >
										<img src="img/flecha_i.png" />
									</a>
								</div>
								
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
									<div class="imgCont">
										<h2>',
										'<a href="index.php?vCierra=1#gal" class="cerrar">X</a>
										</h2>
										<img width="100%" height="100%" src="',
										'" alt="',
										'"/>					
									</div>										
								</div>
								
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2" style="margin-top:22%">
									<a href="index.php?vInc=1&cache='.$_SESSION['cache'].'#gal" ><img src="img/flecha_d.png" /></a>
								</div>
								
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="comentarios" > adfyu </div>
								</div>
							</div>
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
		}
		?>
		
		<?php
		
		//Genero el código HTML de la galería.
		echo $Gal->gen();
		
		
		//Creo el boton nueva imagen.
		$nImg=new Img
		(
			$con,
			[
				'Titulo'=>'Nueva Imagen',
				'Url'	=>'img/nueva_imagen.png'
			]
		);
		$comentsMod=new Obj_Gen_HTML
		(
			[
				'<div>
					<p>',
					'</p>
				</div>'
			],
			[
				'Contenido'
			]
		);
		$nImgMod=new Obj_Gen_HTML
		(
			[
				'<a class="',              
				'" href="index.php?gNImgDiag=1#gal" ><p>',
				'</p><img src="',
				'" width="200" height="200" /></a>'				
			],
			[
				$imgBootstrap,
				'Titulo',
				'Url'
			]
		);
	
		echo $nImgMod->gen($nImg);
	/*
		for($i=0;$i<count($Coments);$i++)
		{
			echo $comentsMod->gen($Coments[$i]);
		}
	*/
		if(isset($_GET['gNImgDiag']))
		{
			include_once('forms/nueva_imagen.html');
		}
	?>
</section>