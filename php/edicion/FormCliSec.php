<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmSec.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';

	class FormCliSec extends FormCliAdmSec
	{
		function __construct($id , $orden , $visible)
		{
			parent::__construct('accionesSec' , 'sec' , $orden , $id , $visible);

			$this->buttons->appendChild
			(
				new FormCliDel($this)
			)->appendChild
			(
				new FormCliEdit($this)
			);
		}
	}
?>