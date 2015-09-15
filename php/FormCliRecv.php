<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/FormCfg.php';

	class FormCliRecv extends FormCfg
	{
		public $SQL_Evts;
		public $afectados;

		public function __construct()
		{
			parent::__construct();
			
			$this->SQL_Evts=false;
		}

		public function checks()
		{
			if
			(
				isset($_SESSION['form'])	&&
				$_SESSION['form']			==
				'acciones'.$this->fId			&&
				isset($_SESSION['accion'])
			)
			{
				if(isset($_POST['Continuar']) || $_SESSION['accion']==='elimina')
				{
					//echo '<pre>Eureka, rellenaron un form para acá';echo '</pre>';
					//Se rellenó el formulario correspondiente.
					//Includes generales.
					if(!$this->SQL_Evts!==false)
					{
						$this->afectados=$this->SQL_Evts->$_SESSION['accion']();
					}
/*
					echo '<pre>Afectados:';
					print_r($this->afectados);
					echo '</pre>';
*/
				}
				
				unset($_SESSION['conID']  , $_SESSION['form'] , $_SESSION['accion']);
			}
		}
	}
?>