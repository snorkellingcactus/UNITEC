<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';

	class Form extends FormBase
	{
		public $idSuffix;
		public $srvBuilder;

		public function __construct($srvBuilder)
		{
			parent::__construct('form');

			$this->classList->add('Form')->add('tresem');

			$this->srvBuilder=$srvBuilder;
			$this->setMethod('POST')->setEnctype('multipart/form-data');
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
		public function setEnctype($enctype)
		{
			return $this->setAttribute('enctype' , $enctype);
		}
		public function setMethod($method)
		{
			return $this->setAttribute('method' , $method);
		}
		public function setAction($action)
		{
			return $this->setAttribute('action' , $action);
		}
		public function importReqs($domTag)
		{
			$this->addReqs($domTag->getReqs() , $domTag->getReqsLen());

			$domTag->delReqs();

			return $this;
		}
		public function getReqs()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/head_include.php';

			$iMax=parent::getReqsLen();
			$requiere=parent::getReqs();

			for($i=0;$i<$iMax;$i++)
			{
				head_include($requiere[$i]);
			}

			return $this;
		}
		public function clearFix()
		{
			$clearFix=new DOMTag('div');
			$clearFix->classList->add('clearfix');

			return $this->appendChild($clearFix);
		}
	}
?>

