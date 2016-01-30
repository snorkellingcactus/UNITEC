<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoText.php';

	class FooterInfoTelefono extends FooterInfoText
	{
		function __construct($text)
		{
			parent::__construct
			(
				$text,
				'/img/Telefono.png',
				gettext('Teléfono')
			);
		}
	}
?>