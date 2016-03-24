<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class VariablePost extends FormInput
	{
		function __construct( $name , $value)
		{
			parent::__construct( 'hidden');
			$this->setName($name)->setValue($value);
		}
		function setID($id)
		{
			return $this->setAttribute('id' , $id);
		}
	}
?>