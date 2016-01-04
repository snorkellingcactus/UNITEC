<form id="vImg" method="POST" action="Imagenes.php" target="_blank"></form>
<?php

	//Si todavía no se inicio sesion, se inicia.
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
	start_session_if_not();

	//Para pruebas, destruye la sesión actual.
	if(isset($_GET['sesdest']))
	{
		session_destroy();
	}
	//Cache por defecto vale 0.
	if(!isset($_SESSION['cache']))
	{
		$_SESSION['cache']=0;
	}
	if(isset($_SESSION['imgLst']))
	{
		unset($_SESSION['imgLst']);
	}
	if(isset($_GET['cache']))
	{
		$_SESSION['cache']=!$_GET['cache']||0;
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Contenido.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Gal_HTML.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Traduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
	$modoAdmin=isset($_SESSION['adminID']);

	if($modoAdmin)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliGal.php';
		
		$formGal=new FormCliGal();
		echo $formGal->getHTML();
	}
	
	//:::::::::::::::::::::::::::::::HTML::::::::::::::::::::::::::::::::::::
	//Valores para las clases col-xx-xx de las imágenes.
	global $con;

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';
			
	$limit=getValFromNombreID('limit' , $this->opcGrpID , $this->opcSetsID);
	if($this->limit && is_array($limit) && $limit[0]!=='0')
	{
		$limit=$limit[0];
		$limitStr='LIMIT '.$limit;
	}
	else
	{
		$limit=$limitStr=false;
	}

	$imgLst=fetch_all
	(
		$con->query
		(
			'	SELECT Imagenes.*
				FROM Imagenes
				LEFT OUTER JOIN TagsTarget
				ON TagsTarget.GrupoID=Imagenes.TagsGrpID
				LEFT OUTER JOIN Laboratorios
				ON Laboratorios.ID='.$_SESSION['lab'].'
				WHERE TagsTarget.TagID=Laboratorios.TagID
				ORDER BY Imagenes.Prioridad DESC
			'.$limitStr
		),
		MYSQLI_ASSOC
	);	//Respuesta SQL como array asociativo.

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

	if(isset($imgLst[0]))
	{
		$lName=getLabName();
		$i=0;
		while(isset($imgLst[$i]))
		{
			$imgAct=& $imgLst[$i];

			$imgAct['TituloCon']=getTraduccion($imgAct['TituloID'] , $_SESSION['lang']);
			$imgAct['AltCon']=getTraduccion($imgAct['AltID'] , $_SESSION['lang']);
			$imgAct['Fecha']=new DateTime(date($imgAct['Fecha']));
			$imgAct['Fecha']=$imgAct['Fecha']->format('Y-m-d');
			$imgAct['lName']=$lName;
			
			$imgAct['afectado']=false;
			
			if(isset($formGal))
			{
				$imgAct['formBuilder']=$formGal;
			}
			if
			(
				!empty($formGalRecv->afectados) &&
				in_array($imgAct['ID'], $formGalRecv->afectados)
			)
			{
				$imgAct['afectado']=true;
			}

			++$i;
		}

		$Gal=new Gal_HTML
		(
			$imgLst,
			new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/esq/gal_img.php')
		);
		//Genero el código HTML de la galería.
		$Gal->gen();
		if($limit!==false && isset($imgLst[$limit-1]))
		{
			?>
				<div class="ver-mas">
					<a href="/?vRecID=<?php echo $this->secID?>" ><?php echo gettext('Ver todas las imágenes') ?></a>
				</div>
			<?php
		}
	}
	else
	{
		?>
			<p>
				<?php echo gettext('Sin Imágenes')?>
			</p>
		<?php
	}

?>
<div class="clearfix"></div>