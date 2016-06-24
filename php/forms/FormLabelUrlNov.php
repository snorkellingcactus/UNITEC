<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBoxMultiple.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelArchivo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrl.php';
	
	//Cambiar clase por algo compatible con LabelBox.
	class FormLabelUrlNov extends FormLabelBoxMultiple
	{
		public $inputUrl;
		public $inputFile;

		function __construct()
		{
			parent::__construct();

			$this->setLabelName
			(
				gettext('Url o Archivo')
			);
			$this->label->setID('file');

			$this->appendLBox
			(
				$this->inputFile=new FormLabelArchivo()
			)->appendLBox
			(
				$this->inputUrl=new FormLabelUrl()
			);

			$this->inputFile->col=$this->inputUrl->col=
			[
				'xs'=>6,
				'sm'=>6,
				'md'=>6,
				'lg'=>6
			];

			$this->inputUrl->input->setName( 'FileUrl' );
			$this->inputFile->input->setName( 'FileArchivo' );
		}
		function appendLBox($lBox)
		{
			$this->appendChild($lBox);

			return parent::appendLBox($lBox);
		}
	}
?>