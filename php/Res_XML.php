<?php
class Res_XML
{
	function ini()
	{
		header('Content-Type:text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
		echo '<response>';
	}

	function param($clave , $valor)
	{
		echo '<'.$clave.'>'.$valor.'</'.$clave.'>';
	}
	function fin()
	{
		echo '</response>';
		exit;
	}
}

?>