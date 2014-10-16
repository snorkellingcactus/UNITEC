<?php
//Discrimina la clave de un array dependiendo de si es o no un numero, derivando a 
//fnA($clave , $valor) si es string o fnB($clave , $valor) si es número.
function eachNan($asoc , $fnA , $fnB)
{
	foreach($asoc as $clave=>$valor)
	{
		if(is_numeric($clave))
		{
			$fnB($clave , $valor);
		}
		else
		{
			$fnA($clave , $valor);
		}
	}
}
class SQLObj
{
	private $con;

	private $table;
	private $props;
	private $buff;
	private $buffAux;

	public $ID;

	public function __construct($con , $table , $props)
	{
		$this->con=$con;
		$this->table=$table;
		$this->props=$props;
		
		$this->getAsoc($props);
	}
	public function getAsoc($arr)
	{
		eachNan
		(
			$arr,
			function($clave , $valor)
			{
				$this->conFnA($clave , $valor);
			},
			function($clave , $valor)
			{
				$this->conFnB($clave , $valor);
			}
		);
	}
	//Si es numero devuelve el numero, sino, devuelve el valor con las comillas ("") agregadas.
	public function sqlVal($val)
	{
		if(is_numeric($val))
		{
			return $val;
		}
		return '"'.$val.'"';
	}
	public function conFnA($clave , $valor)
	{
		$this->$clave=$valor;
	}
	public function conFnB($clave , $valor)
	{
		$this->$valor=NULL;
	}
	private function updFnA($clave , $valor)
	{
		$this->buff=$this->buff.$clave.'=';
		$this->buff=$this->buff.$this->sqlVal($valor).',';
	}
	private function updFnB($clave , $valor)
	{
		$this->buff=$this->buff.$valor.'=';
		$this->buff=$this->buff.$this->sqlVal($this->$valor).',';
	}
	private function insFnA($clave , $valor)
	{
		$this->buff=$this->buff.$clave.' , ';
		$this->buffAux=$this->buffAux.$this->sqlVal($valor).' ,';
	}
	private function insFnB($clave , $valor)
	{
		if(isset($this->$valor))
		{
			$this->buff=$this->buff.$valor.' ,';
			$this->buffAux=$this->buffAux.$this->sqlVal($this->$valor).' ,';
		}
	}
	
	//Actualiza los campos de un registro de este elemento en la base de datos.
	public function updSQL($prop)
	{
		if(!isset($this->ID))
		{
			return 0;
		}
		if(is_array($prop))
		{
			$this->buff='update '.$this->table.' set ';	//Sentencias SQL para actualizar filas de una tabla.

			eachNan
			(
				$prop,
				function($clave , $valor){$this->updFnA($clave , $valor);},
				function($clave , $valor){$this->updFnB($clave , $valor);}
			);

			//Saco comas finales, cierro parentesis y agrego espacio.
			$this->buff=substr($this->buff,0,strlen($this->buff)-1).' where ID='.$this->ID;
			
			$res=$this->con->query($buff);

			$buff='';

			return $res;
		}
		if(isset($this->$prop))
		{
			return $this->con->query
			(
				'update '.$this->table.' set '.$prop.' = '.$this->sqlVal($this->$prop).' where ID='.$this->ID
			);
		}
	}

	//Crea un nuevo registro de este elemento en la base de datos.
	public function insSQL()
	{
		$this->buff=$this->buff.'insert into '.$this->table.' ( ';
		$this->buffAux=$this->buffAux.' values( ';

		eachNan
		(
			$this->props,
			function($clave , $valor){$this->insFnA($clave , $valor);},
			function($clave , $valor){$this->insFnB($clave , $valor);}
		);

		$this->buff=substr($this->buff,0,strlen($this->buff)-1).' ) ';
		$this->buffAux=substr($this->buffAux,0,strlen($this->buffAux)-1).' ) ';

		$res=$this->con->query($this->buff.$this->buffAux);

		$this->buff='';
		$this->buffAux='';

		return $res;
	}
}
?>