<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

	class DOMBodyInicioSesion extends DOMBody
	{	
		function renderChilds(&$tag)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Script.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHeaderInicioSesion.php';

			$this->appendChild(new DOMHeaderInicioSesion());

			if( isset( $_SESSION['adminID'] ) )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/PanelAdmin.php';

				$this->appendChild
				(
					new PanelAdmin()
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