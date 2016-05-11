
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBodyCommon.php';

	class PasoA extends SrvStepBodyCommon
	{
		private $session;

		function onNew()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';

			$session=new FormSession();

			$session->loadLabels( 'Asunto' , 'Mensaje' , 'Correo');

			//Revisar. Hacer configurable el mail.
			mail
			(
				'snorkellingcactus@gmail.com'		,
				$session->getLabel( 'Asunto'	)	,
				$session->getLabel( 'Mensaje'	)	.'
				Correo del consultante: '			.
				$session->getLabel( 'Correo' )		,
				'From: garciazavalanadal@gmail.com'
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormMailSend.php';

			$this->setLabels
			(
				new SrvFormMailSend()
			);
		}
	}
?>