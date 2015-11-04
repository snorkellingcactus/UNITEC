<?php
	//echo '<pre>Paso A</pre>';
	if(isset($_POST['conID']))
	{
		$this->form->cantidad=count($_POST['conID']);
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

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

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

		$archivo->inputUrl->setValue($imagen->Url);
		$visible->selectedValue=$imagen->Visible;
		//$this->form->autocomp['Prioridad']=$imagen['Prioridad'];
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

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';

	$continuar=new FormContinuar($this->form);

	$this->form->appendChild($titulo)
	->appendChild($alt)
	->appendChild($archivo)
	->appendChild($prioridad)
	->appendChild($visible)->appendChild
	(
		$labelTags
	)->appendChild($continuar)->setAction($this->getNextStepUrl());

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