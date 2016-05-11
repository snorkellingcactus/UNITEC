<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';
	
	class Login extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';

			$action=FormActions::checkActionIn($_POST);

			if($action===false)
			{
				$action=FormActions::checkActionIn($_SESSION);
			}

			$_SESSION['ACTION'.$action]=true;

			$labels=false;
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_NEW
				)
			)
			{
				$session=new FormSession();
				$session->loadLabels( 'Nombre' , 'Contrasena' );

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				global $con;

				//Trato de obtener el usuario.
				$usuario=$con->query
				(
					'	SELECT ID FROM Usuarios
						WHERE NombreUsuario="'.$session->getLabel( 'Nombre' 	).'" 
						AND Contrasena="'.sha1($session->getLabel( 'Contrasena' )).'"'
				);
			
				//Operaciones a realizar si se obtuvo.
				if($con->affected_rows>0)
				{
					//Variable que define el modo administrador.
					$_SESSION['adminID']=fetch_all($usuario , MYSQLI_NUM)[0][0];

					$router->redirect($router->getOriginUrl());
				}
				else
				{
					$router->redirectToStepName
					(
						'15_User_Not_Exists.php'
					);
				}
			}
		}
	}
?>