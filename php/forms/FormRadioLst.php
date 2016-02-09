<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadio.php';

	class FormRadioLst extends DOMTagContainer
	{
		public $lst;
		public $lstLen;
		public $default;
		public $selectedValue;
		public $name;
		public $parentForm;

		function __construct($parentForm , $name)
		{
			parent::__construct();

			$this->lst=[];
			$this->lstLen=0;
			$this->default=false;
			$this->selectedValue=NULL;
			$this->parentForm=$parentForm;

			$this->name=$name;
		}
		function setName($name)
		{
			$this->name=$name;

			return $this;
		}
		function addNew($value)
		{
			$this->add
			(
				$this->buildNew($value)
			);
		}
		function add($checkBox)
		{
			if($this->selectedValue===$checkBox->getValue())
			{
				$this->default=$this->lstLen;
			}

			$this->lst[$this->lstLen]=$checkBox;

			++$this->lstLen;

			return $this->appendChild($checkBox);
		}
		function buildNew($value)
		{
			return new FormRadio($this->parentForm , $this->name , $value);
		}
		function select($index)
		{
			if(isset($this->lst[$index]))
			{
				$this->lst[$index]->setSelected();
			}

			return $this;
		}
		function renderChilds(& $doc , & $tag)
		{
			if($this->default===false)
			{
				$this->select(0);
			}
			else
			{
				$this->select($this->default);
			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>