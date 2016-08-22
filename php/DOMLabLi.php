<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabBase.php';

	class DOMLabLi extends DOMLabBase
	{
		private $div;
		private $titulo;
		private $link;
		private $name;
		private $color;
		private $target;
		private $mainTitle;

		private $priority;


		function __construct()
		{
			parent::__construct('li');

			$args=func_get_args();

			if( isset( $args[0] ) )
			{
				$this->setName( $args[0] );
			}

			$this->appendChild
			(
				$this->div=
				(
					new DOMTag( 'div' )
				)->addToAttribute('class' , 'organicaja')->appendChild
				(
					$this->titulo=new DOMTag
					(
						'span'
					)
				)
			);

			if( isset( $args[1] ) )
			{
				$this->setColor( $args[1] );
			}
		}
		function setName( $name )
		{
			$this->name=$name;

			return $this;
		}
		function getName()
		{
			return $this->name;
		}
		function setColor( $color )
		{
			$this->color=$color;

			return $this;
		}
		function setTarget($target)
		{
			$this->target=$target;

			return $this;
		}
		function setLink($link)
		{
			$this->link=$link;

			return $this;
		}
		function renderChilds(&$tag)
		{
			//$this->div->addToAttribute( 'class' , $this->color );

			if( !empty( $this->link ) )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

				$a=new DOMLink();

				$a->addToAttribute( 'class' , 'focuseable' );

				if(!empty($this->target))
				{
					$a->setAttribute( 'target' , $this->target );
				}

				$this->titulo->appendChild
				(
					$a->setName( $this->name )->setUrl( $this->link )
				);
			}
			else
			{
				$this->titulo->setTagValue( $this->name );
			}

			return parent::renderChilds( $tag );
		}
	}
?>