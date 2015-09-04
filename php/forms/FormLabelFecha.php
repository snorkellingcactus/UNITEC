<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBoxDate.php';

	class FormLabelFecha extends DOMTagContainer
	{
		public $inputDia;
		public $inputMes;
		public $inputAno;
		public $inputHora;
		public $inputMin;
		public $titulo;

		public function __construct($parentForm)
		{
			parent::__construct();
			
			$this->inputAno=new LabelBoxDate
			(
				$parentForm,
				'Ano',
				'ano',
				'Ano'
			);
			$this->inputMes=new LabelBoxDate
			(
				$parentForm,
				'Mes',
				'mes',
				'Mes'
			);
			$this->inputDia=new LabelBoxDate
			(
				$parentForm,
				'Dia',
				'dia',
				'Dia'
			);
			$this->inputHora=new LabelBoxDate
			(
				$parentForm,
				'Hora',
				'hora',
				'Hora'
			);
			$this->inputMin=new LabelBoxDate
			(
				$parentForm,
				'Minutos',
				'min',
				'Minutos'
			);

			$this->titulo=new DOMTag('h1' , 'Fecha');

			$this->inputDia->col=
			$this->inputMes->col=
			$this->inputMin->col=
			$this->inputHora->col=	['xs'=>2	, 'sm'=>2	, 'md'=>2	, 'lg'=>2	];

			$this->inputAno->col=	['xs'=>4	, 'sm'=>4	, 'md'=>4	, 'lg'=>4	];
			$this->titulo->col	=	['xs'=>12	, 'sm'=>12	, 'md'=>12	, 'lg'=>12	];

			$this->inputDia->label->classList->add('center');
			$this->inputMes->label->classList->add('center');
			$this->inputAno->label->classList->add('center');
			$this->inputMin->label->classList->add('center');
			$this->inputHora->label->classList->add('center');

			$this->titulo->classList->add('center');

			$this->appendChild($this->titulo)
			->appendChild($this->inputAno)
			->appendChild($this->inputMes)
			->appendChild($this->inputDia)
			->appendChild($this->inputHora)
			->appendChild($this->inputMin);
		}
	}
?>