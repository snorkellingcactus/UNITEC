<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoText.php';

	class FooterInfoDireccion extends FooterInfoText
	{
		function __construct($text)
		{
			parent::__construct
			(
				$text,
				'/img/DireccionID.png',
				gettext('Dirección')
			);
		}
	}
?>