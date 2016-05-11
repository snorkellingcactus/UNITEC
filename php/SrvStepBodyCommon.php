<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepCommon.php';

	class SrvStepBodyCommon extends SrvStepCommon
	{
		private $html;
		
		function getHTML()
		{
			return $this->html;
		}

		function onSetRouter()
		{
			parent::onSetRouter();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';	
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

			//FormActions::FORM_ACTIONS_DELETE:
			$this->html=new HTMLUForms();
			$this->html->appendChild
			(
				$body=new DOMBody()
			);
				
			$this->buildLabelsTo($body);

			echo $this->html->getHTML();
		}
	}
?>