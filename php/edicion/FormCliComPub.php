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
		public $parentForm;

		function __construct($raizID)
		{
			parent::__construct('accionesCom');

			$raizID=new VariablePost($this , 'RaizID' , $raizID);

			$this->appendChild
			(
				$raizID->setMulti(0)
			)->appendChild
			(
				$this->lNombre=new FormLabelNombre($this)
			)->appendChild
			(
				$this->lMensaje=new FormLabelMensaje($this)
			)->appendChild
			(
				new FormCliPublicar($this)
			)->classList->add
			(
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