<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';

	class For extends FormBase
	{
		private $idSuffix;
		private $srvBuilder;
		private $formName;

		public function __construct($srvBuilder , $formName)
		{
			parent::__construct('form');

			$this->srvBuilder=$srvBuilder;

			$this->setFormName($formName);

			$this->classList->add('Form')->add('tresem');

			$this->setMethod('POST')->setEnctype('multipart/form-data');

			$this->loadFromSession();
		}
		public function getFormName()
		{
			return $this->formName;
		}
		public function setFormName($formName)
		{
			$this->formName=$formName;
		}
		public function setIDSuffix($suffix)
		{
			$this->idSuffix=$suffix;

			return $this;
		}
		public function getIDSuffix()
		{
			return $this->idSuffix;
		}
		
		public function importReqs($domTag)
		{
			$this->addReqs($domTag->getReqs() , $domTag->getReqsLen());

			$domTag->delReqs();

			return $this;
		}
		public function getReqs()
		{

			$iMax=parent::getReqsLen();
			$requiere=parent::getReqs();

			return $requiere;
		}
		public function setField($fieldName , $fieldValue , $fieldCount)
		{
			if(!isset($this->data[$fieldName]))
			{
				$this->data[$fieldName]=array();
			}

			$this->data[$fieldName][$fieldCount]=$fieldValue;
		}
		public function appendLabelBox($labelBox)
		{
			$this->data[$labelBox->input->getName()]='';

			return parent::appendChild($labelBox);
		}
		public function saveToSession()
		{
			$_SESSION[$this->formName]=$this->data;

			return $this;
		}
		public function loadFromSession()
		{
			if(isset($_SESSION[$this->formName]))
			{
				$this->data=$_SESSION[$this->formName];
			}
			else
			{
				echo '<pre>Warning: Trying to load session data from a form "'.$this->formName.'" that does not exists';
				echo '</pre>';
			}

			return $this;
		}
	}
?>

