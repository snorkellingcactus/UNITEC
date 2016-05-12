<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOption.php';

	//Se partió la herencia a este nivel por FormRadioLst, el cual no es un select pero comparte muchas
	//de sus propiedades.
	//Revisar . Por lo anterior setSize() debe ser un método de FormSelect únicamente.

	class FormSelectController
	{
		private $view;

		private $options;
		public $optionsLen;

		//deberia ser private con la creación de metodos apropiados:
		public $defaultIndex;
		public $valueToSelect;
		
		private $defaultToMax;
		
		
		private $selectedIndex;

		function __construct()
		{
			$this->options=[];
			$this->optionsLen=0;
			$this->valueToSelect=NULL;
			$this->selectedIndex=false;
			$this->defaultIndex=false;
			$this->defaultToMax=false;
		}
		function setView($view)
		{
			$this->view=$view;

			return $this;
		}
		function getView()
		{
			return $this->view;
		}

		function onRenderChilds()
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

			$this->view->appendChild($option);

			return $this;
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

		function getOptionsLen()
		{
			return $this->optionsLen;
		}
	}
?>