<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMTagLst extends DOMTag
	{
		function __construct()
		{
			parent::__construct('div');

			$this->addToAttribute('class' , 'tagList');
		}
		function buildFromTagsNames($tagsNames)
		{
			$t=0;

			while(isset($tagsNames[$t]))
			{
				$this->appendChild
				(
					new DOMTag('span' , $tagsNames[$t])
				);

				++$t;
			}
		}
	}
?>