<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class FormBase extends DOMTag
	{
		private $requiere;
		private $requiereLen;

		public function __construct()
		{
			parent::__construct();

			$this->delReqs();

			$args=func_get_args();
			if(isset($args[0]))
			{
				$this->setTagName($args[0]);
			}
		}
		private function addReqOpt($req , &$thisReq , &$thisReqLen)
		{
			if(!array_key_exists($req , $thisReq))
			{
				$thisReq[$thisReqLen]=$req;
				++$thisReqLen;
			}

			return $this;
		}
		public function addReq($req)
		{
			$thisReqs=& $this->requiere;
			$thisReqsLen=& $this->requiereLen;

			return $this->addReqOpt($req , $thisReqs , $thisReqsLen);
		}
		public function addReqs($reqs , $reqsLen)
		{
			$thisReqs=& $this->requiere;
			$thisReqsLen=& $this->requiereLen;

			for($i=0;$i<$reqsLen;$i++)
			{
				$this->addReqOpt($reqs[$i] , $thisReqs , $thisReqsLen);
			}

			return $this;
		}
		public function getReqsLen()
		{
			return $this->requiereLen;
		}
		public function getReqs()
		{
			return $this->requiere;
		}
		public function delReqs()
		{
			$this->requiere=[];
			$this->requiereLen=0;

			return $this;
		}
	}
?>