<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImgMPBase.php';

	class GMapsImgPath extends GMapsImgMPBase
	{
		//$coordsA , $coordsB , $color , $weight
		//$coords , $color , $weight
		public function __construct($paths)
		{
			parent::__construct('path');

			$args=func_get_args();
			array_shift($args);

			while(isset($args[0]))
			{
				$this->addToAttribute('class' ,array_shift($args));
			}
			
			while(isset($paths[0]) && $paths[0] instanceof GMapsImgMarker)
			{
				$this->add
				(
					array_shift($paths)->coords
				);
			}
		}
	}
?>