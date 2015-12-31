<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/VisorHTMLBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	
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
		public function add($rec , $imagenID , $tituloID , $descripcionID)
		{
			global $con;

			$selected=$this->addRec($rec);

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

?>