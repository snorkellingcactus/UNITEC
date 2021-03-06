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
//Un objeto que permite realizar operaciónes SQL con
//Una fila de una tabla.
class SQL_Obj
{
	public $con;
	public $actForaneas;

	public $table;
	public $omiteNULL;
	public $primary;

	private $buff;
	private $buffAux;
	private	$foraneasLst;
	private $foraneasIndex;
	private $data;

	public function __construct($table , $props , $con=NULL)
	{
		$this->actForaneas=true;
		$this->omiteNULL=true;
		$this->primary='ID';

		$this->foraneasLst=NULL;
		$this->foraneasIndex=0;
		$this->data=array();

		if($con===NULL)
		{
			if(!isset($GLOBALS['con']))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			}
			$con=$GLOBALS['con'];
		}
		$this->con=$con;
		$this->table=$table;
		
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
	//Seguridad acá. Improvisar algo con
	//specialchars o htmlentities o {}
	//Si es numero devuelve el numero, sino, devuelve el valor con las comillas ("") agregadas.
	public function sqlVal($val)
	{
		if($val===NULL)
		{
			return 'NULL';
		}
		if(is_int($val))
		{
			return intVal($val);
		}
		if(is_float($val))
		{
			return floatval($val);
		}
		if(is_string($val))
		{
			return utf8_encode('"'.addslashes($val).'"');
		}
		if(is_bool($val))
		{
			return !!$val;
		}
	}
	public function conFnA($clave , $valor)
	{
		$this->data[$clave]=$valor;
	}
	public function conFnB($clave , $valor)
	{
		$this->data[$valor]=NULL;
	}
	public function updVarsFnA($clave , $valor)
	{
/*
		echo '<pre>updVarsFnA: Clave:';
		print_r($clave);
		echo '</pre>';
		echo '<pre>updVarsFnA: Valor:';
		print_r($valor);
		echo '</pre>';
*/
		if(!empty($valor))
		{
			$this->data[$clave]=$valor;
		}
	}
	public function updVarsFnB($clave , $valor)
	{
		
	}
	private function updFnA($clave , $valor)
	{
		if($this->omiteNULL===true && $valor===NULL)
		{
			return;
		}

		$this->buff=$this->buff.$clave.'=';
		$this->buff=$this->buff.$this->sqlVal($valor).',';
	}
	private function updFnB($clave , $valor)
	{
		if($this->omiteNULL && $this->data[$valor]===NULL)
		{
			return;
		}

		$this->buff=$this->buff.$valor.'=';
		$this->buff=$this->buff.$this->sqlVal($this->$valor).',';
	}
	private function getFnA($clave , $valor)
	{
		if($this->omiteNULL===true && $valor===NULL)
		{
			return;
		}

		$this->buff=$this->buff.$clave.'=';
		$this->buff=$this->buff.$this->sqlVal($valor).' and ';
	}
	private function getFnB($clave , $valor)
	{
		if($this->omiteNULL && $this->data[$valor]===NULL)
		{
			return;
		}

		$this->buff=$this->buff.$valor.'=';
		$this->buff=$this->buff.$this->sqlVal( $this->data[ $valor ] ).' and ';
	}
	private function insFnA( $clave , $valor )
	{
		if($this->omiteNULL && $valor === NULL)
		{
			return;
		}

		$this->buff=$this->buff.$clave.' , ';
		$this->buffAux=$this->buffAux.$this->sqlVal($valor).' ,';
	}
	private function insFnB($clave , $valor)
	{
		if($this->omiteNULL && $this->data[$valor]===NULL)
		{
			return;
		}
		$this->buff=$this->buff.$valor.' ,';
		$this->buffAux=$this->buffAux.$this->sqlVal($this->$valor).' ,';
	}
	public function where($data=false)
	{
		if( !$data )
		{
			$data=$this->data;
		}

		eachNan
		(
			$data,
			function($clave , $valor){$this->getFnA($clave , $valor);},
			function($clave , $valor){$this->getFnB($clave , $valor);}
		);

		return $this->buff=substr($this->buff , 0 , strlen($this->buff)-4);
	}
	public function update($data=false)
	{
		if(!$data)
		{
			$data=$this->data;
		}

		eachNan
		(
			$data,
			function($clave , $valor){$this->updFnA($clave , $valor);},
			function($clave , $valor){$this->updFnB($clave , $valor);}
		);

		//Saco comas finales, cierro parentesis y agrego espacio.
		return $this->buff=substr($this->buff,0,strlen($this->buff)-1);
	}
	public function getSQL( $data=false )
	{
		$this->buff='select * from '.$this->table.' where ';

		$this->buff=$this->where( $data ).' limit 1';

//		echo '<pre>'.$this->buff.'</pre>';

		$res=$this->con->query( $this->buff );

		if($res->num_rows)
		{
			$res=fetch_all( $res , MYSQLI_ASSOC )[0];

			foreach($res as $clave=>$valor)
			{
				$this->$clave=$valor;
			}
		}

		$this->buff='';
	}
	//Crea un nuevo registro de este elemento en la base de datos.
	public function insSQL($data=false)
	{
		$this->foraneas('insSQL');

		$this->buff=$this->buff.'insert into '.$this->table.' (  ';
		$this->buffAux=$this->buffAux.' values( ';

		if($data===false)
		{
			$data=$this->data;
		}

		eachNan
		(
			$data,
			function($clave , $valor){$this->insFnA($clave , $valor);},
			function($clave , $valor){$this->insFnB($clave , $valor);}
		);

		$this->buff=substr($this->buff,0,strlen($this->buff)-2).' ) ';
		$this->buffAux=substr($this->buffAux,0,strlen($this->buffAux)-1).' ) ';

//		echo '<pre>'.$this->buff.$this->buffAux.'</pre>';
		$res=$this->con->query($this->buff.$this->buffAux);
//		echo '<pre>SQLErrors:'.$this->con->error.'</pre>';

		if(array_key_exists($this->primary , $this->data))
		{
			$this->data[$this->primary]=$this->con->insert_id;
		}
		$this->buff='';
		$this->buffAux='';
		return $res;

	}
	//Actualiza los campos de un registro de este elemento en la base de datos.
	public function updSQL($disc=false , $data=false)
	{
		$this->foraneas('updSQL');

		$this->buff='update '.$this->table.' set ';	//Sentencias SQL para actualizar filas de una tabla.

		$this->update($disc);

		$this->buff=$this->buff.' where ';

		$this->where($data);
		
//		echo '<pre>'.htmlentities('updSQL: '.$this->buff).'</pre>';
//		echo '<pre>SQLErrors:'.$this->con->error.'</pre>';

		$res=$this->con->query($this->buff);

		if($data)
		{
			eachNan
			(
				$data,
				function($clave , $valor){$this->updVarsFnA($clave , $valor);},
				function($clave , $valor){$this->updVarsFnB($clave , $valor);}
			);
		}

		$buff='';

		return $res;
	}
	//Elimina la fila de la BD.
	public function remSQL($data=false)
	{
		$this->where($data);

//		echo '<pre>'.'delete from '.$this->table.' where '.$this->buff.'</pre>';

		$this->con->query('delete from '.$this->table.' where '.$this->buff);

		$this->foraneas('remSQL');
	}
	//Realiza la operación SQL pasada como parámetro a todos los
	//Objetos foráneos que halla.
	public function foraneas($opStr)
	{
		if(isset($this->foraneasLst)&&$this->actForaneas)
		{
			for($i=0;$i<$this->foraneasIndex;$i++)
			{
				$this->foraneasLst[$i]->opSQL($opStr);
			}
		}
	}
	//Creo una relación foránea con otro SQL_Obj.
	public function insForanea($sqlObj , $nomColA , $nomColB)
	{
		if(!isset($this->foraneasLst))
		{
			$this->foraneasLst=[];
		}
		
		$res=$this->foraneasLst[$this->foraneasIndex]=new Foranea($this, $sqlObj , $nomColA , $nomColB);

		++$this->foraneasIndex;

		return $res;
	}
	public function __set($nombre , $valor)
	{
		if(array_key_exists($nombre , $this->data))
		{
			$this->data[$nombre]=$valor;
		}
		else
		{
			$this->$nombre=$valor;
		}
	}
	public function __get($nombre)
	{
		if(array_key_exists($nombre, $this->data))
		{
			return $this->data[$nombre];
		}
		return $this->$nombre;
	}
}
?>