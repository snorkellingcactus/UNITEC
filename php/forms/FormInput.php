<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	class FormInput extends FormInputBase
	{
		function __construct($tipo)
		{
			parent::__construct('input');
			
			$this->tag->setAttribute('type' , $tipo);
		}
	}
	
	//Un input con label.
	
	/*
	class FormDate extends FormContainer
	{
		public $lBoxAno;

		function __construct($namePrefix , $idPrefix)
		{
			$this->lBoxAno=new FormLabelBox();
			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->input=new FormInput($args[3]);
			}
		}
	}
	*/
	//class FormTxtArea
	//class FormTxtDateMon
?>