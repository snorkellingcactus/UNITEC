<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class VariablePost extends FormInput
	{
		function __construct($parentForm , $name , $value)
		{
			parent::__construct($parentForm , 'hidden');
			$this->setName($name)->setValue($value);
		}
		function setID()
		{
			return $this->setAttribute('id' , $id);
		}
	}
?>