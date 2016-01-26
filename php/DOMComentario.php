<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMComentario extends DOMTag
	{
		public $nombre;
		public $fecha;
		public $contenido;
		public $autor;
		public $remitente;
		private $childOfMain;

		public $pAutor;
		public $pContenido;
		public $spanNombre;
		public $form;
		public $checkBox;
		public $btnRes;
		public $spanFecha;

		function __construct()
		{
			parent::__construct('div');

			$this->classList->add('comentario');

			$this->pAutor=new DOMTag('p');
			$this->pContenido=new DOMTag('p');
			$this->spanNombre=new DOMTag('span');
			$this->spanFecha=new DOMTag('span');

			$this->pAutor->classList->add('header');
			$this->pContenido->classList->add('contenido');
			$this->spanFecha->classList->add('fecha');
			$this->spanNombre->classList->add('nombre');

			$this->setRemitente(false)->appendNHilo(false)->setChildOfMain(false)->checkBox=false;
		}
		function setChildOfMain($childOfMain)
		{
			$this->childOfMain=$childOfMain;

			return $this;
		}
		function isChildOfMain()
		{
			return $this->childOfMain;	
		}
		function setNombre($nombre)
		{
			$this->nombre=$nombre;

			return $this;
		}
		function setAutor($autor)
		{
			$this->autor=$autor;

			return $this;
		}
		function setRemitente($remitente)
		{
			$this->remitente=$remitente;

			return $this;
		}
		function setFecha($fecha)
		{
			$this->fecha=$fecha;

			return $this;
		}
		function setContenido($contenido)
		{
			$this->contenido=$contenido;

			return $this;
		}
		function setCheckBox($checkBox)
		{
			if(isset($_SESSION['adminID']))
			{
				$this->checkBox=$checkBox;
			}

			return $this;
		}
		function setBtnRes($btnRes)
		{
			$this->btnRes=$btnRes;

			return $this;
		}
		function appendNHilo($nHilo)
		{
			$this->nHilo=$nHilo;

			return $this;
		}
		function formatFecha()
		{
			$rangoTiempo=['y' , 'm' , 'd' , 'h' , 'i' , 's'];
			
			$fecha=new DateTime();
			$fecha=$fecha->createFromFormat('Y-m-d H:i:s' , $this->fecha);
			$fecha=$fecha->diff
			(
				new DateTime() , true
			);

			$t=0;
			$tMax=5;

			while($fecha->$rangoTiempo[$t]<=0 && $t<$tMax)
			{
				++$t;
			}

			$valorTiempo=$fecha->$rangoTiempo[$t];

			$rTHumano=
			[
				ngettext('Hace %s año' , 'Hace %s años' , $valorTiempo),
				ngettext('Hace %s mes' , 'Hace %s meses' , $valorTiempo),
				ngettext('Hace %s dia' , 'Hace %s dias' , $valorTiempo),
				ngettext('Hace %s hora' , 'Hace %s horas' , $valorTiempo),
				ngettext('Hace %s minuto' , 'Hace %s minutos' , $valorTiempo),
				ngettext('Hace %s segundo' , 'Hace %s segundos' , $valorTiempo)
			];

			return sprintf($rTHumano[$t] , $valorTiempo);
		}

		function renderChilds(&$doc , &$tag)
		{
			$this->appendChild
			(
				$this->pAutor->appendChild
				(	
					$this->spanNombre
				)
			);
			$this->appendChild
			(
				$this->btnRes
			);

			if($this->remitente!==false)
			{
				$spanRemitente=new DOMTag('span');
				$spanRemitente->classList->add('remitente');

				$this->pAutor->appendChild
				(
					$spanRemitente->setTagValue
					(
						sprintf
						(
							gettext('En respuesta a %s'),
							htmlentities($this->remitente)
						)
					)
				);
			}
/*
			if($this->form!==false)
			{
				$this->appendChild($this->form);
			}
*/
			if($this->checkBox!==false)
			{
				$this->appendChild($this->checkBox);
			}

			$this->appendChild
			(
				$this->pContenido->setTagValue
				(
					htmlentities
					(
						$this->contenido
					)
				)
			);

			$this->spanNombre->setTagValue
			(
				htmlentities
				(
					$this->nombre
				)
			);

			
			$this->pAutor->appendChild
			(
				$this->spanFecha->setTagValue
				(
					$this->formatFecha()
				)
			);

			if($this->nHilo!==false)
			{
				$this->appendChild($this->nHilo);
			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>