<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	class DOMTagContainer extends DOMTag
	{
		public $hermanos;
		public $hermanosLen;

		function __construct()
		{
			parent::__construct();

			$this->hermanos=[];
			$this->hermanosLen=0;
		}
		function appendTag(DOMTag $domTag)
		{
			if($domTag instanceof DOMTagContainer)
			{
				$iMax=$domTag->hermanosLen;
				for($i=0;$i<$iMax;$i++)
				{
					$this->appendTag($domTag->hermanos[$i]);
				}
			}
			else
			{
				$this->hermanos[$this->hermanosLen]=& $domTag;

				++$this->hermanosLen;
			}
			return $this;
		}
		function renderChilds()
		{
			return $this->render($this->hermanos , $this->hermanosLen , $this->domDoc);
		}
	}
?>