<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';
	
	//Cambiar clase por algo compatible con LabelBox.
	class FormLabelUrlNov extends LabelBox
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				'Url',
				'url',
				gettext('Url o Archivo'),
				new FormInput($parentForm , 'text')
			);

			$this->inputUrl=$this->input;

			$this->setInput
			(
				new FormInput($parentForm , 'file')
			);

			$this->inputFile=$this->input;

			$this->inputFile->col=
			[
				'xs'=>6,
				'sm'=>6,
				'md'=>6,
				'lg'=>6
			];

			$this->inputUrl->col=
			[
				'xs'=>6,
				'sm'=>6,
				'md'=>6,
				'lg'=>6
			];

			$this->inputFile->setName('File')->setID('file');
		}
		function setLabelName($name)
		{
			$this->label->setTagValue($name);
		}
	}
?>