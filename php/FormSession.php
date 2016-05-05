<?php
	class FormSession
	{
		private $formName;
		private $data;
		private $idSuffix;

		private $vPressed;
		private $cPressed;

		public function __construct()
		{
			$this->data=array();

			if(isset($_SESSION['form']))
			{
				$this->setFormName($_SESSION['form']);
			}
			else
			{
				$this->setFormName('TheUnknownForm');
			}

			$this->setIDSuffix(0);
/*
			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setIDSuffix($args[0]);
			}
*/			

		}

		public function volverPressed()
		{
			return $this->vPressed;
		}
		public function continuarPressed()
		{
			return $this->cPressed;
		}

		public function setIDSuffix($idSuffix)
		{
			//$this->saveToSession();

			$this->idSuffix=$idSuffix;

			//Revisar. Posible automatizacion: Si falla al cargar la sesion, que la guarde.
			return $this->load();
		}
		public function getFormName()
		{
			return $this->formName;
		}
		public function setFormName($formName)
		{
			$this->formName=$formName;

			return $this;
		}
		public function save()
		{
			if(!empty($this->data))
			{
				if(!isset($_SESSION[$this->formName]))
				{
					$_SESSION[$this->formName]=array();
				}

				$_SESSION[$this->formName][$this->idSuffix]=&$this->data;
			}

			return $this;
		}
		public function load()
		{
			if(empty($_SESSION[$this->formName][$this->idSuffix]))
			{
				return false;
			}

			$this->data=&$_SESSION[$this->formName][$this->idSuffix];

			return $this;
			
		}
		public function tryLoadLabel($methodVar , $labelName)
		{
			if(isset($methodVar[$labelName]))
			{
				$this->data[$labelName]=$methodVar[$labelName][$this->idSuffix];

				//echo '<pre>Loaded '.$this->data[$labelName];echo '</pre>';

				return true;
			}

			return false;
		}
		public function loadLabel($labelName)
		{
			if($this->tryLoadLabel($_POST , $labelName))
			{
				//echo '<pre>Try load '.$labelName.' on $_POST';echo '</pre>';
				return;
			}
			if($this->tryLoadLabel($_GET , $labelName))
			{
				//echo '<pre>Try load '.$labelName.' on $_GET';echo '</pre>';
				return;
			}
			if($this->tryLoadLabel($_SESSION , $labelName))
			{
				//echo '<pre>Try load '.$labelName.' on $_SESSION';echo '</pre>';
				return;
			}
		}
		public function loadLabels()
		{
			$args=func_get_args();
			$i=0;

			while(isset($args[$i]))
			{
				++$i;

				$this->loadLabel($args[$i]);
			}
		}
		public function autoloadLabels()
		{
			$data=$this->data;
			foreach($data as $name=>$value)
			{
				$this->loadLabel($name);
			}
		}
		public function hasLabel($name)
		{
			return isset($this->data[$name]);
		}
		public function getLabel($name)
		{
/*
			ob_start();
			var_dump($this->data[$name]);
			$debug=ob_get_contents();
			ob_end_clean();


			echo '<pre>'.'$_SESSION['.$this->formName.']['.$this->idSuffix.']['.$name.']? = '.$debug.'</pre>';
*/
			return $this->data[$name];
		}
		public function setLabel($name , $value)
		{
/*
			ob_start();
			var_dump($value);
			$debug=ob_get_contents();
			ob_end_clean();


			echo '<pre>'.'$_SESSION['.$this->formName.']['.$this->idSuffix.']['.$name.'] = '.$debug.'</pre>';
*/
			$this->data[$name]=$value;

			return $this;
		}
	}
?>