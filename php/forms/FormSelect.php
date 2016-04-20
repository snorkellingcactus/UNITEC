<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOption.php';

	class FormSelect extends FormInputBase
	{
		private $options;
		public $optionsLen;

		//deberia ser private con la creación de metodos apropiados:
		public $defaultIndex;
		public $valueToSelect;
		
		private $defaultToMax;
		private $sizeToMax;
		
		private $selectedIndex;

		function __construct()
		{
			parent::__construct( 'select' );

			$this->options=[];
			$this->optionsLen=0;
			$this->valueToSelect=NULL;
			$this->selectedIndex=false;
			$this->defaultIndex=false;
			$this->defaultToMax=false;
			$this->sizeToMax=false;
		}

		function renderChilds(&$tag)
		{
			if($this->defaultToMax && $this->defaultIndex===false)
			{
				$this->setSelected($this->optionsLen-1);
			}
			else
			{
				if($this->defaultIndex===false)
				{
					$this->setSelected(0);
				}
				else
				{
					//echo '<pre>Default: ';print_r($this->default);echo '</pre>';
					$this->setSelected($this->defaultIndex);
				}
			}
			if($this->sizeToMax)
			{
				$this->setSize($this->optionsLen);
			}

			return parent::renderChilds($tag);
		}
		public function newOption($name , $value)
		{
			return new FormSelectOption($name , $value);
		}
		public function mustBeSelected($value)
		{
			if($value===$this->valueToSelect)
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
				$this->defaultIndex=$this->optionsLen;
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
				$this->trySelect($args[1]);
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
		function setSelected($index)
		{
			if(isset($this->options[$index]))
			{
				$this->options[$index]->setSelected();
			}

			$this->selectedIndex=$index;

			return $this;
		}
		function setSizeToMax()
		{
			$this->sizeToMax=true;

			return $this;
		}
		function getSizeToMax()
		{
			return $this->sizeToMax;
		}
		function setDefaultToMax()
		{
			$this->defaultToMax=true;

			return $this;
		}
		function getDefaultValue()
		{
			if(!isset($this->options[$this->selectedIndex]))
			{
				return $this->valueToSelect;
			}
			return $this->options[$this->selectedIndex]->getValue();
		}
		function getValue()
		{
			return $this->getDefaultValue();
		}
		function setDefaultIndex($index)
		{
			$this->defaultIndex=$index;
		}
		function setValueToSelect($valueToSelect)
		{
			$this->valueToSelect=$valueToSelect;
		}
		function getValueToSelect()
		{
			return $this->valueToSelect;
		}
	}
?>