<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';

	mail
	(
		'snorkellingcactus@gmail.com',
		$_POST['Asunto'],
		$_POST['Mensaje']."\nCorreo del consultante: ".$_POST['Correo'],
		'From: garciazavalanadal@gmail.com'
	);

	$this->form->appendChild
	(
		new MSGBox
		(
			gettext('Muchas Gracias. Su consulta fué enviada')
		)
	)->classList->del('nuevo');


	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';
		$volver=new FormVolver($this->form);
		$volver->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ];

		$this->form->setAction($this->getNextStepUrl());
	}
?>