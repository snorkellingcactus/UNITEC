
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Requirer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/Indexable.php';

	class DOMLabelsCollection extends Requirer implements Indexable
	{
		private $index;
		public $contentID;
		private $session;
		private $formName;

		function __construct(&$index)
		{
			parent::__construct();

			$this->session=false;
			
			$this->contentID=false;

			$this->setIndex($index);

			if(isset($_SESSION['form']))
			{
				$this->formName=$_SESSION['form'];
			}
			else
			{
				$this->formName='TheUnknownForm';
			}
		}

		public function renderChilds(&$tag)
		{
			if($this->formName!==false)
			{
				$this->createSession($this->formName);
				$this->session->load();
			}

			$this->formName=false;

			parent::renderChilds($tag);

			if($this->session!=false)
			{
				$this->session->save();
			}
		}
		public function setFormName($formName)
		{
			$this->formName=$formName;
		}
		public function setIndex(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			
			$contentID=FormActions::getContentID();

			$j=$this->index;

			if ( $contentID!==false )
			{
				if($j != $index)
				{
					while($j != $index)
					{
						if($j<$index)
						{
							next($contentID);

							++$j;
						}
						else
						{
							prev($contentID);

							--$j;
						}
					}

					$this->contentID=current($contentID);
				}
				else
				{
					if($this->contentID===false)
					{
						$this->contentID=current($contentID);
					}
				}
			}

			$this->index=&$index;
/*
			echo '<pre>'.get_class($this).'::setIndex('.$index.')'."\n";
			echo debug_print_backtrace();
			echo '</pre>';
*/
			return $this;
		}
		public function getContentID()
		{
			return $this->contentID;
		}
		private function isIndexable($child)
		{
			return $child instanceof Indexable;
		}
		private function getInputFromChild($child)
		{
			if($child instanceof FormLabelBox)
			{
				return $child->input;
			}
			else
			{
				if($child instanceof FormInputBase)
				{
					return $child;
				}
				else
				{
					return false;
				}
			}
		}
		private function getLabelFromChild($child)
		{
			if($child instanceof FormLabelBoxBase)
			{
				return $child->label;
			}

			return false;
		}
		public function registerChildField($input)
		{
			$name=$input->getName();

			$session=&$this->session;

			$session->loadLabel($name);

			//Revisar.
			if($session->hasLabel($name))
			{
				if( isset($input->controller) )
				{
					$input->controller->setValueToSelect
					(
						$session->getLabel($name)
					);	
				}
				else
				{
					$input->setValue
					(
						$session->getLabel($name)
					);
				}
			}
		}
		public function renderChild( &$child )
		{
			if($this->session !== false)
			{
				$indexable=$this->isIndexable($child);

				if($indexable===true)
				{
					$child->setIndex($this->index);
				}

				$input=$this->getInputFromChild($child);

				if($input!==false)
				{
					$this->registerChildField($input);
				}
			}

			parent::renderChild($child);
		}
		public function DOMAppendChild($child)
		{
			if($this->session !== false)
			{
				$input=$this->getInputFromChild($child);

				if($input!==false)
				{
					$name=$input->getName();

					$session=&$this->session;

					$session->loadLabel($name);

					if( isset($input->controller) )
					{
						$session->setLabel
						(
							$name ,
							$input->controller->getValue()
						);
					}
					else
					{
						$session->setLabel
						(
							$name ,
							$input->getValue()
						);
					}
				}
			}
			else
			{
				echo '<pre>No Session';
				echo '</pre>';
			}
			
			parent::DOMAppendChild($child);
		}
		public function appendChild($child)
		{
			$input=$this->getInputFromChild($child);

			if($input!==false)
			{
				$input->setIndex($this->index);
				$input->col=
				[
					'xs'=>12,
					'sm'=>12,
					'md'=>12,
					'lg'=>12
				];

				$label=$this->getLabelFromChild($child);

				if($label!==false)
				{
					$label->col=
					[
						'xs'=>12,
						'sm'=>5,
						'md'=>5,
						'lg'=>5
					];
				}
			}

			return parent::appendChild($child);
		}

		public function getSession()
		{
			return $this->session;
		}
		private function newSession()
		{
			return new FormSession();
		}
		public function createSession($formName)
		{
			$this->session=$this->newSession()->setFormName($formName);
			$this->session->setIDSuffix($this->index);
		}
	}
?>