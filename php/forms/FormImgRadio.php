<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMGalImg.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/Indexable.php';

	//Revisar . implements FormRadio
	
	class FormImgRadio extends DOMGalImg implements Indexable
	{
		public $input;

		function __construct($name , $value)
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadio.php';
			$this->p->appendChild
			(
				$this->input=new FormRadio($name , $value)
			);

			$this->addToAttribute('role' , 'radio');
		}
		function setSelected()
		{
			return $this->input->setSelected();
		}
		function getValue()
		{
			return $this->input->getValue();
		}
		function setIndex(&$index)
		{
			$this->input->setIndex($index);
		}
	}
?>