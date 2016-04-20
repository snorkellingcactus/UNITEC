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
					FormActions::FORM_ACTIONS_EDIT
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCalEdit.php';
				$labels=new SrvFormCalEdit();
				$stepName='30_PasoA_SQLEvts_Edit';

				echo '<pre>Edit</pre>';
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
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCalNew.php';
				$labels=new SrvFormCalNew();

				$stepName='10_PasoA_SQLEvts_New.php';

				echo '<pre>New</pre>';
			}
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';
			//FormActions::FORM_ACTIONS_DELETE:
			$html=new HTMLUForms();
			$html->appendChild
			(
				$body=new DOMBody()
			);
				
			if($labels!==false)
			{
				$labels->enableVolver();
				$labels->setAction
				(
					$router->getStepUrlByName( $stepName )
				);

				while($labels->hasNext()===true)
				{
					if(!$labels->thisIsFirst())
					{
						$labels->appendChild
						(
							new DOMTag
							(
								'hr'
							)
						);
					}

					$labels->appendChild
					(
						$labels->makeLabels()
					);

					$labels->increment();
				}

				$body->appendChild($labels);
			}

			echo $html->getHTML();
		}
	}
?>