<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmRight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	class FormCliAdmSec extends FormCliAdmRight
	{
		function __construct($formDirName , $orden , $id , $visible)
		{
			parent::__construct($formDirName);


			//$varOrden=new VariablePost( 'Orden' , $orden);
			$varConID=new VariablePost('conID' , $id);

			$this->appendChild
			(
				$varConID
			);

			if(!$visible)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliHidden.php';

				$this->buttons->appendChild(new FormCliHidden());
			}
		}
	}
?>