<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';

	class FormLabelBase extends FormMultipleElement
	{
		function __construct()
		{
			parent::__construct( 'label' );
		}
	}

	class FormLabel extends FormLabelBase
	{
		public $input;

		public function setInput($input)
		{
			$this->input=$input;

			$this->setIndex( $this->input->getIndex() );
		}

		function renderChilds(&$tag)
		{
			$this->setAttribute
			(
				'for' , 
				$this->input->getIDReference()->getFormatted()
			);

			$this->input->addReferenceToAttr
			(
				'aria-labelledby' ,
				$this->getIDReference()->getFormatted()
			);

			return parent::renderChilds($tag);
		}
		/*
		function setID()
		{
			echo '<pre>';
			echo debug_print_backtrace();
			echo '</pre>';
		}*/
	}
?>