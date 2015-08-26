<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

class FormRadio extends FormInput
{
	function __construct($parentForm, $name , $value)
	{
		parent::__construct($parentForm , 'radio');

		$this->multi=false;
		$this->setName($name);
		$this->setValue($value);
	}
	function setChecked()
	{
		$this->setAttribute('checked' , 'checked');
	}
}
class FormCheckBoxLst extends DOMTagContainer
{
	public $lst;
	public $lstLen;
	public $default;
	public $selectedValue;
	public $name;
	public $parentForm;

	function __construct($parentForm , $name)
	{
		parent::__construct();

		$this->lst=[];
		$this->lstLen=0;
		$this->default=false;
		$this->selectedValue=NULL;
		$this->parentForm=$parentForm;
	}
	function setName($name)
	{
		$this->name=$name;

		return $this;
	}
	function add($name , $value)
	{
		if($this->selectedValue===$value)
		{
			$this->default=$this->lstLen;
		}

		$checkBox=$this->buildNew($name , $value);

		$this->appendTag($checkBox);
		$this->lst[$this->lstLen]=$checkBox;

		++$this->lstLen;
	}
	function buildNew($value)
	{
		return new FormRadio($this->parentForm , $this->name , $value);
	}
	function select($index)
	{
		$this->lst[$index]->setSelected();
	}
	function renderChilds()
	{
		if($this->default===false)
		{
			$this->select(0);
		}
		else
		{
			$this->select($this->default);
		}

		return parent::renderChilds();
	}
}

?>