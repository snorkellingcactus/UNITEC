<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class ShortcutSpan extends DOMTagContainer
	{
		public $char;

		function __construct($char , $str)
		{
			parent::__construct('span');

			$this->char=$char;
			$this->str=$str;

			//$this->classList->add('shortcutChar');
		}
		function addSpan($str)
		{
			return $this->appendChild
			(
				$this->newSpan
				(
					$str
				)
			);
		}
		function newSpan($str)
		{
			return new DOMTag
			(
				'span',
				$str
			);
		}
		function addShortcutSpan($str)
		{
			$span=$this->newSpan($str);

			$span->classList->add('shortcutSpan');

			return $this->appendChild($span);
		}
		function renderChilds(&$doc , &$tag)
		{
			$pos=strrpos
			(
				strtolower($this->str),
				strtolower($this->char)
			);

			if($pos===false)
			{
				$this->addSpan
				(
					$this->str
				);
			}
			else
			{
				if($pos!==0)
				{
					$this->addSpan
					(
						substr
						(
							$this->str,
							0,
							$pos
						)
					);
				}

				$this->addShortcutSpan
				(
					substr
					(
						$this->str,
						$pos,
						1
					)
				);

				if($pos!==strlen($this->str)-1)
				{
					$this->addSpan
					(
						substr
						(
							$this->str,
							$pos+1
						)
					);
				}

			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>