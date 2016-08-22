
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBodyCommon.php';

	class PasoA extends SrvStepBodyCommon
	{
		function onNew()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';

			$session=new FormSession();

			$session->loadLabels( 'Asunto' , 'Mensaje' , 'Correo');

			$session->save();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormMailConfirm.php';

			$this->setLabels
			(
				new SrvFormMailConfirm()
			);
		}
		function onSetRouter()
		{
			$this->setNextStepName
			(
				'10_Send.php'
			);

			parent::onSetRouter();
		}
	}
?>