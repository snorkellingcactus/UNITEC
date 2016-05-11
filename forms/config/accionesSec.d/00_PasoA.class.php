<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBodyCommon.php';

	class PasoA extends SrvStepBodyCommon
	{
		function onEdit()
		{
			parent::onEdit();
			$action=$this->getAction();

			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ITEM_TYPE_A
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecEdit.php';
				
				$this->setLabels
				(
					new SrvFormSecEdit()
				);

				//$operacionStr=gettext( 'Editar Sección' );
			}
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ITEM_TYPE_B
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecConEdit.php';

				$this->setLabels
				(
					new SrvFormSecConEdit()
				);

				//$operacionStr=gettext( 'Editar Contenido' );
			}
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ITEM_TYPE_C
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecIncEdit.php';
				$this->setLabels
				(
					new SrvFormSecIncEdit()
				);
				
				//$operacionStr=gettext( 'Ajustar Módulo' );
			}
		}

		function onNew()
		{
			parent::onNew();
			$action=$this->getAction();

			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ITEM_TYPE_A
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecNew.php';

				$this->setLabels
				(
					new SrvFormSecNew()
				);

				//$operacionStr=gettext( 'Nueva Sección' );
			}
			if
			(
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

					$this->setLabels
					(
						new SrvFormSecConNew()
					);

					//$operacionStr=gettext( 'Insertar Contenido' );
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
					
					$this->setLabels
					(
						new SrvFormSecIncNew()
					);

					//$operacionStr=gettext( 'Insertar Módulo' );
				}

			}
		}

		function onDelete()
		{
			parent::onDelete();

			$this->getRouter()->redirectToStepName('90_Elimina.php');
		}


		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);	
			
			$this->setNextStepName
			(
				$this->getRouter()->getNextStepUrl()
			);
		}
	}
?>