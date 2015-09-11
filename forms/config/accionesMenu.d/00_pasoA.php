<?php
	//echo '<pre>Paso A</pre>';
	
	if(isset($_POST['conID']))
	{
		$this->cantidad=count($_POST['conID']);
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';

	$titulo=new FormLabelTitulo($this->form);
	$url=new FormLabelUrl($this->form);
	$lugar=new FormLabelLugar($this->form);
	$visible=new FormLabelVisible($this->form);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	global $con;

	if($this->getAction()===0)
	{

		$opcion=fetch_all
		(
			$con->query
			(
				'	SELECT *
					FROM Menu
					WHERE ContenidoID='.$_POST['conID']
			),
			MYSQLI_ASSOC
		)[0];

		$url->input->setValue($opcion['Url']);
		$visible->input->selectedValue=$opcion['Visible'];
		//$this->form->autocomp['Prioridad']=$opcion['Prioridad'];
		$titulo->input->setValue
		(
			getTraduccion
			(
				$opcion['ContenidoID'],
				$_SESSION['lang']
			)
		);

		$lugar->input->selectedValue=$_POST['conID'];
	}

	$lleno=fetch_all
	(
		$con->query
		(
			'	SELECT ContenidoID,ContenidoID
				FROM Menu
				WHERE 1
				ORDER BY Prioridad ASC
			'
		),
		MYSQLI_NUM
	);

	$iMax=count($lleno);
	for($i=0;$i<$iMax;$i++)
	{
		$lleno[$i][0]=getTraduccion($lleno[$i][0] , $_SESSION['lang']);
	}

	$lugar->setOptionsFromSQLRes
	(
		$lleno
	);

	$this->form->appendChild($titulo)
	->appendChild(new ClearFix())
	->appendChild($url)
	->appendChild(new ClearFix)
	->appendChild($lugar)
	->appendChild(new ClearFix())
	->appendChild($visible);

	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

		$this->form->appendChild(new FormContinuar($this->form))
		->appendChild(new FormVolver($this->form));

		$this->form->setAction($this->getNextStepUrl());
	}
?>