<?php
class Foraneas
{
	public $sqlObjA;
	public $sqlObjB;
	public $foraneas;

	public function __construct($sqlObjA , $sqlObjB, $foraneas)
	{
		$this->sqlObjA=$sqlObjA;
		$this->sqlObjB=$sqlObjB;
		$this->foraneas=$foraneas;

		$args=func_get_args();

		if(isset($args[3]))
		{
			$this->opStr($args[3]);
		}
	}

	function opSQL($opStr)
	{
		$this->sqlObjB->$opStr();
		foreach($this->foraneas as $clave=>$valor)
		{
			if($this->sqlObjA->$clave != $this->sqlObjB->$valor)
			{
				$this->sqlObjA->$clave=$this->sqlObjB->$valor;
			}
		}
		
	}
}
?>