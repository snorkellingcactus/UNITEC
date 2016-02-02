<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterContainer.php';

	//Revisar. Usar clases que se usan en accionesMapa.d
	class FooterMapa extends FooterContainer
	{
		function __construct($labName , $latLong)
		{
			parent::__construct();

			$imgMapa=new DOMTag('img');
			$imgMapa->classList->add('map-canvas');

			$this->appendChild
		    (
		        $imgMapa->setAttribute('id' , 'map-canvas')->setAttribute
		        (
		            'src', 
		            'https://maps.googleapis.com/maps/api/staticmap?center='.$latLong.'&zoom=17&size=500x500&maptype=roadmap&markers=color:red%7Clabel:A%7C'.$latLong.'&key=AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk' 
		        )->setAttribute
		        (
		            'alt',
		            sprintf
		            (
		                gettext('Mapa de la ubicación de %s'),
		                $labName
		            )
		        )
		    );
		}
	}
?>