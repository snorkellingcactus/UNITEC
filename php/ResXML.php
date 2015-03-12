<?
class ResXML
{
	function ini()
	{
		header('Content-Type','text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
	}

	function param($clave , $valor)
	{
		echo '<'.$clave.'>'.$valor.'<'.$clave.'>';
	}
	function fin()
	{
		exit;
	}
}

?>