<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class FormCliHidden extends DOMTag
	{
		function __construct()
		{
			parent::__construct
			(
				'img'
			);
			$this
			->setAttribute('src' , '/img/invisible.png')
			->setAttribute('width' , '30px')
			->setAttribute('height' , '25px')
			->setAttribute('title' , gettext('Contenido invisible'));

		}
	}
?>