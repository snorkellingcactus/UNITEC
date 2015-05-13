<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Arr_Gen.php';

function file_include_contents($ruta)
{
	$args=func_get_args();

	if(isset($args[1]))
	{
		$esq=$args[1];
	}

	ob_start();
	
	include $ruta;
	
	$res=ob_get_contents();

	ob_end_clean();

	return $res;
}
class Inc_Esq extends Arr_Gen
{
	function gen($obj)
	{
		return $this->recorre($obj);
	}
	function esq($esq,$inc)
	{
		file_include_contents($inc);
	}
	function recorre($obj)
	{

		$prop=$this->props;

		//Si se trata de un objeto genHTML lo genero.
		if(is_object($prop))
		{
			$prop->recorre($obj);
		}

		return file_include_contents($this->getProp($obj,$prop),$obj);
	}
}
?>