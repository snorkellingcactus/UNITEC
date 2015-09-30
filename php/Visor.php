<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Desplazador.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';


class Visor extends Desplazador
{
	public	$recLst;
	private $recMax;
	public	$nRecSel;		//Número de Imagen coincidente con el valor del discriminador.
	public	$recSel;		//Objeto imagen seleccionado.
	public	$vRecIDAnt;
	public	$discVal;

	public function __construct()
	{
		parent::__construct(0 , true);

		$this->recLst=[];
		$this->recMax=0;
		$this->nRecSel=NULL;
		$this->recSel=false;
		$this->discVal=false;
		$this->vRecIDAnt=false;

		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		if(isset($_GET['vRecID']))
		{
			$this->discVal=strip_tags($_GET['vRecID']);
		}
	}

	//Setea el n de imagen que despliega el visor impidiendo errores con
	//números fuera de rango.
	function selRecN($num)
	{
		$this->nRecSel=$this->indexRecN($num);

		$this->recSel=& $this->recLst[$this->nRecSel];

		if(isset($_GET['vRecIDAnt']))
		{
			$vRecIDAnt=strip_tags($_GET['vRecIDAnt']);

			if($this->discVal!=$vRecIDAnt)
			{
				$this->vRecIDAnt=$vRecIDAnt;
			}
		}

		return $this->nRecSel;
	}
	//Devuelve el objeto almacenado en la posición especificada.
	public function RecN($n)
	{
		return $this->recLst
		[
			$this->indexRecN($n)
		];
	}
	//Discrimina un objeto imagen segun el resultado de compararla con los valores de $this->disc.
	public function discRec($nRec)
	{
		$rec=$this->recLst[$nRec];

		//Si alguno de los valores es distinto no se selecciona.
		if($rec==$this->discVal)
		{
			$this->selRecN($nRec);
			return 1;
		}

		return 0;
	}
	public function discRecLst()
	{
		$iMax=count($this->recLst);

		for($i=0;$i<$iMax;$i++)
		{
			if($this->discRec($i))
			{
				break;
			}
		}
	}
	public function addRec($rec)
	{
		$this->recLst[$this->recMax]=$rec;

		++$this->recMax;
		$this->max=$this->recMax;

		return $this->discRec($this->recMax-1);
	}
	public function getContent()
	{
		if(!isset($this->recLst[0]))
		{
			$this->discRecLst();
		}
		if($this->recSel===false)
		{
			$this->selRecN(0);
		}
	}
}

class VisorImagenes extends Visor
{
	public $h2;
	public $div;
	public $img;
	public $imgAnt;
	public $selector;
	public $html;
	public $thumbPathA;
	public $thumbPathB;
	public $thumbExt;

	function __construct()
	{
		parent::__construct();

		$this->h2=new DOMTag('h2');
		$this->div=new DOMTag('div');
		$this->img=new DOMTag('img');
		$this->imgAnt=false;
		$this->selector=new DOMTag('div');
		$this->html=new DOMTagContainer();
		$this->thumbPathA='/img/miniaturas/visor/';
		$this->thumbPathB='/img/miniaturas/galeria/';
		$this->thumbExt='.png';

		$this->div->classList->add('imgCont');
		$this->selector->classList->add('selector');

		$this->div->col=	['xs'=> 8, 'sm'=> 10, 'md'=> 10, 'lg'=> 10];
		$this->h2->col=		['xs'=> 12, 'sm'=> 12, 'md'=> 12, 'lg'=> 12];

		$this->html->appendChild($this->h2)
		->appendChild
		(
			$this->div->appendChild($this->img)
		)->appendChild
		(
			new ClearFix()
		)->appendChild
		(
			$this->selector
		);
	}
	public function formatUrlA($id)
	{
		return $this->thumbPathA.$id.$this->thumbExt;
	}
	public function formatUrlB($id)
	{
		return $this->thumbPathB.$id.$this->thumbExt;
	}
	public function selRecN($n)
	{
		parent::selRecN($n);

		if($this->vRecIDAnt!==false)
		{
			$this->addImgAnt
			(
				$this->formatUrlA($this->vRecIDAnt)
			);
		}
	}
	public function getContent()
	{
		parent::getContent();

		return $this->html->getHTML();
	}
	public function addRec($rec , $altID , $tituloID)
	{
		$selected=parent::addRec($rec);

		$alt=getTraduccion($altID , $_SESSION['lang']);

		if($selected)
		{
			$this->setTitulo
			(
				getTraduccion($tituloID , $_SESSION['lang'])
			)->setImgAlt
			(
				$alt
			)->setImgSrc
			(
				$this->formatUrlA($rec)
			);
		}

		$a=new DOMTag('a');
		$a->setAttribute('href' , '/imagenes.php?vRecID='.$rec.'&vRecIDAnt='.$this->discVal);

		$img=new DOMTag('img');
		$img->col=['xs'=>2 , 'sm'=>2 , 'md'=>2 , 'lg'=>2];
		
		$this->selector->appendChild
		(
			$a->appendChild
			(
				$img->setAttribute('src' , $this->formatUrlB($rec))
				->setAttribute('alt' , $alt)
			)
		);

		return $selected;
	}
	public function setImgAlt($alt)
	{
		$this->img->setAttribute('alt' , $alt);

		return $this;
	}
	public function setTitulo($titulo)
	{
		$this->h2->setTagValue($titulo);

		return $this;
	}
	public function addImgAnt($src)
	{
		$this->imgAnt=new DOMTag('img');
		$this->imgAnt->classList->add('anterior');
		$this->imgAnt->setAttribute('src' , $src);
		$this->div->appendChild($this->imgAnt);

		return $this;
	}
	public function setImgSrc($src)
	{
		$this->img->setAttribute('src' , $src);

		return $this;
	}
}
?>