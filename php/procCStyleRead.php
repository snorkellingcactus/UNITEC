<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/procCActions.php';

	class procCStyleRead implements procCActions
	{
		private $l;
		private $lines;

		function __construct()
		{
			$this->l=0;
			$this->lines=array();
		}
		function noStop()
		{
			return true;
		}
		function whatToDo( $style , $n_line )
		{
			$this->lines[ $this->l ] = $style;
			++$this->l;
		}
		function getLinesArray()
		{
			return $this->lines;
		}
	}
?>