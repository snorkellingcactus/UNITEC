<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Arr_Gen.php';

class Arr_Gen_HTML extends Arr_Gen
{
	private $numVars;
	private $estructura;

	function __construct($estructura,$props)
	{
		parent::__construct($props);

		$this->estructura=$estructura;
		$this->numVars=count($estructura)-1;
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
}
?>