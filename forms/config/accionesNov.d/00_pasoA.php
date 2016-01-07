<?php
	if($this->getAction()===2)
	{
		$this->redirectToStepName('90_SQL_Evts.php');
	}
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelImagen.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';

	$titulo=new FormLabelTitulo($this->form);
	$descripcion=new FormLabelContenido($this->form);
	$visible=new FormLabelVisible($this->form);
	$selectImg=new FormLabelImagen($this->form , 'Imagen' , 'imagen' , gettext('Imagen'));
	$labelTags=new FormLabelTags($this->form);
	$prioridad=new FormLabelPrioridad($this->form);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

	global $con;

	if($this->form->srvBuilder->getAction()===0)
	{
		$novedad=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Novedades 
					WHERE ID='.$this->form->srvBuilder->conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$grupoID=new Novedad(['ID'=>$this->form->srvBuilder->conIDAct] , $con);
		$grupoID=$grupoID->getTagsGrp();

		if(isset($grupoID[0][0]))
		{
			$labelTags->input->setValue
			(
				getTagsStr($grupoID[0][0])
			);
		}
		else
		{
			echo '<pre>No group</pre>';
		}

		$visible->input->selectedValue=$novedad['Visible'];
		$prioridad->input->setValue
		(
			getSQLObjPriority
			(
				$novedad['PrioridadesGrpID'],
				$_SESSION['lab']
			)
		);

		$descripcion->input->setValue
		(
			getTraduccion
			(
				$novedad['DescripcionID'] ,
				$_SESSION['lang']
			)
		);
		$titulo->input->setValue
		(
			getTraduccion
			(
				$novedad['TituloID'] ,
				$_SESSION['lang']
			)
		);

		$selectImg->input->selectedValue=$novedad['ImagenID'];
	}
	if($this->getAction()===1)
	{
		$labelTags->input->setValue(getLabTagTree($_SESSION['lab']));
	}

	$Imgs=fetch_all
	(
		$con->query
		(
			'	SELECT Imagenes.ID,Imagenes.AltID
				FROM Imagenes
				WHERE 1
			'
		),
		MYSQLI_NUM
	);

	$i=0;
	while(isset($Imgs[$i]))
	{
		$imgId=$Imgs[$i][0];

		$selectImg->input->addNewImgRadio
		(
			$imgId,
			'/img/miniaturas/galeria/'.$imgId.'.png',
			getTraduccion($Imgs[$i][1] , $_SESSION['lang'])
		);

		++$i;
	}
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';

	$continuar=new FormContinuar($this->form);

	$this->form->appendChild($titulo)
	->appendChild($descripcion)
	->appendChild($selectImg)
	->appendChild($visible)
	->appendChild($prioridad)
	->clearFix()->appendChild
	(
		$labelTags
	)->appendChild($continuar)
	->setAction($this->getStepUrlByName('90_SQL_Evts.php'));

	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

		$this->form->appendChild(new FormVolver($this->form));
	}
	else
	{
		$continuar->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
		$this->form->appendChild(new ClearFix())->appendChild(new DOMTag('hr'));
	}
?>