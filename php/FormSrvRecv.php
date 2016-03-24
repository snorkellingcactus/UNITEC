<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCfg.php';
	
	class FormSrvRec extends FormCfg
	{
		public $referer;

		function __construct($fId=NULL)
		{
			parent::__construct($fId);

			
		}
		
	}
?>