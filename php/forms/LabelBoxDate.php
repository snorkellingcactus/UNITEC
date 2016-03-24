<?php	
	class LabelBoxDate extends DOMTag
	{
		public $label;
		public $input;

		function __construct()
		{
			//$this->setTagName('div');

			parent::__construct('div');
			$this->classList->add('LabelBoxDate');

			$args=func_get_args();

			$this->label=new FormLabel($args[3]);
			$this->input=new FormInput( 'text');

			$this->input->setName($args[1])
			->setID($args[2])
			->appendLabel($this->label);

			$this->col=			['xs'=>6	, 'sm'=>2	, 'md'=>2	, 'lg'=>2	];

			$this->appendChild($this->label)->appendChild($this->input);
		}
	}
?>