<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCfg.php';
	
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

			if(isset($_POST['lab']))
			{
				$_SESSION['lab']=$_POST['lab'];
			}
			
			if(!isset($_SESSION['form'])&&isset($_POST['form']))
			{
				$_SESSION['form']=$_POST['form'];
			}
			if(!isset($_SESSION['form']) && !isset($_POST['form']) && isset($_GET['form']))
			{
				$_SESSION['form']=addslashes($_GET['form']);
			}

			if(isset($_POST['conID']))
			{
				$_SESSION['conID']=$_POST['conID'];
			}
			if(isset($_POST['Tipo']))
			{
				$_SESSION['Tipo']=$_POST['Tipo'];
			}
		}
		public function redirect($url)
		{
			header('Location: '.$url);
			die();
		}
		public function checkAction()
		{
			if(isset($_SESSION['accion']))
			{
				$this->selectedAction=array_search($_SESSION['accion'], $this->actions);
			}
			
			$this->checkActionIn($_POST);
			
			if(isset($_GET['accion']))
			{
				$this->selectedAction=array_search($_GET['accion'], $this->actions);
			}

			if($this->selectedAction!==NULL)
			{
				$_SESSION['accion']=$this->actions[$this->selectedAction];
			}
		}
	}
?>