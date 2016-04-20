<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

	class DOMBodyInicioSesion extends DOMBody
	{	
		function renderChilds(&$tag)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Script.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHeaderInicioSesion.php';

			$this->appendChild(new DOMHeaderInicioSesion());

			if(isset($_SESSION['adminID']))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';
				//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_DOM.php';

				global $con;

				$usuario=fetch_all
				(
					$con->query
					(
						'	SELECT * FROM Usuarios
							WHERE ID='.$_SESSION['adminID']
					),
					MYSQLI_ASSOC
				)[0];

				$logueado=new MSGBox
				(
					gettext('Estas logueado!')
				);
				$cSesion=new DOMLink();

				$logueado->addToAttribute('class' , 'MSGLogin');

				$this->appendChild
				(
					$logueado->appendChild
					(
						$cSesion->setUrl('/inicio_sesion.php?cSesion')->setName('Cerrar Sesión')
					)
				);
			}
			else
			{
				include $_SERVER['DOCUMENT_ROOT'] . '/php/LoginBox.php';		//Formulario login.

				$this->appendChild(new LoginBox());
			}

			$this->appendChild
			(
				new Script('/js/login.js')
			);

			return parent::renderChilds($tag);
		}
	}
?>