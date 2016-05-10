<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadioLst.php';

	class RadioLstNov extends FormImgRadioLst
	{
		function __construct()
		{
			parent::__construct( 'div' );

			//$this->addToAttribute( 'class' , 'FormImgRadioLst' );
			$this->addToAttribute('class' , 'FormLabelImagen');
		}
	}
?>