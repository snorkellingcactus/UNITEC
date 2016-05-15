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
			//echo '<pre>new '.get_class($this).'</pre>';

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
		public function getNextIDSuffix()
		{
			return each($_SESSION[$this->formName])['key'];
		}
		public function setIDSuffix($idSuffix)
		{
			//echo '<pre>'.get_class($this).'::setIDSuffix('.$idSuffix.')';echo '</pre>';

			if($idSuffix !== $this->idSuffix)
			{
				//echo '<pre>'.get_class($this).' Different from previous. Saving data:';print_r($this->data);echo '</pre>';

				$this->save();

				unset($this->data);

				$this->data=array();
			}

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
			//echo '<pre>Trying to load $_SESSION['.$this->formName.']['.$this->idSuffix.']'."\n";echo '</pre>';
			if
			(
				empty($_SESSION[$this->formName][$this->idSuffix])
			)
			{
				//echo '<pre>$_SESSION['.$this->formName.']['.$this->idSuffix.'] wont exists</pre>';
				return false;
			}

			$this->data=&$_SESSION[$this->formName][$this->idSuffix];

			//echo '<pre>Loaded data:';print_r($this->data);echo '</pre>';

			return $this;
			
		}
		public function tryLoadLabel($methodVar , $labelName)
		{
//			echo '<pre>';print_r('Trying to load '.$labelName.'['.$this->idSuffix.']');echo '</pre>';
			if(isset($methodVar[$labelName][$this->idSuffix]))
			{
				$this->data[$labelName]=$methodVar[$labelName][$this->idSuffix];

//				echo '<pre>Loaded '.$labelName.'['.$this->idSuffix.'] = '.$this->data[$labelName];echo '</pre>';

				return true;
			}
//			echo '<pre>Not loaded</pre>';

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
				$this->loadLabel($args[$i]);

				++$i;
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
		public function emptyTrimLabel($name)
		{
			if( $this->hasLabel($name) )
			{
				return empty
				(
					trim
					(
						$this->getLabel($name)
					)
				);
			}

			return true;
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