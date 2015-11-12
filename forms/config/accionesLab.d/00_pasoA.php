<?php

	if($this->getAction()===2)
	{
		$this->redirectToStepName('90_SQL_Evts.php');
	}
	echo '<pre>Labs!</pre>';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUbicacion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelDireccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelNombre.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTelefono.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelEnlace.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelMail.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelFacebook.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTwitter.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	$ubicacion=new FormLabelUbicacion($this->form);
	$direccion=new FormLabelDireccion($this->form);
	$tag=new FormLabelTag($this->form);
	$nombre=new FormLabelNombre($this->form);
	$telefono=new FormLabelTelefono($this->form);
	$enlace=new FormLabelEnlace($this->form);
	$mail=new FormLabelMail($this->form);
	$facebook=new FormLabelFacebook($this->form);
	$twitter=new FormLabelTwitter($this->form);

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

		global $con;

		$lab=new Laboratorio(null , $con);
		$lab->getSQL
		(
			[
				'ID'=>$_SESSION['conID']
			]
		);
		$ubicacion->latitud->input->setValue($lab->Latitud);
		$ubicacion->longitud->input->setValue($lab->Longitud);

		$direccion->input->setValue(getTraduccion($lab->DireccionID , $_SESSION['lang']));
		$tag->input->setValue(getTagName($lab->TagID));
		$nombre->input->setValue(getTraduccion($lab->NombreID , $_SESSION['lang']));
		$telefono->input->setValue($lab->Telefono);
		$enlace->input->selectedValue=$lab->Enlace;
		$mail->input->setValue($lab->Mail);
		$facebook->input->setValue($lab->Facebook);
		$twitter->input->setValue($lab->Twitter);
	}
	$this->form->appendChild
	(
		$nombre
	)->appendChild
	(
		$tag
	)->appendChild
	(
		$mail
	)->appendChild
	(
		$direccion
	)->appendChild
	(
		$telefono
	)->appendChild
	(
		$enlace
	)->appendChild
	(
		$ubicacion
	)->appendChild
	(
		$facebook
	)->appendChild
	(
		$twitter
	);

	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

		$this->form->appendChild(new FormContinuar($this->form))
		->appendChild(new FormVolver($this->form));

		$this->form->setAction($this->getStepUrlByName('90_SQL_Evts.php'));
	}
?>