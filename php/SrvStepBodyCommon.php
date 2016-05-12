<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepCommon.php';

	class SrvStepBodyCommon extends SrvStepCommon
	{
		private $labels;
		private $html;
		
		function getHTML()
		{
			return $this->html;
		}
		function setLabels($labels)
		{
			$this->labels=$labels;
		}
		function getLabels()
		{
			return $this->labels;
		}
		function setRouter(SrvStepRouter &$router)
		{
			$this->setLabels		( false );
			$this->setNextStepUrl	( false );
			
			parent::setRouter($router);
		}
		function buildLabelsTo($body)
		{
			$labels=$this->labels;

			if($labels!==false)
			{
				$labels->enableVolver();

				$nextStepUrl=$this->getNextStepUrl();

				if($nextStepUrl !== false)
				{
					$labels->setAction
					(
						$nextStepUrl
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