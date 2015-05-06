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

function nGrupo($con , $col , $tabla)
{
	$grp=$con->query('select ifnull(max('.$col.'),0) as '.$col.' from '.$tabla);
	
	return fetch_all($grp , MYSQLI_ASSOC)[0][$col]+1;
}
//Un objeto que permite realizar operaciónes SQL con
//Una fila de una tabla.
class SQL_Obj
{
	public $con;
	public $actForaneas=true;
	public $gupoNom="Grupo";

	public $table;
	public $props;
	private $buff;
	private $buffAux;
	private	$foraneasLst=NULL;
	private $foraneasIndex=0;

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
	//Seguridad acá. Improvisar algo con
	//specialchars o htmlentities o {}
	public function sqlSpec($val)
	{
		return $this->sqlVal($val);
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
		$this->buff=$this->buff.$this->sqlSpec($valor).',';
	}
	private function updFnB($clave , $valor)
	{
		$this->buff=$this->buff.$valor.'=';
		$this->buff=$this->buff.$this->sqlSpec($this->$valor).',';
	}
	private function getFnA($clave , $valor)
	{
		$this->buff=$this->buff.$clave.'=';
		$this->buff=$this->buff.$this->sqlSpec($valor).' and ';
	}
	private function getFnB($clave , $valor)
	{
		if(!isset($this->$valor))
		{
			return;
		}

		$this->buff=$this->buff.$valor.'=';
		$this->buff=$this->buff.$this->sqlSpec($this->$valor).' and ';
	}
	private function insFnA($clave , $valor)
	{
		$this->buff=$this->buff.$clave.' , ';
		$this->buffAux=$this->buffAux.$this->sqlSpec($valor).' ,';
	}
	private function insFnB($clave , $valor)
	{
		if(isset($this->$valor))
		{
			$this->buff=$this->buff.$valor.' ,';
			$this->buffAux=$this->buffAux.$this->sqlSpec($this->$valor).' ,';
		}
	}
	//Actualiza los campos de un registro de este elemento en la base de datos.
	public function updSQL()
	{
		if(!isset($this->ID))
		{
			return 0;
		}
		if(func_num_args())
		{
			$prop=func_get_args()[0];
		}
		else
		{
			$prop=$this->props;
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

			echo '<pre>'.$this->buff.'</pre>';
			
			$res=$this->con->query($this->buff);

			$buff='';

			return $res;
		}
		if(isset($this->$prop))
		{
			echo '<pre>'.'update '.$this->table.' set '.$prop.' = '.$this->sqlSpec($this->$prop).' where ID='.$this->ID.'</pre>';
			return $this->con->query
			(
				'update '.$this->table.' set '.$prop.' = '.$this->sqlSpec($this->$prop).' where ID='.$this->ID
			);
		}
		$this->foraneas('updSQL');
	}
	//Crea un nuevo registro de este elemento en la base de datos.
	public function insSQL()
	{
		$this->foraneas('insSQL');

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
		$this->ID=$this->con->insert_id;

		echo '<pre>'.$this->buff.$this->buffAux.'</pre>';
		
		$this->buff='';
		$this->buffAux='';
		return $res;
	}
	//Elimina la fila de la BD.
	public function remSQL()
	{
		$this->con->query('delete from '.$this->table.' where ID='.$this->ID);
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
	public function insForaneas($sqlObj,$foraneas)
	{
		if(!isset($this->foraneasLst))
		{
			$this->foraneasLst=[];
		}
		
		$res=$this->foraneasLst[$this->foraneasIndex]=new Foraneas($this , $sqlObj , $foraneas);

		++$this->foraneasIndex;

		return $res;
	}

	public function getSQL()
	{
		$this->buff='select * from '.$this->table.' where ';

		eachNan
		(
			$this->props,
			function($clave , $valor){$this->getFnA($clave , $valor);},
			function($clave , $valor){$this->getFnB($clave , $valor);}
		);

		$this->buff=substr($this->buff , 0 , strlen($this->buff)-4).' limit 1';

		$res=$this->con->query($this->buff);
		$res=fetch_all($res , MYSQLI_ASSOC)[0];

		foreach($res as $clave=>$valor)
		{
			$this->$clave=$valor;
		}

		$this->buff='';
	}
}
?>