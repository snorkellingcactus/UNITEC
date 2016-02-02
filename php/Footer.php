<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class Footer extends DOMTag
	{
		public $container;

		function __construct()
		{
			parent::__construct('footer');

			$this->classList->add('Footer')->add('header');



			parent::appendChild
			(
				$this->container=new DOMTag('div')
			);

			$this->container->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
			$this->container->classList->add('FooterMainContainer');
		}
		function appendChild($child)
		{
			$this->container->appendChild($child);

			return $this;
		}
	}
?>