<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTd.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SpanAtajo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SpanMas.php';

	class DOMTdAtajo extends DOMTd
	{
		function __construct($accessKeys , $atajo)
		{
			parent::__construct();

			$i=0;
			while(isset($accessKeys[$i]))
			{

				$this->appendChild
				(
					new SpanAtajo($accessKeys[$i])	
				)->appendChild
				(
					new SpanMas()
				);

				++$i;
			}

			$this->appendChild
			(
				new SpanAtajo($atajo)
			);
		}
	}
?>