<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';

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
				$router->redirectToStepName('90_Elimina.php');
			}

			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_EDIT	| FormActions::FORM_ITEM_TYPE_A,
					true
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecEdit.php';
				$labels=new SrvFormSecEdit();
				$operacionStr=gettext( 'Editar Sección' );
			}
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_EDIT	| FormActions::FORM_ITEM_TYPE_B,
					true
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecConEdit.php';
				$labels=new SrvFormSecConEdit();
				$operacionStr=gettext( 'Editar Contenido' );
			}
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_EDIT	| FormActions::FORM_ITEM_TYPE_C,
					true
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecIncEdit.php';
				$labels=new SrvFormSecIncEdit();
				$operacionStr=gettext( 'Ajustar Módulo' );
			}
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_NEW	| FormActions::FORM_ITEM_TYPE_A,
					true
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecNew.php';
				$labels=new SrvFormSecNew();
				$operacionStr=gettext( 'Nueva Sección' );
			}
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_NEW
				) &&
				isset
				(
					$_POST['Tipo'][0]
				)
			)
			{
				$tipo=$_POST['Tipo'][0];

				if
				(
					FormActions::isFlagSet
					(
						$tipo,
						FormActions::FORM_ITEM_TYPE_B
					)
				)
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecConNew.php';
					$labels=new SrvFormSecConNew();
					$operacionStr=gettext( 'Insertar Contenido' );
				}

				if
				(
					FormActions::isFlagSet
					(
						$tipo,
						FormActions::FORM_ITEM_TYPE_C
					)
				)
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecIncNew.php';
					$labels=new SrvFormSecIncNew();
					$operacionStr=gettext( 'Insertar Módulo' );
				}

			}
			
			
			$labels->setAction($router->getNextStepUrl());
			$labels->enableVolver();
			
			
			
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