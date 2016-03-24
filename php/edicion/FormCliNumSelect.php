<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

	class FormCliNumSelect extends FormSelect
	{
		function __construct()
		{
			parent::__construct();

			$this->setName('cantidad');

			for($i=1;$i<=20;$i++)
			{
				$this->addOption($this->newOption($i , $i));
			}
		}
	}
?>