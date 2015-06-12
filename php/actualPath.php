<?php
	function actualPath()
	{	
		return str_replace('/opt/lampp/htdocs', 'http://localhost' , $_SERVER['SCRIPT_FILENAME']);
	}
	function actualDir()
	{
		return pathinfo(actualPath())['dirname'];
	}
?>