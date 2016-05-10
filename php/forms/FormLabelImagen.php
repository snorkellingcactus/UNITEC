<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBoxMultiple.php';

	class FormLabelImagen extends FormLabelBoxMultiple
	{
		public $controller;

		function __construct( $names , $id , $labelText )
		{
			//Revisar . Pasar directamente o por call_user_func_array() ?
			parent::__construct();

			$this->setLabelName($labelText);
			$this->label->setID($id);

//			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/RadioLstNov.php';


			$this->controller=$this->newController()->setView($this)->setRadioNames($names);

			$this->addToAttribute('role' , 'radiogroup');

			//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

			//$this->label->setTagValue($labelText);
			//$this->label->setAttribute('id' , $id);

			//$this->appendChild( new ClearFix() );
		}
		function renderChilds(&$tag)
		{
			$this->controller->onRenderChilds();

			return parent::renderChilds($tag);
		}
		function newController()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadioLstController.php';

			return new FormImgRadioLstController();
		}
		function appendChild($child)
		{
			if($child instanceof FormImgRadio)
			{
				$this->appendLBox($child);
			}

			return parent::appendChild($child);
		}
	}
?>