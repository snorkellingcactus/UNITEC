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
	public	$imgLst=[];
	public	$genVisor=0;
	public	$disc='ID';	//Propiedad discriminadora a la hora de buscar u ordenar las imágenes.
	public  $discVal=0;	//Valor del discriminador.
	public	$imgSel=NULL;	//Imagen coincidente con el valor del discriminador.
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
		$iMax=count($this->imgLst);
		
			
		for($i=0;$i<$iMax;$i++)
		{
			if(isset($this->imgLst[$i]))
			{
				$buff=$buff.$this->modGal->gen($this->imgLst[$i]);
				if(isset($this->imgSel))
				{
					$this->discImg($i);
				}
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
	}
	//Devuelve el código HTML para mostrar la imagen selecionada.
	function visor()
	{
		if(func_num_args())
		{
			$this->imgSel=$func_get_args()[0];
		}
		$this->genVisor=0;

		return $this->modVisor->gen($this->imgLst[$this->imgSel]);
	}
	//Desplaza la imagen seleccionada para el visor $inc veces.
	function incImgN($inc)
	{
		$num=$this->imgSel+$inc;
		return $this->selImgN($num);
	}
	//Setea la imagen que despliega el visor impidiendo errores con
	//números fuera de rango.
	function selImgN($num)
	{
		$max=count($this->imgLst);
		
		$this->imgSel=abs($num-intval($num/$max)*$max);
		if($num<0)
		{
			$this->imgSel=$max-$this->imgSel;
		}
		return $this->imgSel;
	}
	//Discrimina una imagen segun el valor de una de sus propiedades.
	function discImg($nImg)
	{
		$prop=$this->disc;
		if($this->imgLst[$nImg]->$prop==$this->discVal)
		{
			$this->imgSel=$nImg;
		}
	}
}
?>