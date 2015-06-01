<div class="novedades">
	<?php
		//::::::::::Variables de Sesion::::::::::::::
		if(session_status()==PHP_SESSION_NONE)
		{
			session_start();
		}
		//Cache por defecto vale 0.
		if(!isset($_SESSION['cache']))
		{
			$_SESSION['cache']=0;
		}
		//Invierto el valor boleano de cache.
		if(isset($_GET['cache']))
		{
			$_SESSION['cache']=!$_GET['cache']||0;
		}
		//:::::::::HTML y Diálogos:::::::::::
		//Diferencias al ser admin.
		if(!empty($_SESSION['adminID']))
		{
				//De momento se especifica el ancla de la url action del form con la variable
				//fAction y el id del form con fId.
				$fAction='index.php#nov';
				$fId='Nov';
				$cMax=0;
				
				//Incluyo las acciones para las novedades.
				include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/acciones.php';
		}

		//Si se rellenó el formulario nueva novedad la envío a la bd.
		if(isset($_POST['nNov']))
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Traduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';

			$iMax=count('nNov');

			if(isset($_SESSION['accion'])  && $_SESSION['accion']==='edita')
			{
				unset($_SESSION['accion']);
			
				$nNov=new Novedad($con);

				for($i=0;$i<$iMax;$i++)
				{
					$nNov->getSQL
					(
						[
							'ID'=>$_SESSION['conID'][$i]
						]
					);

					$nNov->ImagenID=$_POST['Imagen'][$i];
					$nNov->Visible=$_POST['Visible'][$i];
					$nNov->updSQL(false , ['ID']);

					updTraduccion($_POST['Descripcion'][$i] , $nNov->DescripcionID , $_SESSION['lang']);
					updTraduccion($_POST['Titulo'][$i] , $nNov->TituloID , $_SESSION['lang']);
				}
			}
			else
			{
				for($i=0;$i<$iMax;$i++)
				{
					$titulo=nTraduccion($_POST['Titulo'][$i] , $_SESSION['lang']);

					$descripcion=nTraduccion($_POST['Descripcion'][$i] , $_SESSION['lang']);

					$horaLoc=getdate();

					$nov=new Novedad($con);

					$nov->ImagenID=$_POST['Imagen'][$i];
					$nov->Fecha=$horaLoc['year'].'-'.$horaLoc['mon'].'-'.$horaLoc['mday'];

					$nov->insForaneas($descripcion , ['DescripcionID'=>'ContenidoID']);
					$nov->insForaneas($titulo , ['TituloID'=>'ContenidoID']);

					$nov->insSQL();
				}
			}
			unset($nov , $titulo , $descripcion , $horaLoc , $iMax , $i , $_POST['Titulo'] , $_POST['Descripcion'] , $_POST['Lenguaje'] , $_POST['nNov'] , $_SESSION['conID'] , $_SESSION['form']);
		}

		//Acciones con las seleccionadas.
		if(isset($_SESSION['form']) && $_SESSION['form']==='accionesNov' && isset($_SESSION['accion']) && $_SESSION['accion']==='elimina')
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';

			$iMax=count($_SESSION['conID']);
			for($i=0;$i<$iMax;$i++)
			{
				$contenidos=$con->query('select TituloID , DescripcionID from Novedades where ID='.$_SESSION['conID'][$i]);
				$contenidos=fetch_all($contenidos , MYSQLI_ASSOC)[0];

				$con->query('delete from Novedades where ID='.$_SESSION['conID'][$i]);
				$con->query('delete from Contenidos where ID='.$contenidos['TituloID'].' or ID='.$contenidos['DescripcionID']);
			}

			unset($_SESSION['conID'] , $_SESSION['form'] , $_SESSION['elimina']);
		}

		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';

		$novedades=$con->query('select * from Novedades order by Fecha desc');
		$novedades=fetch_all($novedades , MYSQLI_ASSOC);

		$cantidad=count($novedades);
		$buff='';

		if(!$cantidad || !$novedades)
		{
			$buff='<p>Sin novedades</p>';
		}
		else
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Inc_Esq.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/jBBCode1_3_0/JBBCode/Parser.php';


			$novedadesHTML=new Inc_Esq('esq/novedad.php');

			for($i=0;$i<$cantidad;$i++)
			{
				$novAct=$novedades[$i];

				$imagen=$con->query('select Url from Imagenes where ID='.$novAct['ImagenID']);
				if($imagen)
				{
					$imagen=fetch_all($imagen , MYSQLI_ASSOC)[0]['Url'];
				}
				else
				{
					$imagen='http://loquesea';
				}

				$titulo=getTraduccion($novAct['TituloID'] , $_SESSION['lang']);
				$descripcion=getTraduccion($novAct['DescripcionID'] , $_SESSION['lang']);

				$parser=new JBBCode\Parser();
				
				include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/parser_definiciones.php';

				$parser->parse($descripcion);

				$descripcion=$parser->getAsText();

				$novedad=new Novedad
				(
					$con,
					[
						'ID'=>$novAct['ID'],
						'Imagen'=>$imagen,
						'Titulo'=>$titulo,
						'Descripcion'=>substr($descripcion , 0 , 500),
						'Fecha'=>$novAct['Fecha']
					]
				);

				$buff=$buff.$novedadesHTML->recorre($novedad);
			}
		}

		echo $buff;
     
	?>
</div>