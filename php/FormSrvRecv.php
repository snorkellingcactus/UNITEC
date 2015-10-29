<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/FormCfg.php';
	
	class FormSrvRecv extends FormCfg
	{
		public $referrer;

		function __construct($fId=NULL)
		{
			parent::__construct($fId);

			$this->checkAction();
			
			if(!isset($_SESSION['referer']))
			{
				$_SESSION['referer']=$_SERVER['HTTP_REFERER'];
			}
			$this->referrer=$_SESSION['referer'];

			if(!isset($_SESSION['form']) || isset($_POST['form']))
			{
				$_SESSION['form']=$_POST['form'];
			}

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
				$this->redirect($this->referrer);
			}
		}
		public function redirect($url)
		{
			header('Location: '.$url);
			die();
		}
		public function checkAction()
		{
			if(!isset($_SESSION['accion']))
			{
				$this->checkActionIn($_POST);
			}
			else
			{
				$this->selectedAction=array_search($_SESSION['accion'], $this->actions);
			}

			if($this->selectedAction!==NULL)
			{
				$_SESSION['accion']=$this->actions[$this->selectedAction];
			}
		}

	}
?>