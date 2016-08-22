
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBodyCommon.php';

	class Send extends SrvStepBodyCommon
	{
		function onSetRouter()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';

			$session=new FormSession();

			$session->loadLabels( 'Asunto' , 'Mensaje' , 'Correo');

			$session->save();

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

			$this->setNextStepUrl
			(
				$this->getRouter()->getOriginUrl()
			);

			parent::onSetRouter();
		}
	}
?>