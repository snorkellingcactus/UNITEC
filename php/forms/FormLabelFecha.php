<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBoxDate.php';

	class FormLabelBoxMultiple extends FormLabelBoxBase
	{
		public $lBoxList;
		public $lBoxListLen;
		public $contenedor;

		function __construct()
		{
			parent::__construct();

			$this->lBoxList=array();
			$this->lBoxListLen=0;

			$this->appendChild
			(
				$this->contenedor=new DOMTag('div')
			);

			$this->contenedor->col	=['xs'=>12	, 'sm'=>12	, 'md'=>12	, 'lg'=>12	];
		}

		//Revisar efectos secundarios de &
		function appendLBox($lBox)
		{
			//Quizá esto sea tarea del lBox...
			$lBox->input->addToAttribute
			(
				'aria-labelledby' ,
				$this->label->getIDReference()->getFormatted()
			);

			$lBox->col=['xs'=>6	, 'sm'=>2	, 'md'=>2	, 'lg'=>2	];

			$this->contenedor->appendChild($lBox);

			return $this;
		}
	}

	class FormLabelFecha extends FormLabelBoxMultiple
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
			parent::__construct();

			$this->setLabelName(gettext('Fecha'));
			$this->label->setID('fecha');

			//$this->label->addToAttribute('class' , 'left');
			
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
			$this->contenedor->addToAttribute('class' , 'FormDateCont');//ainer
		}
	}
?>