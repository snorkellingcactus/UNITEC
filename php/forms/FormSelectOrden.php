<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrdenOption.php';
	
	
	class FormSelectOrden extends FormSelect
	{
		public $classLleno;
		public $prefixTop;
		public $prefixBottom;
		public $selectNext;

		//FormSelectOrden::__construct($names , $default)
		function __construct($parentForm)
		{

			parent::__construct($parentForm);

			$this->prefixBottom='b';
			$this->prefixTop='t';
			$this->classLleno='lleno';
			//$this->default=0;
			$this->selectNext=false;
			//$args=func_get_args();
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
			
			return new FormSelectOrdenOption($this->parentForm , $name , $value);
		}
		function trySelect($value)
		{
			if($this->mustBeSelected($value))
			{
				$this->selectNext=true;

				return true;
			}
			return false;
		}
		function buildOption($name , $value)
		{
			if($this->selectNext)
			{
				echo '<pre>Omitida:';print_r($value);echo ' == ';print_r($this->selectedValue);echo '</pre>';
				$this->selectNext=false;
				$this->default=$this->optionsLen;
			}
			if($this->trySelect($value))
			{
				return false;
			}

			return parent::buildOption($name , $value);
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
		public function renderChilds(& $doc , & $tag)
		{
			//echo '<pre>FormSelectOrden::renderChilds()</pre>';
			$bottom=new FormSelectOrdenEmptyOption('' , $this->prefixBottom);
			if($this->selectNext)
			{
				$bottom->setSelected();
			}
			parent::addOption
			(
				$bottom
			);

			return parent::renderChilds($doc , $tag);
		}
		public function addOption($option)
		{
			if($option===false)
			{
				return $this;
			}
			$option->fill->classList->add($this->classLleno);

			parent::addOption($option);

			//if($this->options[$this->optionsLen-1]->getValue()==$this->selectedValue )
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