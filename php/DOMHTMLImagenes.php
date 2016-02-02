<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLVisores.php';

	class DOMHTMLImagenes extends DOMHTMLVisores
	{
		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBodyImagenes.php';

			$this->appendChild
			(
				$this->body=new DOMBodyImagenes()
			)->setDescription
			(
				gettext('Galería de imágenes de unitec.')
			)->setTitle
			(
				//gettext('Visor de imágenes')
				getLabName()
			);
		}
	}
?>