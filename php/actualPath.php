<?php
	function actualPath()
	{	
		return str_replace('/opt/lampp/htdocs', 'http://'.$_SERVER['SERVER_NAME'] , $_SERVER['SCRIPT_FILENAME']);
	}
	function actualDir()
	{
		return pathinfo(actualPath())['dirname'];
	}
?>