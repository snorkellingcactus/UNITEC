<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBox.php';

	class LabelBoxDate extends FormLabelBox
	{
		function __construct()
		{
			parent::__construct();

			$args=func_get_args();

			array_push
			(
				 $args,
				new FormInput('text')
			);

			call_user_func_array
			(
				array('parent', '__construct'),
				$args
			);

			$this->setDelegateRender(1);

			$this->label->setID($args[1]);

			$this->setBoxClassName('LabelBoxDate');

			$this->col=			['xs'=>6	, 'sm'=>2	, 'md'=>2	, 'lg'=>2	];
		}
	}
?>