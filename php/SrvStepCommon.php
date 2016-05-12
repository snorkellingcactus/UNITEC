<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class SrvStepCommon extends SrvStepBase
	{
		private $nextStepUrl;
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
		function setNextStepName($stepName)
		{			
			$this->setNextStepUrl
			(
				$this->getRouter()->getStepUrlByName($stepName)
			);
		}
		function setNextStepUrl( $nextStepUrl )
		{
			$this->nextStepUrl=$nextStepUrl;
		}
		function getNextStepUrl()
		{
			return $this->nextStepUrl;
		}
		//Usar una interface.
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
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$action=$this->action=FormActions::checkActionIn($_POST);

			if($action===false)
			{
				$action=$this->action=FormActions::checkActionIn($_SESSION);
			}

			//Revisar
			if($action===false)
			{
				$action=FormActions::checkActionIn($_GET);
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