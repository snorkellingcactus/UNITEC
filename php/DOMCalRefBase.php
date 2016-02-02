<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMCalRefBase extends DOMTag
	{
		function __construct($offText , $text , $class)
		{
			parent::__construct('div');

			$this->col=['xs'=>12 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

			$div=new DOMTag('div');

			$spanA=new DOMTag('span' , $text);
			$spanB=new DOMTag('span');
			$spanOff=new DOMTag('span' , $offText);


			$spanB->classList->add($class);;
			$spanOff->classList->add('offscreen');
			$div->classList->add('calRef');

			//Revisar
			//$this->classList->add('hidden-screader');

			$this->appendChild
			(
				$div->appendChild
				(
					$spanA
				)->appendChild
				(
					$spanB->appendChild
					(
						$spanOff
					)
				)
			);
		}
	}
?>