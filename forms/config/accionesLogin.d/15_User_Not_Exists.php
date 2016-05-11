<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class User_Not_Exists extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepFormBase.php';

			$html=new HTMLUForms();

			$html->appendChild
			(
				$body=new DOMBody()
			);

			$body->appendChild
			(
				new MSGBox
				(
					gettext('Ups!. El usuario no existe!')
				)
			)->appendChild
			(
				$volver=new SrvStepFormBase()
			);
			
			$volver->setAction
			(
				$router->getOriginUrl()
			);


			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

			echo $html->getHTML();
		}
	}
?>