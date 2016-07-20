<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsLabBase extends DOMLabelsCollection
	{
		public $ubicacion;
		public $direccion;
		public $tag;
		public $nombre;
		public $telefono;
		public $enlace;
		public $abbr;
		public $mail;
		public $facebook;
		public $twitter;
		public $archivo;

		//public $con;

		function __construct(&$index)
		{
			parent::__construct($index);
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUbicacion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelDireccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelNombre.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAbbr.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTelefono.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelEnlace.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelMail.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelFacebook.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTwitter.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrlNov.php';

			$this->appendChild
			(
				$this->nombre=new FormLabelNombre()
			)->appendChild
			(
				$this->abbr=new FormLabelAbbr()
			)->appendChild
			(
				$this->tag=new FormLabelTag()
			)->appendChild
			(
				$this->archivo=new FormLabelUrlNov()
			)->appendChild
			(
				$this->mail=new FormLabelMail()
			)->appendChild
			(
				$this->telefono=new FormLabelTelefono()
			)->appendChild
			(
				$this->enlace=new FormLabelEnlace()
			)->appendChild
			(
				$this->direccion=new FormLabelDireccion()
			)->appendChild
			(
				$this->ubicacion=new FormLabelUbicacion()
			)->appendChild
			(
				$this->facebook=new FormLabelFacebook()
			)->appendChild
			(
				$this->twitter=new FormLabelTwitter()
			);
		}
		function renderChilds(&$tag)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;
			
			return parent::renderChilds($tag);
		}
	}
?>