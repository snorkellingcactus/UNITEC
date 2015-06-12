<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCfg.php';
	
	class FormSrvRecv extends FormCfg
	{
		public $referrer;

		function __construct($fId=NULL)
		{
			parent::__construct($fId);

			$this->checkAction();
			
			$this->referrer=$_SERVER['HTTP_REFERER'];

			$_SESSION['form']=$_POST['form'];

			if(isset($_POST['conID']))
			{
				$_SESSION['conID']=$_POST['conID'];
			}
			if(isset($_POST['Tipo']))
			{
				$_SESSION['Tipo']=$_POST['Tipo'];
			}

			if($_SESSION['accion']===$this->actions[2])
			{
				header('Location: '.$this->referrer);

				die();
			}
		}

		public function checkAction()
		{
			$this->checkActionIn($_POST);

			if($this->selectedAction)
			{
				$_SESSION['accion']=$this->actions[$this->selectedAction];
			}
		}

	}
?>