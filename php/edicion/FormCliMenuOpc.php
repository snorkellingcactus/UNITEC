<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmSec.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	
	class FormCliMenuOpc extends FormCliAdmSec
	{
		function __construct($id , $num, $visible)
		{
			parent::__construct('accionesMenu' , 'opc' , $num , $id , $visible);

			$this->buttons->appendChild
			(
				new FormCliDel($this)
			)->appendChild
			(
				new FormCliEdit($this , 1)
			);
		}
	}
?>