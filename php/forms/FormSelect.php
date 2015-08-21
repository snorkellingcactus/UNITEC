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

		function __construct()
		{
			parent::__construct('select');

			$this->options=[];
			$this->optionsLen=0;
			$this->default=false;
			$this->selectedValue=NULL;
			$this->defaultToMax=false;
			$this->sizeToMax=false;

			$args=func_get_args();
			$iMax=func_num_args();
			for($i=0;$i<$iMax;$i++)
			{
				$this->addOption($args[$i]);
			}
		}

		function renderChilds()
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

			return parent::renderChilds();
		}
		public function newOption($name , $value)
		{
			return new FormSelectOption($name , $value);
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

			return $this->newOption($args[0] , $args[1]);
		}
		function addOption($option)
		{
			if($option->getValue()!==NULL && $option->getValue()==$this->selectedValue)
			{
				$this->default=$this->optionsLen;
/*
				echo '<pre>Default:';
				print_r($this->default);
				echo '</pre>';
*/
			}

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