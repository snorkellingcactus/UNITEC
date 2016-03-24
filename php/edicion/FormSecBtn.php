<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormSecBtn extends FormInput
	{
		function __construct($name , $value)
		{
			parent::__construct('submit');

			$this->setName
			(
				$name
			)->setValue
			(
				$value
			)->setAttribute
			(
				'title',
				$value
			)->classList->add('boton-seccion')->add($name);
		}
	}
?>