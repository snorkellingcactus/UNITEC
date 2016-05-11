<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class SrvStepCommon extends SrvStepBase
	{
		private $labels;
		private $nextStepName;
		private $action;
/*
		function setAction(&$action)
		{
			$this->action=$action;
		}
*/
		function &getAction()
		{
			return $this->action;
		}
		function setLabels($labels)
		{
			$this->labels=$labels;
		}
		function getLabels()
		{
			return $this->labels;
		}
		function setNextStepName( $nextStepName )
		{
			$this->nextStepName=$nextStepName;
		}
		function getNextStepName()
		{
			return $this->nextStepName;
		}
		function buildLabelsTo($body)
		{
			$labels=$this->labels;

			if($labels!==false)
			{
				$labels->enableVolver();

				$nextStepName=$this->getNextStepName();

				if($nextStepName!==false)
				{
					$labels->setAction
					(
						$this->getRouter()->getStepUrlByName( $nextStepName )
					);
				}

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
						$labels->makeLabels($labels->getCount())
					);

					$labels->increment();
				}

				$body->appendChild($labels);
			}
		}
		function onEdit()
		{

		}
		function onNew()
		{
			
		}
		function onDelete()
		{
			
		}

		function onSetRouter()
		{
			$this->labels=false;
			$this->nextStepName=false;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$action=$this->action=FormActions::checkActionIn($_POST);

			if($action===false)
			{
				$action=FormActions::checkActionIn($_SESSION);
			}

			$_SESSION['ACTION'.$action]=true;

			$_SESSION['conID']=FormActions::getContentID();

			if
			(
				FormActions::isFlagSet($action , FormActions::FORM_ACTIONS_DELETE)
			)
			{
				$this->onDelete();
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
				$this->onEdit();
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
				$this->onNew();
			}
		}
	}
?>