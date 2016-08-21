<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/procCActions.php';

	class procCStylePreserve implements procCActions
	{
		private $p;
		private $p_len;
		private $preserve;

		function __construct( &$preserve , $p_len )
		{
			$this->p=0;
			$this->preserve=&$preserve;
			$this->p_len=$p_len;
		}
		function noStop()
		{
			return $this->p < $this->p_len;
		}
		function whatToDo( $style , $n_line )
		{
			if( $this->preserve[ $p ] === $n_line )
			{
				//echo '<pre>Preserve line: "'.htmlentities( $style );echo '"</pre>';

				$this->preserve[ $p ] = $style;

				++$this->p;
			}
		}
	}
?>