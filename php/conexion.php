<?php
class Conexion
{
	public $con;
	public $server;
	public $name;
	public $passwd;
	public $db;

	public function __construct($server , $name , $passwd , $db)
	{
		$this->server=$server;
		$this->name=$name;
		$this->passwd=$passwd;
		$this->db=$db;
	}
	//Establece una coneccion a la base de datos.
	public function open()
	{
		$this->con=mysqli_connect
		(
			$this->server,
			$this->name,
			$this->passwd
		);
		$this->selDB();
	}
	public function selDB()
	{
		$db=$this->db;
		$args=func_get_args();

		if(isset($args[0]))
		{
			$db=$args[0];	
		}
		mysqli_select_db($this->con , $db);
		
	}
	//Cierra una coneccion con la base de datos.
	public function close()
	{
		$this->con=mysqli_close($this->con);
	}
	//Realiza una consulta a la base de datos.
	public function sql($consulta)
	{
		$this->open();
		$this->selDB($this->db);

		$res=mysqli_query($this->con,$consulta);

		$this->close();

		return $res;
	}
}
class SQLObj
{
	public $con;
	public $table;
	public $props;
	public $buff;
	private $buffAux;

	public $ID;

	public function __construct($con , $table , $props)
	{
		$this->con=$con;
		$this->table=$table;
		$this->props=$props;

		$this->eachNan
		(
			$props,
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
	//Discrimina la clave de un array dependiendo de si es o no un numero, derivando a distintas funciones en cada caso.
	private function eachNan($prop , $fnA , $fnB)
	{
		foreach($prop as $clave=>$valor)
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
		if(!$this->ID)
		{
			return 0;
		}
		if(is_array($prop))
		{
			$this->buff='update table '.$this->table.' set ';	//Sentencias SQL para actualizar filas de una tabla.

			$this->eachNan
			(
				$prop,
				function($clave , $valor){$this->updFnA($clave , $valor);},
				function($clave , $valor){$this->updFnB($clave , $valor);}
			);

			//Saco comas finales, cierro parentesis y agrego espacio.
			$this->buff=substr($this->buff,0,strlen($this->buff)-1).' where ID='.$this->ID;
			
			$res=$this->con->sql($buff);

			$buff='';

			return $res;
		}
		if(isset($this->$prop))
		{
			return $this->con->sql
			(
				'update table '.$this->table.' set "'.$prop.'" = '.$this->sqlVal($this->$prop)
			);
		}
	}

	//Crea un nuevo registro de este elemento en la base de datos.
	public function insSQL()
	{
		$this->buff=$this->buff.'insert into '.$this->table.' ( ';
		$this->buffAux=$this->buffAux.' values( ';

		$this->eachNan
		(
			$this->props,
			function($clave , $valor){$this->insFnA($clave , $valor);},
			function($clave , $valor){$this->insFnB($clave , $valor);}
		);

		$this->buff=substr($this->buff,0,strlen($this->buff)-1).' ) ';
		$this->buffAux=substr($this->buffAux,0,strlen($this->buffAux)-1).' ) ';

		$res=$this->con->sql($this->buff.$this->buffAux);

		$this->buff='';
		$this->buffAux='';

		return $res;
	}
}
?>