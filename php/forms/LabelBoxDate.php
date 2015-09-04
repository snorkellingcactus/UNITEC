<?php	
	class LabelBoxDate extends DOMTag
	{
		public $label;
		public $input;

		function __construct($parentForm)
		{
			//$this->setTagName('div');

			parent::__construct('div');

			$args=func_get_args();

			$this->label=new FormLabel($args[3]);
			$this->input=new FormInput($parentForm , 'date');

			$this->input->setName($args[1])
			->setID($args[2])
			->appendLabel($this->label);


			$this->label->col=	['xs'=>12	, 'sm'=>12	, 'md'=>12	, 'lg'=>12	];
			$this->input->col=	['xs'=>12	, 'sm'=>12	, 'md'=>12	, 'lg'=>12	];
			$this->col=			['xs'=>3	, 'sm'=>3	, 'md'=>3	, 'lg'=>3	];

			$this->appendChild($this->label)->appendChild($this->input);
		}
	}
?>