<?php
class Mod_HTML
{
	public $estructura;
	public $numVars;
	public $props;
	function __construct($estructura , $props)
	{
		$this->estructura=$estructura;
		$this->props=$props;

		$this->numVars=count($estructura)-1;
	}
	function gen($obj)
	{
		$iMax=$this->numVars;

		$buff='';

		for($i=0;$i<$iMax;$i++)
		{
			$prop=$this->props[$i];
			$buff=$buff.$this->estructura[$i].$obj->$prop;
		}
		

		return $buff.$this->estructura[$iMax];
	}
}
class Gal_HTML
{
	public	$maxCols=10;
	public	$minHeight=200;
	public	$minWidth=200;
	public	$width=500;
	public	$height=500;
	public	$imgLst=[];
	public	$genVisor=0;
	public	$disc='ID';	//Propiedad discriminadora a la hora de buscar u ordenar las imágenes.
	public  $discVal=8;	//Valor del discriminador.
	public	$imgSel;	//Imagen coincidente con el valor del discriminador.
	public	$modGal;
	public	$modVisor;
	
	function __construct($imgLst)
	{
		$this->imgLst=$imgLst;
		$args=func_get_args();

		if(isset($args[1]))
		{
			$this->modGal=$args[1];
		}
		if(isset($args[2]))
		{
			$this->visorMod($args[2]);
		}
	}
	function nImg($img)
	{
		$index=count($this->imgLst);
		$this->imgLst[$index]=$img;
	}
	function gen()
	{
		$buff='';
		$iMax=$this->maxCols;
		$jMax=count($this->imgLst);
		$j=0;
		
		while($j<$jMax)
		{
			
			for($i=0;$i<$iMax;$i++)
			{
				if(isset($this->imgLst[$i]))
				{
					$buff=$buff.$this->modGal->gen($this->imgLst[$i]);
				}
				++$j;
			}
		}
		if($this->genVisor)
		{
			$buff=$buff.$this->visor();
		}
		return $buff;
	}
	function visorMod($modHTML)
	{
		$this->modVisor=$modHTML;
		$this->genVisor=1;
	}
	function visor()
	{
		if(func_num_args())
		{
			$this->imgSel=$func_get_args()[0];
		}
		$this->genVisor=0;

		return $this->modVisor->gen($this->imgLst[$this->imgSel]);
	}
	function dspImg($inc)
	{
		$num=$this->imgSel+$inc;
		$max=count($this->imgLst);
		
		$this->imgSel=abs($num-intval($num/$max)*$max);
		
		return $this->imgSel;
	}
}
?>