<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtArea.php';

	class FormTxtAreaEditor extends FormTxtArea
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->addReq('/ckeditor/ckeditor.js')->addReq('/js/loadEditor.js')->classList->add('ckeditorjs');
		}
	}
?>