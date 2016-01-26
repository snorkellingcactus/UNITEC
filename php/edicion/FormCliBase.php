<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliButtons.php';

	class FormCliBase extends DOMTag
	{
		public $raiz;
		public $actionUrl;
		public $idSuffix;
		public $buttons;
		public $formDirName;
		
		function __construct($formDirName)
		{
			parent::__construct('form');

			$this->raiz='http://'. $_SERVER['SERVER_NAME'].'/';
			$this->actionUrl=$this->raiz . 'php/accion.php';
			$this->idSuffix='';
			$this->formDirName=$formDirName;

			$this->varForm=new VariablePost($this , 'form' , $formDirName);
			$this->varLab=new VariablePost($this , 'lab' , $_SESSION['lab']);

			
		}
		function renderChilds(&$doc , &$tag)
		{
			$this->appendChild
			(
				$this->varForm->setMulti(0)
			)->appendChild
			(
				$this->varLab->setMulti(0)
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