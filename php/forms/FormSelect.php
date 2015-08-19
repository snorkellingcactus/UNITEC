<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormOption.php';
	class FormSelect extends FormInputBase
	{
		public $options;
		public $optionsLen;
		public $default;
		public $defaultToMax;
		public $sizeToMax;

		function __construct()
		{
			parent::__construct('select');

			$this->options=[];
			$this->optionsLen=0;
			$this->default=0;
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
			if($this->defaultToMax)
			{
				$this->options[$this->optionsLen-1]->setSelected();
			}
			if($this->sizeToMax)
			{
				$this->tag->setAttribute('size' , $this->optionsLen);
			}

			return parent::renderChilds();
		}
		function addOption(FormOption $option)
		{
			if($this->defaultToMax!==true && $this->optionsLen===$this->default)
			{
				$option->setSelected();
			}

			$this->options[$this->optionsLen]=$option;
			++$this->optionsLen;

			$this->appendChild($option);

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