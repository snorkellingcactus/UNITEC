<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsMailSend extends DOMLabelsCollection
	{
		function __construct( &$index )
		{
			parent::__construct( $index );

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';

			$this->appendChild
			(
				new MSGBox
				(
					gettext
					(
						'El mensaje se envió con éxito. Te agradecemos la retroalimentación.'
					)
				)
			);
		}
	}
?>