<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBoxBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/Indexable.php';
	
	class FormLabelBox extends FormLabelBoxBase implements Indexable
	{
		public $input;
		public $inputID;	//Figurita?
		public $inputName;	//Figurita?

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
		function setIndex(&$index)
		{
			$this->input->setIndex($index);
			$this->label->setIndex($index);
		}
		function newLabel()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';

			return new FormLabel();
		}
	}
?>