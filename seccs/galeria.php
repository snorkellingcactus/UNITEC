<section id="gal">
	<h1 class="titulo">Galería de Fotos</h1>
	<?php
		//Si todavía no se inicio sesion, se inicia.
		if(session_status()==PHP_SESSION_NONE)
		{
			session_start();
		}
		$modoAdmin=isset($_SESSION['adminID']);
		//Cache por defecto vale 0.
		if(!isset($_SESSION['cache']))
		{
			$_SESSION['cache']=0;
		}
		//Se está especificada alguna imagen para mostrar, 
		//indico que se genere el visor.
		if(isset($_GET['vImgID']))
		{
			$_SESSION['vImgID']=intval($_GET['vImgID']);
			$_SESSION['vGen']=1;
		}
		if(isset($_SESSION['vImg']))
		{
			$_SESSION['vGen']=1;
		}
		//El visor no se va a generar.
		if(isset($_GET['vCierra']))
		{
			unset($_SESSION['vGen']);
			unset($_SESSION['vImg']);
		}
		//Para pruebas, destruye la sesión actual.
		if(isset($_GET['sesdest']))
		{
			session_destroy();
		}
		//Variable utilizada para corregir un error con enlaces que contienen
		//anclas y variables get. Si el enlace es siempre el mismo, no refresca
		//el código PHP. La variable cache alterna entre 0 y 1 para evitar el problema.
		$_SESSION['cache']=!$_SESSION['cache'];
	
		include_once 'php/conexion.php';
		include_once 'php/Gal_HTML.php';
		
		$dImg=new NULL_Gen_HTML();
		//Diferencias en modo admin.
		if($modoAdmin)
		{
			//Elimina Imagen.
			if(isset($_GET['eImgID']))
			{
				$con->query('delete from Imagenes where ID='.$_GET['eImgID']);
			}
			//Se rellenó el formulario de nueva imagen, la inserto en la bd.
			if(isset($_POST['Titulo']))
			{
				
				//Creo la imagen y le asigno las propiedades.
				$Img=new Img($con);
				$Img->Titulo=$_POST['Titulo'];
				$Img->Url=$_POST['Url'];
				$Img->Alt=$_POST['Alt'];
			
				//La inserto en la bd.
				$Img->insSQL();
			}

			//Cruz ( x ) para eliminar imágenes.
			$dImg=new Obj_Gen_HTML
			(
				[
					'<a class="eImg" href="index.php?eImgID=','#gal">x</a>'
				],
				[
					'ID'
				]
			);
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
		$imgMod=new Obj_Gen_HTML
		(
			[       
				'
				<div class="gImg ','">
					<a href="index.php?vImgID=','#gal" >
						<p>','</p>
						<img src="','" width="200" height="200" />
					</a>','
				</div>
				'
			],
			[
				$imgBootstrap,
				'ID',
				'Titulo',
				'Url',
				$dImg
			]
		);
		$Gal=new Gal_HTML
		(
			'select * from Imagenes',
			$con,
			$imgMod
		);
		if(isset($_SESSION['vGen']))
		{
			//Includes necesarios para imprimir comentarios.
			include_once 'php/Coment.php';
			include_once 'php/Contenido.php';

			//Operaciones cuando se llenó un formulario de nuevo comentario.
			if(isset($_POST['comContenido']))
			{
				//Include necesario para manejar llaves foráneas.
				include_once 'php/Foraneas.php';
	
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
			
			$Gal->creaVisor();
			$HTMLBuff=$Gal->gen();
			
			//Genero los comentarios.
			$comentsMod=new Arr_Gen_HTML
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
					$comentBuff=$comentBuff.$comentsMod->recorre($consulta[$i]->fetch_all(MYSQL_ASSOC)[0]);
				}
			}
			
			echo $HTMLBuff.$Gal->visor->gen
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
									<div class="comentarios" >
// 										'.$comentBuff.'
									</div>
								</div>
								'.file_get_contents('forms/nuevo_coment.php').
								'
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
		else
		{
			//Genero el código HTML de la galería.
			echo $Gal->gen();
		}

		//
		if(isset($Gal->visor))
		{
	?>
	<?php
		}
		if(isset($_GET['nComentDiag']))
		{
			include_once('forms/nuevo_comentario.html');
		}
		if($modoAdmin)
		{
			//Creo el boton nueva imagen.
			$nImg=new Img
			(
				$con,
				[
					'Titulo'=>'Nueva Imagen',
					'Url'	=>'img/nueva_imagen.png'
				]
			);
			$nImgMod=new Obj_Gen_HTML
			(
				[
					'<div class="nImg ','" >
						<a href="index.php?gNImgDiag=1#gal" >',
							'<img src="','" width="200" height="200" />
						</a>
					</div>'			
				],
				[
					$imgBootstrap,
					'Titulo',
					'Url'
				]
			);
		
			echo $nImgMod->gen($nImg);
	
			//::::::::Formularios:::::::::::::

			//Nueva Imagen.
			if(isset($_GET['gNImgDiag']))
			{
				include_once('forms/nueva_imagen.html');
			}
		}
	?>
</section>