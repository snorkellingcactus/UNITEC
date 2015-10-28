<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliButtons.php';

	class FormCliAdmBase extends DOMTag
	{
		public $raiz;
		public $actionUrl;
		public $idSuffix;
		public $buttons;
		public $formDirName;
		
		function __construct($formDirName)
		{
			parent::__construct('form');

			$this->buttons=new FormCliButtons();

			$this->raiz='http://'. $_SERVER['SERVER_NAME'].'/';
			$this->actionUrl=$this->raiz . 'php/accion.php';
			$this->idSuffix='';
			$this->formDirName=$formDirName;

			$varForm=new VariablePost($this , 'form' , $formDirName);

			$this->appendChild($this->buttons)->appendChild
			(
				$varForm->setMulti(0)
			)->setAttribute
			(
				'method',
				'POST'
			)->setAttribute
			(
				'action',
				$this->actionUrl
			);
		}
	}
?>