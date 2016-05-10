<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecBase.php';

	class LabelsSecOther extends LabelsSecBase
	{
		public function setParentID($parentID)
		{
			$this->setParentStr('='.$parentID);
		}
			
		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

			$this->setParentID($this->getContentID());
/*
			$this->appendChild
			(
				new VariablePost('conID' , $this->contentID)
			);
*/
		}
	}
?>