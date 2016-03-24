<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliButtons.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';

	class FormCliBase extends FormBase
	{
		public $raiz;
		public $actionUrl;
		public $buttons;
		public $formDirName;
		
		function __construct($formDirName)
		{
			parent::__construct('form');

			$this->raiz='http://'. $_SERVER['SERVER_NAME'].'/';
			$this->actionUrl=$this->raiz . 'php/accion.php';
			$this->formDirName=$formDirName;

			$this->varForm=new VariablePost('form' , $formDirName);
			$this->varLab=new VariablePost('lab' , $_SESSION['lab']);

			
		}
		function renderChilds(&$doc , &$tag)
		{
			$this->appendChild
			(
				$this->varForm
			)->appendChild
			(
				$this->varLab
			)->setAttribute
			(
				'method',
				'POST'
			)->setAttribute
			(
				'action',
				$this->actionUrl
			);

			return parent::renderChilds($doc , $tag);
		}
	}
?>