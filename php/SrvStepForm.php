<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepFormBase.php';
	

	class SrvStepForm extends SrvStepFormBase
	{
		function __construct()
		{
			parent::__construct();

			$this->makeLabels();
		}
		function makeLabels()
		{
			$index=0;

			$this->appendChild
			(
				$labels=parent::makeLabels($index)
			);
		}
	}
?>

