<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Desplazador.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';


class Visor extends Desplazador
{
	public	$recLst;
	private	$recMax;
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

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
		start_session_if_not();
/*
		echo '<pre>SESSION:';
		print_r
		(
			$_SESSION
		);
		echo '</pre>';
*/
		//Si realizando alguna operación (como comentar)
		//se pierde el ancla, la variable SESSION estará por si acaso.
		if(isset($_SESSION['vRecID']))
		{
			$this->discVal=$_SESSION['vRecID'];
		}
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

		$_SESSION['vRecID']=$this->recSel;

		$this->autoSetRecIDAnt();

		return $this->nRecSel;
	}
	private function autoSetRecIDAnt()
	{
		if($this->setRecIDAntIfValid($_SESSION))
		{
			$this->setRecIDAntIfValid($_GET);
		}

		$_SESSION['vRecIDAnt']=$this->recSel;
	}
	private function setRecIDAntIfValid($cont)
	{
		if(isset($cont['vRecIDAnt']))
		{
			$vRecIDAnt=strip_tags($cont['vRecIDAnt']);
			//echo '<pre>'.$this->discVal.'!='.$vRecIDAnt.'</pre>';

			if($this->discVal!=$vRecIDAnt)
			{
				$this->vRecIDAnt=$vRecIDAnt;

				return true;
			}
			return false;
		}
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
		//echo '<pre>$this->recLst['.$this->recMax.']=...</pre>';

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
class VisorHTMLBase extends Visor
{
	public $html;
	public $titulo;
	public $img;
	public $thumbPathA;
	public $thumbExt;

	function __construct()
	{
		parent::__construct();

		$this->html=new DOMTagContainer();
		$this->img=new DOMTag('img');

		$this->thumbPathA='/img/miniaturas/visor/';
		$this->thumbExt='.png';
	}
	public function formatUrlA($id)
	{
		return $this->thumbPathA.$id.$this->thumbExt;
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
	public function setImgAlt($alt)
	{
		$this->img->setAttribute('alt' , $alt);

		return $this;
	}
	public function setImgSrc($src)
	{
		$this->img->setAttribute('src' , $src);

		return $this;
	}
	public function setTitulo($titulo)
	{
		$this->titulo->setTagValue($titulo);

		return $this;
	}
}
class VisorNovedades extends VisorHTMLBase
{
	public $section;
	public $p;

	function __construct()
	{
		parent::__construct();

		$this->section=new DOMTag('section');
		$this->titulo=new DOMTag('h1');
		$this->p=new DOMTag('span');

		$this->p->classList->add('sangria');
		$this->img->classList->add('shadow');
		$this->section->classList->add('novedades');
		$this->section->col=['xs'=>10 , 'sm'=>10 , 'md'=>10 , 'lg'=>10];
		$this->img->col=	['xs'=>12 , 'sm'=>5 , 'md'=>5 , 'lg'=>5];


		$this->html->appendChild
		(
			$this->section->appendChild
			(
				$this->img
			)->appendChild
			(
				$this->titulo
			)->appendChild
			(
				$this->p
			)
		)->appendChild(new ClearFix());
	}
	public function addRec($rec , $imagenID , $tituloID , $descripcionID)
	{
		global $con;

		$selected=parent::addRec($rec);

		if($selected)
		{
			$this->setTitulo
			(
				getTraduccion($tituloID , $_SESSION['lang'])
			)->setImgAlt
			(
				getTraduccion
				(
					fetch_all
					(
						$con->query
						(
							'	SELECT AltID
								FROM Imagenes
								WHERE ID='.$imagenID
						),
						MYSQLI_NUM
					)[0][0],
					$_SESSION['lang']
				)
			)->setImgSrc
			(
				$this->formatUrlA($imagenID)
			)->setContenido
			(
				getTraduccion($descripcionID , $_SESSION['lang'])
			);
		}

		return $selected;
	}
	public function setContenido($contenido)
	{
		$this->p->appendXML($contenido);

		return $this;
	}
}
class VisorImagenes extends VisorHTMLBase
{
	public $div;
	public $imgAnt;
	public $selector;
	public $thumbPathB;
	

	function __construct()
	{
		parent::__construct();

		$this->titulo=new DOMTag('h2');
		$this->div=new DOMTag('div');
		$this->imgAnt=false;
		$this->selector=new DOMTag('div');
		
		$this->thumbPathB='/img/miniaturas/galeria/';
		

		$this->div->classList->add('imgCont');
		$this->selector->classList->add('selector');

		$this->div->col=	['xs'=> 8, 'sm'=> 10, 'md'=> 10, 'lg'=> 10];
		$this->titulo->col=		['xs'=> 12, 'sm'=> 12, 'md'=> 12, 'lg'=> 12];

		$this->html->appendChild($this->titulo)
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
	public function formatUrlB($id)
	{
		return $this->thumbPathB.$id.$this->thumbExt;
	}
	public function addRec($rec , $altID , $tituloID)
	{
		$selected=parent::addRec($rec);

		$alt=getTraduccion($altID , $_SESSION['lang']);

		$a=new DOMTag('a');

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

			$a->setAttribute('href','#')->classList->add('selected');
		}
		else
		{
			$a->setAttribute
			(
				'href',
				'/imagenes.php?vRecID='.$rec.'&vRecIDAnt='.$this->discVal
			);
		}
/*
		if($this->recSel===false)
		{
			$a->setAttribute('tabindex',2);
		}
		else
		{
			$a->setAttribute('tabindex',1);
		}
*/
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
	public function addImgAnt($src)
	{
		$this->img->classList->add('siguiente');
		$this->imgAnt=new DOMTag('img');
		$this->imgAnt->classList->add('anterior');
		$this->imgAnt->setAttribute('src' , $src);
		$this->div->appendChild($this->imgAnt);

		return $this;
	}
}
?>