<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Requirer.php';

	class FormBase extends Requirer
	{
		public function __construct()
		{
			parent::__construct('form');

			$this->setMethod('POST')->setEnctype('multipart/form-data');
		}
		public function setEnctype($enctype)
		{
			return $this->setAttribute('enctype' , $enctype);
		}
		public function setMethod($method)
		{
			return $this->setAttribute('method' , $method);
		}
		public function setAction($action)
		{
			return $this->setAttribute('action' , $action);
		}
	}
?>