<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Obj.php';

class SQL_DOM extends SQL_Obj
{
	public $HID;
	public $padre;
	public $hijos=[];
	public $hermanoSig;
	public $hermanoAnt;
	public $reInsSQL=false;
	public $getArbolGenXML=false;
	private $hijosLen=0;

	public function __construct($con)
	{
		$nArgs=func_num_args();

		parent::__construct($con, 'SQLXML',['Tipo','Grp','Hijos','Val']);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
		if(!empty($this->hijos))
		{
			$hijosLen=count($this->hijos);

			for($i=0;$i<$hijosLen;$i++)
			{
				$nHijo=new SQL_DOM($this->con , $this->hijos[$i]);

				$this->hijo($nHijo);
			}
		}
	}

	function hijo( $obj )
	{
		$args=func_num_args();

		array_push( $this->hijos , $obj);

		$ind=$this->hijosLen;

		if($args>1)
		{
			$ind=func_get_args()[1];

			if(!$this->hijoOp(   $ind   ,   1))
			{
				return 0;
			}
		}

		$obj->HID	= $ind;
		$obj->padre=$this;

		$this->hijos[$ind]=$obj;

		if(isset($this->hijos[$ind+1]))
		{
		    $this->hijos[$ind]->hermanoSig=$this->hijos[$ind+1];
		}
		if(isset($this->hijos[$ind-1]))
		{
		    $this->hijos[$ind]->hermanoAnt=$this->hijos[$ind-1];
		}

		++$this->hijosLen;

		return 1;
	}
	function rHijo( $hijo )
	{
		$n=$hijo;
        
        if(gettype($n)!="integer")
        {
            $n=$n->HID;
        }
        
        return $this->HijoOp($n  ,  0);
	}
	function hijoOp( $ind , $op )
	{
		$inc=1;
		$len=$this->hijosLen;

		if($ind>$len || $ind<0)
		{
			return 0; 
		}

		if( !$op )
		{
			$len=$ind;
			$ind=count($this->hijos);
			$inc=-1;
		}

		$tmp=0;

		while(($len != $ind) && $tmp<100)
		{
			echo '<h1>Len = '.$len.'</h1>';
			echo '<h1>Inc = '.$inc.'</h1>';

			$this->hijos[$len]=$this->hijos[$len-$inc];

			$len=$len-$inc;

			$tmp++;
		}

		return 1;
	}
	function padre($obj , $ind=NULL)
	{
		$obj->hijo( $this , $ind );
	}
	function hermano($obj , $ind=NULL)
	{
		$this->padre->hijo( $obj , $ind );
	}
	function getArbolSQL()
	{
		$this->paramXML();
		if(isset($this->Hijos))
		{
			$hijos=$this->con->query("select * from ".$this->table." where Grp=".$this->Hijos);
			$hijos=fetch_all($hijos , MYSQLI_ASSOC);

			$hijosLen=count($hijos);
			for($i=0;$i<$hijosLen;$i++)
			{
				$nHijo=new SQL_DOM
				(
					$this->con,
					$hijos[$i]
				);
				if(!empty($this->getArbolGenXML))
				{
					$nHijo->getArbolGenXML=$this->getArbolGenXML;
				}

				$this->hijo($nHijo);



				$nHijo->getArbolSQL();
			}

			
		}
		$this->paramXML(false);
	}
	function paramXML($ini=true)
	{
		$tag='<';

		if(!$ini)
		{
			$tag='</';
		}
		if(!empty($this->getArbolGenXML))
		{
			if($this->Tipo=='Raiz')
			{
				echo $tag.'raiz>';
			}
			else
			{
				if($ini)
				{
					$this->getArbolGenXML->param($this->Tipo , $this->Val);
				}
			}
		}
	}
	function resArbolXML($resXMLObj=NULL)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Res_XML.php';

		if(isset($resXMLObj))
		{
			$this->getArbolGenXML=$resXMLObj;
		}
		else
		{
			$this->getArbolGenXML=new Res_XML();
		}

		$this->getSQL();
		
		$this->getArbolGenXML->ini();
		$this->getArbolSQL();
		$this->getArbolGenXML->fin();
		
	}
	function insArbolSQL()
	{

		$hijosLen=$this->hijosLen;
		if($hijosLen)
		{
			if(empty($this->Hijos))
			{
				$this->Hijos=nGrupo($this->con , 'Hijos' , $this->table);
				echo '<h1>Grupo '.$this->Hijos.'</h1>';

				if($this->reInsSQL || empty($this->ID))
				{
					$this->insSQL();
				}
			}

			for($i=0;$i<$hijosLen;$i++)
			{
				$this->hijos[$i]->Grp= $this->Hijos;
				$this->hijos[$i]->insArbolSQL();
			}

			return;
		}


		if($this->reInsSQL || empty($this->ID))
		{
			$this->insSQL();
		}
	}
}


?>