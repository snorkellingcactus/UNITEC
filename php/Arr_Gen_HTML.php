<?php
class NULL_Gen_HTML
{
	public function recorre($obj)
	{
		return '';
	}
}
class Arr_Gen_HTML
{
	private $numVars;
	private	$props;

	function __construct($estructura,$props)
	{
		$this->estructura=$estructura;
		$this->props=$props;

		$this->numVars=count($estructura)-1;
	}
	function gen()
	{
		return $this->recorre($this->props);
	}
	function recorre($obj)
	{

		$buff='';

		$iMax=$this->numVars;

		for($i=0;$i<$iMax;$i++)
		{
			$prop=$this->props[$i];

			//Si se trata de un objeto genHTML lo genero.
			if(is_object($prop))
			{
				$buff=$buff.$this->estructura[$i].$prop->recorre($obj);
				continue;
			}
		
			$buff=$buff.$this->estructura[$i].$this->getProp($obj,$prop);
		}
		return $buff.$this->estructura[$iMax];
	}
	//Obtengo la propiedad de un array.
	function getProp($obj , $prop)
	{
		return $prop;
	}
}
?>