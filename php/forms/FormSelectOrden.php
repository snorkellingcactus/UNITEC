<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	class FormSelectOrden extends FormSelect
	{
		public $names;
		public $classLleno;
		public $prefixTop;
		public $prefixBottom;

		//FormSelectOrden::__construct($names , $default)
		function __construct()
		{

			parent::__construct();

			$this->names=[];
			$this->namesLen=0;
			$this->prefixBottom='b';
			$this->prefixTop='t';
			$this->classLleno='lleno';

			$args=func_get_args();
			if(isset($args[1]))
			{
				$this->setDefault($args[1]);
			}
			if(isset($args[0]))
			{
				$this->setNames($args[0]);
			}
		}
		public function setNames($names)
		{
			$j=$i=0;
			$iMax=count($names);

			while($i<$iMax)
			{
				$this->names[$j]=$names[$i];

				$j=$j+2;
				++$i;
			}
			$this->namesLen=$i;

			return $this;
		}
		public function setDefault($default)
		{
			$this->default=2*$default;

			return $this;
		}
		public function renderChilds()
		{
			parent::addOption
			(
				$this->buildEmptyOption()->setValue('b')
			);

			return parent::renderChilds();
		}

		public function getNameByIndex($i)
		{
			if(isset($this->names[$i]))
			{
				return $this->names[$i];
			}
			return $i;
		}
		public function getValueByIndex($i)
		{
			return $this->prefixTop.$i;
		}
		public function addOptionBox()
		{
			parent::addOption($this->buildEmptyOption());
			parent::addOption($this->buildFillOption());

			return $this;
		}
		public function buildFillOption()
		{
			$option=new FormOption($this->getNameByIndex($this->optionsLen));

			$option->classList->add($this->classLleno);

			return $option;
		}
		public function buildEmptyOption()
		{
			$option=new FormOption();

			return	$option->setValue
			(
				$this->getValueByIndex($this->optionsLen)
			);
		}
		public function autoAddOptions()
		{
			$iMax=$this->namesLen;
			for($i=0;$i<$iMax;$i++)
			{
				$this->addOptionBox();
			}

			return $this;
		}
	}
?>