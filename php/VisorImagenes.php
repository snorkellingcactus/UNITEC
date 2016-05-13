<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/VisorHTMLBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

	class VisorImagenes extends VisorHTMLBase
	{
		public $div;
		public $imgAnt;
		public $selector;

		function __construct()
		{
			parent::__construct();

			$this->titulo=new DOMTag('h2');
			$this->div=new DOMTag('div');
			$this->imgAnt=false;
			$this->selector=new DOMTag('div');

			$this->div->addToAttribute('class' , 'imgCont');
			$this->selector->addToAttribute('class' , 'selector')->addToAttribute('class' ,'sugeridas');

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
		public function add($rec , $altID , $tituloID , $fecha)
		{
			$selected=$this->addRec($rec);

			$alt=getTraduccion($altID , $_SESSION['lang']);
			$titulo=getTraduccion($tituloID , $_SESSION['lang']);

			$fecha=new DateTime(date($fecha));

			$a=new DOMTag('a');

			if($selected)
			{
				$this->setTitulo
				(
					$titulo
				)->setImgAlt
				(
					$alt
				)->setImgSrc
				(
					$this->formatUrlA($rec)
				);

				$a->setAttribute('href','#')->addToAttribute('class' , 'selected');
			}
			else
			{
				//Revisar . Código en común con VisorImagenes, DOMMenuOpc, Modulo_Novedades , Modulo_Imagenes
				$a->setAttribute
				(
					'href',
					'/'								.
					substr( getenv('LANG'), 0 , 2 )	.
					'/espacios/'					.
					$this->lName					.
					'/galeria/'						.
					$fecha->format( 'Y-m-d' )		.
					'/'								.
					urlencode
					(
						str_replace
						(
							'/' ,
							' ' ,
							$titulo
						)
					)								.
					'-'								.
					$rec							.
					'&vRecIDAnt='					.
					$this->discVal
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

			$divA=new DOMTag('div');
			$divB=new DOMTag('div');
			$divB->addToAttribute('class' , 'gImg');
			$divB->col=['xs'=>2 , 'sm'=>2 , 'md'=>2 , 'lg'=>2];
			$divA->addToAttribute('class' , 'selectorCont');
			
			$this->selector->appendChild
			(
					$divB->appendChild
					(
						$a->appendChild
						(
							$img->setAttribute('src' , $this->formatUrlB($rec))
							->setAttribute('alt' , $alt)
						)
					)
			);

			return $selected;
		}
		public function addImgAnt($src)
		{
			
			$this->img->addToAttribute('class' , 'siguiente');
			$this->imgAnt=new DOMTag('img');
			$this->imgAnt->addToAttribute('class' , 'anterior');
			$this->imgAnt->setAttribute('src' , $src);
			$this->div->appendChild($this->imgAnt);

			return $this;
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
	}
?>