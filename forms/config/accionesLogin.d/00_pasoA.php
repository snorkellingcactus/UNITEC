<?php
	if(isset($_POST['Contrasena'])&&isset($_POST['Nombre']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;
		//Trato de obtener el usuario.
		$usuario=$con->query
		(
			'	SELECT ID FROM Usuarios
				WHERE NombreUsuario="'.$_POST['Nombre'].'" 
				AND Contrasena="'.sha1($_POST['Contrasena']).'"'
		);
	
		//Operaciones a realizar si se obtuvo.
		if($con->affected_rows>0)
		{
			//Variable que define el modo administrador.
			$_SESSION['adminID']=fetch_all($usuario , MYSQLI_NUM)[0][0];

			$this->redirect($this->getOriginUrl());
		}
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

	$this->form->appendChild
	(
		new MSGBox
		(
			gettext('El usuario no existe!')
		)
	);

	
	$volver=new FormVolver($this->form);
	$volver->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ];

	$this->form->setAction($this->getNextStepUrl());

	$this->form->appendChild($volver);
?>