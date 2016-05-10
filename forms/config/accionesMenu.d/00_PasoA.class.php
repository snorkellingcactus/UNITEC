<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA extends SrvStepBase
	{	
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$action=FormActions::checkActionIn($_POST);

			if($action===false)
			{
				$action=FormActions::checkActionIn($_SESSION);
			}

			$_SESSION['ACTION'.$action]=true;

			$_SESSION['conID']=FormActions::getContentID();

			$labels=false;

			if
			(
				FormActions::isFlagSet($action , FormActions::FORM_ACTIONS_DELETE)
			)
			{
				$router->redirectToStepName('20_PasoA_SQLEvts_Delete.php');
			}

			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_NEW
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormMenuNew.php';
				$labels=new SrvFormMenuNew();

				$action='10_PasoA_SQLEvts_New.php';

				$operacionStr=gettext( 'Nueva opción de Menú' );
			}
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_EDIT
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormMenuEdit.php';
				$labels=new SrvFormMenuEdit();

				$action='30_PasoA_SQLEvts_Edit.php';

				$operacionStr=gettext( 'Editar opción de Menú' );
			}

			$labels->setAction($router->getStepUrlByName($action));
			$labels->enableVolver();
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';
			//FormActions::FORM_ACTIONS_DELETE:
			$html=new HTMLUForms();
			$html->appendChild
			(
				$body=new DOMBody()
			);

				
			if($labels!==false)
			{
				$body->appendChild
				(
					new DOMTag( 'h1' , $operacionStr )
				)->appendChild($labels);
			}

			echo $html->getHTML();
		}
	}
?>