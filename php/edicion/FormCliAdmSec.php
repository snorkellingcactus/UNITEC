<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmRight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	class FormCliAdmSec extends FormCliAdmRight
	{
		function __construct($formDirName , $tipo , $orden , $id , $visible)
		{
			parent::__construct($formDirName);

			$varTipo=new VariablePost($this , 'Tipo' , $tipo);
			$varOrden=new VariablePost($this , 'Orden' , $orden);
			$varConID=new VariablePost($this , 'conID' , $id);

			$this->appendChild
			(
				$varTipo->setMulti(0)
			)->appendChild
			(
				$varOrden->setMulti(0)
			)->appendChild
			(
				$varConID->setMulti(0)
			);

			if(!$visible)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliHidden.php';

				$this->buttons->appendChild(new FormCliHidden());
			}
		}
	}
?>