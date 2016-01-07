<?php
	//echo '<pre>Paso A</pre>';

	if($this->getAction()===2)
	{
		$this->redirectToStepName('90_SQL_Evts.php');
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrlNov.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAlt.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';

	$titulo=new FormLabelTitulo($this->form);
	$archivo=new FormLabelUrlNov($this->form);
	$alt=new FormLabelAlt($this->form);
	$visible=new FormLabelVisible($this->form);
	$prioridad=new FormLabelPrioridad($this->form);
	$labelTags=new FormLabelTags($this->form);

	$visible->input->default=1;

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';

		global $con;

		$imagen=new Img(NULL , $con);
		$imagen->getSQL(['TituloID'=>$_POST['conID'][$this->contador]]);

		$grupoID=$imagen->getTagsGrp();

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

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

		$archivo->inputUrl->setValue($imagen->Url);
		$visible->input->default=intVal($imagen->Visible);
		$prioridad->input->setValue
		(
			getSQLObjPriority
			(
				$imagen->PrioridadesGrpID,
				$_SESSION['lab']
			)
		);
		$alt->input->setValue
		(
			getTraduccion
			(
				$imagen->AltID,
				$_SESSION['lang']
			)
		);
		$titulo->input->setValue
		(
			getTraduccion
			(
				$imagen->TituloID,
				$_SESSION['lang']
			)
		);
	}
	if($this->getAction()===1)
	{
		$labelTags->input->setValue(getLabTagTree($_SESSION['lab']));
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';

	$continuar=new FormContinuar($this->form);

	$this->form->appendChild($titulo)
	->appendChild($alt)
	->appendChild($archivo)
	->appendChild($prioridad)
	->appendChild($visible)->appendChild
	(
		$labelTags
	)->appendChild($continuar)->setAction($this->getStepUrlByName('90_SQL_Evts.php'));

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