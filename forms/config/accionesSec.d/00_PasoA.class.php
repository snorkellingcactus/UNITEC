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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			
			$session=new FormSession();
			$session->loadLabel( 'Tipo' );

			if
			(
				$session->hasLabel( 'Tipo' )
			)
			{
				$tipo=$session->getLabel( 'Tipo' );

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

			$session->save();
		}

		function onDelete()
		{
			parent::onDelete();

			$this->getRouter()->redirectToStepName('90_Elimina.php');
		}


		function onSetRouter()
		{
			$this->setNextStepName
			(
				'50_Duplicated_Shortcut.php'
			);

			parent::onSetRouter();
		}
	}
?>