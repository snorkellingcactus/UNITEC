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

	$titulo=new FormLabelTitulo($this->form);
	$archivo=new FormLabelUrlNov($this->form);
	$alt=new FormLabelAlt($this->form);
	$visible=new FormLabelVisible($this->form);
	$prioridad=new FormLabelPrioridad($this->form);

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
		global $con;

		$imagen=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Imagenes 
					WHERE TituloID='.$_POST['conID'][$this->contador]
			),
			MYSQLI_ASSOC
		)[0];

		$archivo->inputUrl->setValue($imagen['Url']);
		$visible->selectedValue=$imagen['Visible'];
		//$this->form->autocomp['Prioridad']=$imagen['Prioridad'];
		$alt->input->setValue
		(
			getTraduccion
			(
				$imagen['AltID'],
				$_SESSION['lang']
			)
		);
		$titulo->input->setValue
		(
			getTraduccion
			(
				$imagen['TituloID'],
				$_SESSION['lang']
			)
		);
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';

	$continuar=new FormContinuar($this->form);

	$this->form->appendChild($titulo)
	->appendChild($alt)
	->appendChild($visible)
	->appendChild($archivo)
	->appendChild($prioridad)
	->appendChild($continuar)->setAction($this->getNextStepUrl());

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