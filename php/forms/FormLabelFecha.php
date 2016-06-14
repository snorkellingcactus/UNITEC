<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBoxMultiple.php';

	class FormLabelFecha extends FormLabelBoxMultiple
	{
		public $inputDia;
		public $inputMes;
		public $inputAno;
		public $inputHora;
		public $inputMin;
		public $inputsCols;
		public $contenedor;
		public $titulo;

		public function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBoxDate.php';

			$this->setLabelName(gettext('Fecha'));
			$this->label->setID('fecha');

			//$this->label->addToAttribute('class' , 'left');
			$this->appendChild
			(
				$this->contenedor=new DOMTag('div')
			);
			$this->contenedor->addToAttribute('class' , 'FormDateCont');//ainer
			
			$this->appendLBox
			(
				$this->inputAno=new LabelBoxDate
				(
					'Ano',
					'ano',
					gettext('Ano')
				)
			)->appendLBox
			(
				$this->inputMes=new LabelBoxDate
				(
					'Mes',
					'mes',
					gettext('Mes')
				)
			)->appendLBox
			(
				$this->inputDia=new LabelBoxDate
				(
					'Dia',
					'dia',
					gettext('Dia')
				)
			)->appendLBox
			(
				$this->inputHora=new LabelBoxDate
				(
					'Horas',
					'hora',
					gettext('Hora')
				)
			)->appendLBox
			(
				$this->inputMin=new LabelBoxDate
				(
					'Minutos',
					'min',
					gettext('Minuto')
				)
			);

			$this->col		=['xs'=>23	, 'sm'=>5	, 'md'=>5	, 'lg'=>5	];
			$this->inputAno->col	=['xs'=>12	, 'sm'=>4	, 'md'=>4	, 'lg'=>4	];
			$this->inputsCols=['xs'=>6	, 'sm'=>2	, 'md'=>2	, 'lg'=>2	];
		}
		public function appendLBox($lBox)
		{
			parent::appendLBox($lBox);

			$lBox->setColRef($this->inputsCols);

			//$this->contenedor->appendChild
			return $this->appendChild
			(
				$lBox
			);

			//return $this;
		}
	}
?>