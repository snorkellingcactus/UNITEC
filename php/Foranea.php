<?php
class Foranea
{
	public $sqlObjA;
	public $sqlObjB;

	public $colObjA;
	public $colObjB;

	public function __construct($sqlObjA , $sqlObjB , $colANom , $colBNom)
	{
		$this->sqlObjA=$sqlObjA;
		$this->sqlObjB=$sqlObjB;
		$this->colANom=$colANom;
		$this->colBNom=$colBNom;

		$args=func_get_args();

		if(isset($args[4]))
		{
			$this->opSQL($args[4]);
		}
	}

	function opSQL($opStr)
	{
		$this->sqlObjB->$opStr();
		$colANom=$this->colANom;
		$colBNom=$this->colBNom;

		if($this->sqlObjA->$colANom != $this->sqlObjB->$colBNom)
		{
			$this->sqlObjA->$colANom=$this->sqlObjB->$colBNom;
		}
	}
}
?>