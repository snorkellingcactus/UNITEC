<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMapa.php';

	//Revisar. Usar clases que se usan en accionesMapa.d
	class FooterMapaForm extends FooterContainer
	{
		function __construct()
		{
			parent::__construct();

			$pRuta=new DOMTag('div');
			$pRuta->col=['xs'=>12 , 'sm'=>12 , 'md'=>5 , 'lg'=>5];

			$this->setAttribute('id' , 'gmapsDiag')->appendChild
		    (
		        $pRuta->setAttribute('id' , 'panel_ruta')->appendChild
		        (
		            new DOMTag
		            (
		                'button',
		                gettext('Especificar otro origen')
		            )
		        )
		    )->appendChild
		    (
		        new FormCliMapa()
		    );
		}
	}
?>