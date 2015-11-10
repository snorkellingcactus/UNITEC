<?php
	/**
	* 
	*/
	class FormCfg
	{
		public $actions;
		public $selectedAction;
		public $fId;

		function __construct($fId=NULL , $actions=['edita','nuevo','elimina','configura'])
		{
			$this->actions=$actions;
			$this->selectedActio=NULL;
			$this->fId=$fId;
		}

		public function checkActionIn($arr)
		{
			$iMax=count($this->actions);
			$i=0;
			while($i<$iMax && !isset($arr[$this->actions[$i]]))
			{
				++$i;
			}
			if($i===$iMax)
			{
				//$this->selectedAction=NULL;				
			}
			else
			{
				$this->selectedAction=$i;
			}
		}
		public function getAction()
		{
			return $this->selectedAction;
		}
	}
?>