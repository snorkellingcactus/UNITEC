<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMBody extends DOMTag
	{
		public $onLoad;

		function __construct()
		{
			parent::__construct( 'body' );

			$this->setOnLoad( false );
		}

		function setOnLoad( $onLoad )
		{
			$this->onLoad=$onLoad;

			return $this;
		}

		function renderChilds( &$tag )
		{
			if( $this->onLoad!==false )
			{
				$this->setAttribute( 'onLoad' , $this->onLoad );
			}

			return parent::renderChilds( $tag );
		}
	}
?>