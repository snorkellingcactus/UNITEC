<?php
	//echo '<pre>Paso A</pre>';
	
	if(isset($_POST['conID']))
	{
		$this->cantidad=count($_POST['conID']);
	}
	if($this->getAction()===2)
	{
		$this->redirectToStepName('90_SQL_Evts.php');
	}
	if($this->getAction()===0)
	{
		include_once '90_SQL_Evts.php';
	}

	//$this->form->ancla='#nEvt';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelNombre.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelMensaje.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';

	$_SESSION['RaizID']=$_POST['RaizID'];
	
	$nombre=new FormLabelNombre($this->form);
	$descripcion=new FormLabelMensaje($this->form);
	$continuar=new FormContinuar($this->form);

	$this->form->appendChild
	(
		$nombre
	)->appendChild
	(
		$descripcion
	)->appendChild
	(
		$continuar
	)->setAction
	(
		$this->getStepUrlByName('90_SQL_Evts.php')
	);

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