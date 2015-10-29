<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormSecBtn extends FormInput
	{
		function __construct($parentForm , $name , $value)
		{
			parent::__construct($parentForm , 'submit');

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
			)->setMulti(0)->classList->add('boton-seccion')->add($name);
		}
	}
?>