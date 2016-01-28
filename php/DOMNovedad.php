<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

	class DOMNovedad extends DOMTag
	{
		public $descripcion;
		public $titulo;
		public $fecha;
		public $checkBox;
		public $imgSrc;
		public $imgAlt;
		public $fullUrl;

		function __construct()
		{
			parent::__construct('div');

			$this->classList->add('novedad');
			$this->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];

			$this
			->setImgSrc(false)
			->setImgAlt(false)
			->setTitulo(false)
			->setDescripcion(false)
			->setFullUrl(false)
			->checkBox=false;

		}

		function setCheckBox($checkBox)
		{
			if(isset($_SESSION['adminID']))
			{
				$this->checkBox=$checkBox;
			}

			return $this;
		}
		function setImgSrc($imgSrc)
		{
			$this->imgSrc=$imgSrc;

			return $this;
		}
		function setImgAlt($imgAlt)
		{
			$this->imgAlt=$imgAlt;

			return $this;
		}
		function setDescripcion($descripcion)
		{
			$this->descripcion=$descripcion;

			return $this;
		}
		function setFechaFromYmdHis($YmdHis)
		{
			$fecha=new DateTime();
			$fecha->createFromFormat('Y-m-d H:i:s' , $YmdHis);
			$fecha=$fecha->getTimestamp();

			$this->fecha=$fecha;

			return $this;
		}
		function setTitulo($titulo)
		{
			$this->titulo=$titulo;

			return $this;
		}
		function getFechaStr()
		{
			return sprintf
			(
				gettext('Escrito el %1$s de %2$s del %3$s'),
				strftime('%d' , $this->fecha),
				strftime('%B' , $this->fecha),
				strftime('%G' , $this->fecha)
			);
		}

		function setFullUrl($fullUrl)
		{
			$this->fullUrl=$fullUrl;

			return $this;
		}
		function renderChilds(&$doc , &$tag)
		{
			if($this->imgSrc!==false)
			{
				$div=new DOMTag('div');
				$div->col=['xs'=>12 , 'sm'=>6 , 'md'=>4 , 'lg'=>3];
				$img=new DOMTag('img');

				if($this->imgAlt!==false)
				{
					$img->setAttribute('alt' , $this->imgAlt);
				}

				$this->appendChild
				(
					$div->appendChild
					(
						$img->setAttribute('src' , $this->imgSrc)
					)
				);
			}

			if($this->titulo!==false)
			{
				$h2=new DOMTag
				(
					'h2',
					htmlentities
					(
						$this->titulo
					)
				);

				$this->appendChild
				(
					$h2
				);
			}

			if($this->descripcion!==false)
			{
				$descripcion=new DOMTag('p' , $this->descripcion);
				$descripcion->classList->add('sangria');

				$link=new DOMLink();

				$this->appendChild
				(
					$descripcion->appendChild
					(
						$link->setUrl
						(
							$this->fullUrl
						)->setOpensNewWindow
						(
							true
						)->setOffsetSuffix
						(
							sprintf
							(
								gettext('sobre la noticia %s'),
								$this->titulo
							)
						)->setName
						(
							gettext('Seguir Leyendo')
						)
					)
				);
			}

			$fecha=new DOMTag('p' , $this->getFechaStr());
			$fecha->classList->add('fecha');

			$this->appendChild($fecha);

			return parent::renderChilds($doc , $tag);
		}
	}
?>