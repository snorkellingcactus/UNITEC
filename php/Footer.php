<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class Footer extends DOMTag
	{
		public $container;

		function __construct()
		{
			parent::__construct('footer');

			$this->addToAttribute('class' , 'Footer')->addToAttribute('class' ,'header');



			parent::appendChild
			(
				$this->container=new DOMTag('div')
			);

			$this->container->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
			$this->container->addToAttribute('class' , 'FooterMainContainer');

			$this->col=['xs'=>12 , 'sm'=>10 , 'md'=>10 , 'lg'=>10];
		}
		function appendChild($child)
		{
			$this->container->appendChild($child);

			return $this;
		}
	}
?>