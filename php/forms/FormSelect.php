<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOption.php';

	class FormSelect extends FormInputBase
	{
		public $options;
		public $optionsLen;
		public $default;
		public $defaultToMax;
		public $sizeToMax;
		public $selectedValue;

		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'select');

			$this->options=[];
			$this->optionsLen=0;
			$this->default=false;
			$this->selectedValue=NULL;
			$this->defaultToMax=false;
			$this->sizeToMax=false;
		}

		function renderChilds(& $doc , & $tag)
		{
			if($this->defaultToMax && $this->default===false)
			{
				$this->select($this->optionsLen-1);
			}
			else
			{
				if($this->default===false)
				{
					$this->select(0);
				}
				else
				{
					$this->select($this->default);
				}
			}
			if($this->sizeToMax)
			{
				$this->setSize($this->optionsLen);
			}

			return parent::renderChilds($doc , $tag);
		}
		public function newOption($name , $value)
		{
			return new FormSelectOption($name , $value);
		}
		public function mustBeSelected($value)
		{
			if($value==$this->selectedValue)
			{
				return true;
/*
				echo '<pre>Default:';
				print_r($this->default);
				echo '</pre>';
*/
			}
			return false;
		}
		public function trySelect($value)
		{
			if($this->mustBeSelected($value))
			{
				$this->default=$this->optionsLen;
			}
		}
		public function buildOption()
		{
			$args=func_get_args();
			if(!isset($args[0]))
			{
				$args[0]=NULL;
			}
			if(!isset($args[1]))
			{
				$args[1]=NULL;
			}
			else
			{
				$this->trySelect($args[0]);
			}

			return $this->newOption($args[0] , $args[1]);
		}
		function addOption($option)
		{
			$this->options[$this->optionsLen]=$option;
			++$this->optionsLen;

			$this->appendChild($option);

			return $this;
		}
		function setSize($size)
		{
			return $this->setAttribute('size' , $size);
		}
		function select($index)
		{
			$this->options[$index]->setSelected();

			return $this;
		}
		function setSizeToMax()
		{
			$this->sizeToMax=true;

			return $this;
		}
		function setDefaultToMax()
		{
			$this->defaultToMax=true;

			return $this;
		}
	}
?>