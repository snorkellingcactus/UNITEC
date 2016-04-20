<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImgMPBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsXYCoords.php';

	class GMapsImgMarker extends GMapsImgMPBase
	{
		//$coordsA , $coordsB , $color , $weight
		//$coords , $color , $weight
		public $coords;

		public function __construct($coords)
		{
			parent::__construct('markers');
			if(is_array($coords))
			{
				$coords=new GMapsXYCoords($coords[0] , $coords[1]);
			}

			$args=func_get_args();
			array_shift($args);

			while(isset($args[0]))
			{
				$this->addToAttribute('class' ,array_shift($args));
			}
			
			$this->addToAttribute('class' ,$coords);

			$this->coords=$coords;
		}
	}
?>