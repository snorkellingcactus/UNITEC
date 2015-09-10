<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';
	
	class FormLabelBox extends DOMTag
	{
		public $label;
		public $input;
		public $name;
		public $id;

		//FormLabelBox::__construct([$name [, $id [, $label [, $input]]]])
		function __construct()
		{
			
			parent::__construct('div');

			$this->label=new FormLabel();
			$this->classList->add('FormLabelBox');


			$args=func_get_args();
			if(isset($args[2]))
			{
				$this->name=$args[0];
				$this->id=$args[1];

				$this->setLabelName($args[2]);
			}

			$this->appendChild($this->label);

			if(isset($args[3]))
			{
				$this->setInput($args[3]);
			}
			
		}
		function setInput($input)
		{
			$this->input=$input;

			$this->appendChild
			(
				$input->
				setID($this->id)->
				setName($this->name)->appendLabel($this->label)
			);
		}
		function setLabelName($name)
		{
			$this->label->setTagValue($name);
		}
	}
?>