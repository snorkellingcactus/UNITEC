<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';
	
	//Cambiar clase por algo compatible con LabelBox.
	class FormLabelUrlNov extends DOMTagContainer
	{
		function __construct($parentForm)
		{
			parent::__construct();

			$this->label=new FormLabel();
			
			$this->inputFile=new FormInput($parentForm , 'file');
			$this->inputUrl=new FormInput($parentForm , 'text');

			$this->inputFile->col=
			[
				'xs'=>2,
				'sm'=>2,
				'md'=>2,
				'lg'=>2
			];

			$this->inputUrl->col=
			[
				'xs'=>5,
				'sm'=>5,
				'md'=>5,
				'lg'=>5
			];
			$this->label->col=
			[
				'xs'=>5,
				'sm'=>5,
				'md'=>5,
				'lg'=>5
			];

			$this->setLabelName('Url o Archivo');
			$this->inputFile->setName('Archivo')->setID('archivo');
			$this->inputUrl->setName('Url')->setID('url')->appendLabel($this->label);

			$this->appendChild($this->label)
			->appendChild($this->inputUrl)
			->appendChild($this->inputFile);
		}
		function setLabelName($name)
		{
			$this->label->setTagValue($name);
		}
	}
?>