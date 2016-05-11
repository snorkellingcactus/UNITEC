<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectController.php';

	class FormSelectOrdenController extends FormSelectController
	{
		public $classLleno;
		public $prefixTop;
		public $prefixBottom;
		public $selectNext;

		function trySelect($value)
		{
			if($this->mustBeSelected($value))
			{
				$this->selectNext=true;

				return true;
			}
			return false;
		}
		public function __construct()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrdenOption.php';

			parent::__construct();

			$this->prefixBottom='b';
			$this->prefixTop='t';

			$this->selectNext=false;
			$this->classLleno='lleno';
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
		public function buildOption()
		{
			$args=func_get_args();
			$value=$args[1];

			if($this->selectNext)
			{
				//echo '<pre>Omitida:';print_r($value);echo ' == ';print_r($this->valueToSelect);echo '</pre>';
				$this->selectNext=false;
				$this->defaultIndex=$this->optionsLen;
			}
			//Para omitir esta opción y seleccionar la que le sigue.
			if($this->trySelect($value))
			{
				return false;
			}

			return parent::buildOption($args[0] , $value);
		}

		public function addOption($option)
		{
			//Para cuando se omite una opción.
			if($option===false)
			{
				return $this;
			}

			$option->fill->addToAttribute('class' , $this->classLleno);
			$option->fill->setAttribute('disabled' , 'disabled');

			parent::addOption($option);

			//if($this->options[$this->optionsLen-1]->getValue()==$this->selectedValue )
		}
		public function OnRenderChilds()
		{

			//echo '<pre>FormSelectOrden::renderChilds()</pre>';
			$bottom=new FormSelectOrdenEmptyOption($this->prefixBottom);
			//Revisar
			$bottom->setTagValue
			(
				gettext('Abajo de todo')
			);

			if($this->selectNext)
			{
				$bottom->setSelected();
			}

			parent::addOption
			(
				$bottom
			);

			parent::OnRenderChilds();
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
	class FormSelectOrden extends FormSelect
	{
		public function setSize($size)
		{
			$size=(2*$size)+1;

			if($this->getSizeToMax())
			{
				$size=$size-2;
			}
			return parent::setSize($size);
		}

		public function newController()
		{
			return new FormSelectOrdenController();
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
	}
?>