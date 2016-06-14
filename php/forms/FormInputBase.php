<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormMultipleElement.php';

	class FormInputBase extends FormMultipleElement
	{
		function __construct()
		{
			$this->label=false;
			
			$args=func_get_args();
			if(isset($args[0]))
			{
				parent::__construct($args[0]);
			}
			else
			{
				parent::__construct();
			}

			if(isset($args[1]))
			{
				$this->name->setPreffix($args[1]);
			}
			if(isset($args[2]))
			{
				$this->id->setPreffix($args[2]);
			}
		}
		public function setValue($value)
		{
			return $this->setAttribute('value' , $value);
		}
		public function getValue()
		{
			//Revisar.
			if($this->hasAttribute('value'))
			{
				return $this->getAttribute('value');
			}
		}
		public function setPlaceHolder($placeHolder)
		{
			return $this->setAttribute('placeholder' , $placeHolder);
		}
	}
?>