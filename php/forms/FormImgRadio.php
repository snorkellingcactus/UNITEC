<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMGalImg.php';

	class FormImgRadio extends DOMGalImg
	{
		public $input;

		function __construct($parentForm , $name , $value)
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadio.php';

			$this->p->appendChild
			(
				$this->input=new FormRadio($parentForm , $name , $value)
			);
		}
		function setSelected()
		{
			return $this->input->setSelected();
		}
		function getValue()
		{
			return $this->input->getValue();
		}
	}
?>