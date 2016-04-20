<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/SrvStep.php';

	class SrvStepBase implements SrvStep
	{
		private $router;
		
		function setRouter(SrvStepRouter &$router)
		{
			$this->router=$router;
		}
	}
?>