<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterContainer.php';

	class FooterInfo extends FooterContainer
	{
		public $facebook;
		public $twitter;
		public $direccion;
		public $mail;
		public $telefono;

		function __construct()
		{
			parent::__construct();

			$this->setTagName('ul');

			//Revisar. h1 not allowed in this context.
			$this->appendChild
			(
				$titulo=new DOMTag
				(
					'h1',
					gettext( 'Otros medios' )
				)
			);

			$titulo->col=[ 'xs'=> 12 , 'sm'=> 12 , 'md'=> 12 , 'lg'=> 12];
		}
		function setFacebook($facebook)
		{
			$this->facebook=$facebook;

			return $this;
		}
		function setTwitter($twitter)
		{
			$this->twitter=$twitter;

			return $this;
		}
		function setMail($mail)
		{
			$this->mail=$mail;

			return $this;
		}
		function setDireccion($direccion)
		{
			$this->direccion=$direccion;

			return $this;
		}
		function setTelefono($telefono)
		{
			$this->telefono=$telefono;

			return $this;
		}
		function appendInfoChild($child)
		{
			$child->col=['xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

			return parent::appendChild($child);
		}
		function renderChilds(&$tag)
		{
			if(!empty($this->facebook))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoFacebook.php';

				$this->appendInfoChild
				(
					new FooterInfoFacebook($this->facebook)
				);
			}
			if(!empty($this->twitter))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoTwitter.php';

				$this->appendInfoChild
				(
					new FooterInfoTwitter($this->twitter)
				);
			}

			if(!empty($this->twitter) || !empty($this->facebook))
			{
				$this->appendChild
				(
					new ClearFix()
				);
			}

			if(!empty($this->telefono))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoTelefono.php';

				$this->appendInfoChild
				(
					new FooterInfoTelefono($this->telefono)
				);
			}
			if(!empty($this->mail))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoMail.php';

				$this->appendInfoChild
				(
					new FooterInfoMail($this->mail)
				);
			}
			if(!empty($this->direccion))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoDireccion.php';

				$this->appendInfoChild
				(
					new FooterInfoDireccion($this->direccion)
				);
			}

			return parent::renderChilds($tag);
		}
	}
?>