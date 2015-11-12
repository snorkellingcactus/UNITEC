<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmRight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';

	class FormCliInc extends FormCliAdmSec
	{
		function __construct($id , $num)
		{
			parent::__construct('accionesSec' , 'inc' , $num , $id);

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