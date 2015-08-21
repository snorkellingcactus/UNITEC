<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrdenOption.php';
	
	
	class FormSelectOrden extends FormSelect
	{
		public $classLleno;
		public $prefixTop;
		public $prefixBottom;

		//FormSelectOrden::__construct($names , $default)
		function __construct()
		{

			parent::__construct();

			$this->prefixBottom='b';
			$this->prefixTop='t';
			$this->classLleno='lleno';

			$args=func_get_args();
		}
		public function newOption($name , $value)
		{
			if(empty($name))
			{
				$name=$this->emptyName($name);
			}
			if(empty($value))
			{
				$value=$this->emptyValue($name);
			}
			
			return new FormSelectOrdenOption($name , $value);
		}
		public function appendChild($child)
		{
			if($child instanceof FormSelectOrdenOption)
			{
				parent::appendChild($child->empty);
				return parent::appendChild($child->fill);
			}
			return parent::appendChild($child);
		}
		public function renderChilds()
		{
			parent::addOption
			(
				new FormSelectOrdenEmptyOption($this->prefixBottom)
			);

			return parent::renderChilds();
		}
		public function addOption($option)
		{
			$option->fill->classList->add($this->classLleno);

			parent::addOption($option);
		}
		function setSize($size)
		{
			$size=(2*$size)+1;

			if($this->sizeToMax)
			{
				$size=$size-2;
			}
			return parent::setSize($size);
		}
		private function emptyName($name)
		{
			return $this->optionsLen+1;
		}
		private function emptyValue($name)
		{
			return $this->prefixTop.$this->optionsLen;
		}
	}
?>