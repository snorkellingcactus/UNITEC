<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagObjectBase.php';
	
	class DOMInitialTag extends DOMTagObjectBase
	{
		function __construct()
		{
			parent::__construct();

			$this->tag=new DOMDocument('1.0' , 'UTF-8');
		}
	}
?>