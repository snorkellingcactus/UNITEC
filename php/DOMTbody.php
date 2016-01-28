<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMTbody extends DOMTag
	{
		function __construct()
		{
			parent::__construct('tbody');
		}
	}

?>