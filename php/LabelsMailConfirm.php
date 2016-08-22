<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsMailConfirm extends DOMLabelsCollection
	{
		function __construct( &$index )
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';

			$this->appendChild
			(
				new MSGBox
				(
					gettext
					(
						'Muy bien!. Estás a un paso de enviarnos tu mensaje. Si estás seguro de lo que escribiste, hacé clic en continuar.'
					)
				)
			);

			//->classList->del('nuevo');
			//->delToAttribute('class' , 'nuevo');
		}
	}
?>