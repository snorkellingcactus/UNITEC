<?php
require_once 'Arr_Gen_HTML.php';

class Obj_Gen_HTML extends Arr_Gen_HTML
{
	function gen($obj)
	{
		return $this->recorre($obj);
	}
	//Obtengo la propiedad de un objeto.
	function getProp($obj , $prop)
	{
		return $obj->$prop;
	}
}
?>