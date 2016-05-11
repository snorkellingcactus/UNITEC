<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsMail extends DOMLabelsCollection
	{
		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';

			$this->appendChild
			(
				new MSGBox
				(
					gettext('Muchas Gracias. Su consulta fué enviada')
				)
			);

			//->classList->del('nuevo');
			//->delToAttribute('class' , 'nuevo');
		}
	}
?>