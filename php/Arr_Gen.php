<?php
class Arr_Gen
{
	public	$props;

	function gen()
	{
		return $this->recorre($this->props);
	}
	public function __construct($props)
	{
		$this->props=$props;
	}
	//Obtengo la propiedad de un array.
	function getProp($obj , $prop)
	{
		return $prop;
	}
}
?>