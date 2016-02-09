<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUNormal.php';

	class DOMHTMLInicioSesion extends HTMLUNormal
	{
		function __construct()
		{
			parent::__construct();

			//Si se quiere cerrar sesión redirijo.
			if(isset($_GET['cSesion']))
			{
				$_SESSION['adminID']=NULL;	//Modo admin off.
				
				//Redirección.
				header('Location: inicio_sesion.php');
				die();					//Por un motivo desconocido recomiendan el uso de die()

				//NOTA IMPORTANTE: Location en el futuro debe contener una URL
				//absoluta, o en algunos casos no va a ser efectivo además de
				//no cumplir con el procedimiento estándar.
				//http://stackoverflow.com/questions/768431/how-to-make-a-redirect-in-php
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBodyInicioSesion.php';

			$this->head_include
			(
				'/index.css'
			)->head_include
			(
				'/header.css'
			)->head_include
			(
				'/forms/forms.css'
			)->head_include
			(
				'/seccs/inicio_sesion.css'
			)->head_include
			(
				'/js/compactaLabels.js'
			);

			$this->appendChild(new DOMBodyInicioSesion());
		}
	}
?>