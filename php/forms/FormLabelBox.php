<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBoxBase.php';
	
	class FormLabelBox extends FormLabelBoxBase
	{
		public $input;
		public $inputID;
		public $inputName;

		//FormLabelBox::__construct([$name [, $id [, $label [, $input]]]])
		function __construct()
		{
			parent::__construct('div');

			$args=func_get_args();

			if(isset($args[3]))
			{
				$this->setInput($args[3]);
			}

			if(isset($args[2]))
			{
				$this->input->setName($args[0]);
				$this->input->setID($args[1]);

				$this->setLabelName($args[2]);
			}
		}
		function setInput($input)
		{
			$this->label->setInput
			(
				$input
			);

			$this->appendChild
			(
				$this->input=$input
			);
		}
		function newLabel()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';

			return new FormLabel();
		}
	}
?>