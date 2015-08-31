<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadio.php';

	class FormImgRadio extends DOMTag
	{
		public $img;
		public $input;

		function __construct($parentForm , $name , $value)
		{
			parent::__construct('div');
			$this->img=false;
			$this->input=new FormRadio($parentForm , $name , $value);

			$this->appendChild($this->input);
		}
		function setImgSrc($imgSrc)
		{
			if(!$this->img)
			{
				$this->img=new DOMTag('img');
				$this->appendChild($this->img);
			}

			$this->img->setAttribute('src' , $imgSrc);

			return $this;
		}
		function setSelected()
		{
			return $this->input->setSelected();
		}
		function getValue()
		{
			return $this->input->getValue();
		}
	}
?>