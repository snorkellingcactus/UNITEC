<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBoxDate.php';

	class FormLabelFecha extends DOMTag
	{
		public $inputDia;
		public $inputMes;
		public $inputAno;
		public $inputHora;
		public $inputMin;
		public $contenedor;
		public $titulo;

		public function __construct()
		{
			parent::__construct('div');
			$this->classList->add('FormLabelBox');
			
			$this->inputAno=new LabelBoxDate
			(
				'Ano',
				'ano',
				gettext('Ano')
			);
			$this->inputMes=new LabelBoxDate
			(
				'Mes',
				'mes',
				gettext('Mes')
			);
			$this->inputDia=new LabelBoxDate
			(
				'Dia',
				'dia',
				gettext('Dia')
			);
			$this->inputHora=new LabelBoxDate
			(
				'Horas',
				'hora',
				gettext('Hora')
			);
			$this->inputMin=new LabelBoxDate
			(
				'Minutos',
				'min',
				gettext('Minuto')
			);
			$this->contenedor=new DOMTag('div');

			$this->titulo=new FormLabel(gettext('Fecha'));
			$this->titulo->setAttribute('id','fecha');

			$this->setAriaForLabels($this->inputAno)
			->setAriaForLabels($this->inputMes)
			->setAriaForLabels($this->inputDia)
			->setAriaForLabels($this->inputHora)
			->setAriaForLabels($this->inputMin);


			$this->titulo->col		=['xs'=>23	, 'sm'=>5	, 'md'=>5	, 'lg'=>5	];
			$this->inputAno->col	=['xs'=>12	, 'sm'=>4	, 'md'=>4	, 'lg'=>4	];
			$this->contenedor->col	=['xs'=>12	, 'sm'=>12	, 'md'=>12	, 'lg'=>12	];
			$this->contenedor->classList->add('FormDateCont');

			$this->titulo->classList->add('left');

			$this->appendChild($this->titulo)
			->appendChild
			(
				$this->contenedor->appendChild($this->inputAno)
				->appendChild($this->inputMes)
				->appendChild($this->inputDia)
				->appendChild($this->inputHora)
				->appendChild($this->inputMin)
			);
		}
		public function setAriaForLabels($input)
		{
			//A futuro crear clases que soporten labels mútiples.
			$input->label->setAttribute
			(
				'id',
				'label'.$input->input->getAttribute('id')
			);
			$input->input->setAttribute
			(
				'aria-labelledby',
				$this->titulo->getAttribute('id').' '.$input->label->getAttribute('id')
			);

			return $this;
		}
	}
?>