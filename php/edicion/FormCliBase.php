<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';

	class FormCliBase extends FormBase
	{
		public $raiz;
		public $buttons;
		public $formDirName;
		
		function __construct($formDirName)
		{
			parent::__construct();

			$this->raiz='http://'. $_SERVER['SERVER_NAME'].'/';
			$this->setAction( $this->raiz . 'php/accion.php' );
			$this->formDirName=$formDirName;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

			$this->varForm=new VariablePost('form' , $formDirName);
			$this->varLab=new VariablePost('lab' , $_SESSION['lab']);

			
		}
		function renderChilds(&$tag)
		{
			$this->appendChild
			(
				$this->varForm
			)->appendChild
			(
				$this->varLab
			);

			return parent::renderChilds($tag);
		}
	}
?>