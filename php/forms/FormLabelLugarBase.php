<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';

	class FormLabelLugarBase extends LabelBox
	{
		public $sqlList;

		function __construct()
		{
			call_user_func_array
			(
				array('parent' , '__construct'),
				func_get_args()
			);

			$this->sqlList=false;
		}
		function buildOptionFromArray($array)
		{
			if(!isset($array[0]))
			{
				$array[0]=NULL;
			}
			if(!isset($array[1]))
			{
				$array[1]=NULL;
			}

			return $this->input->buildOption
			(
				html_entity_decode($array[0]),
				$array[1]
			);
		}
		//Configura las opciones de acuerdo a los lugares llenos.
		function setOptionsFromSQLRes($sqlList)
		{
			$this->sqlList=$sqlList;
		}
		function renderChilds(&$tag)
		{
			$i=0;
			$input=$this->input;
			while(isset($this->sqlList[$i]))
			{
				$input->addOption
				(
					$this->buildOptionFromArray($this->sqlList[$i])
				);

				++$i;
			}

			parent::renderChilds($tag);
		}
	}
?>