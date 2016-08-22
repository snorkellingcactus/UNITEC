<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormMailConfirm extends SrvStepRepeatedForm
	{
		function newLabelsCollection ( &$index )
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMailConfirm.php';
			
			return new LabelsMailConfirm( $index );
		}
	}
?>