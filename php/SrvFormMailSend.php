<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormMailSend extends SrvStepRepeatedForm
	{
		function newLabelsCollection ( &$index )
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMailSend.php';
			
			return new LabelsMailSend( $index );
		}
	}
?>