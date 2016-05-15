<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';

	class SrvForm extends FormBase
	{
		function __construct()
		{
			parent::__construct();

			$this->addToAttribute('class' , 'Form')->addToAttribute('class' ,'tresem');
		}
	}
?>