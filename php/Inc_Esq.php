<?php
include_once("Arr_Gen.php");
class Inc_Esq extends Arr_Gen
{
	function gen($obj)
	{
		return $this->recorre($obj);
	}
	function esq($esq,$inc)
	{
		ob_start();
	
		include ($inc);
		
		$res=ob_get_contents();
	
		ob_end_clean();

		return $res;
	}
	function recorre($obj)
	{

		$prop=$this->props;

		//Si se trata de un objeto genHTML lo genero.
		if(is_object($prop))
		{
			$prop->recorre($obj);
		}

		return $this->esq($obj,$this->getProp($obj,$prop));
	}
}
?>