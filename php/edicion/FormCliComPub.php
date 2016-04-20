<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliPublicar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelNombre.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelMensaje.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	class FormCliComPub extends FormCliBase
	{
		public $lNombre;
		public $lMensaje;

		function __construct($raizID)
		{
			parent::__construct('accionesCom');

			$raizID=new VariablePost('RaizID' , $raizID);

			$this->appendChild
			(
				$raizID
			)->appendChild
			(
				$this->lNombre=new FormLabelNombre()
			)->appendChild
			(
				$this->lMensaje=new FormLabelMensaje()
			)->appendChild
			(
				new FormCliPublicar()
			)->addToAttribute
			(
				'class' , 
				'FormCliCom'
			);
			//Revisar.
			if(isset($_POST['comConID']))
			{
				$this->setAttribute('id' , 'comRes');
			}
		}
	}
?>