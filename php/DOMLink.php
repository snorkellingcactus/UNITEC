<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMLink extends DOMTag
	{
		public $url;
		public $name;
		public $opensNewWindow;
		public $offsetSuffix;
		public $accessKey;

		function __construct()
		{
			parent::__construct('a');

			$this->setOffsetSuffix('')->setOpensNewWindow( false )->setAccessKey(false);
		}
		function setUrl($url)
		{
			$this->url=$url;

			return $this;
		}
		function setName($name)
		{
			$this->name=$name;

			return $this;
		}
		function setOpensNewWindow($opensNewWindow)
		{
			$this->opensNewWindow=$opensNewWindow;

			return $this;
		}
		function setOffsetSuffix($offsetSuffix)
		{
			$this->offsetSuffix=$offsetSuffix;

			return $this;
		}
		function setAccessKey($accessKey)
		{
			$this->accessKey=$accessKey;

			return $this;
		}
		function renderChilds(&$tag)
		{
			$this->setAttribute
			(
				'href',
				$this->url
			);

			if(!empty($this->accessKey))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ShortcutSpan.php';

				$this->appendChild
				(
					new ShortcutSpan
					(
						$this->accessKey,
						$this->name
					)
				)->setAccessKey
				(
					$this->accessKey
				);
			}
			else
			{
				$this->setTagValue
				(
					$this->name
				);
			}

			if($this->accessKey!==false)
			{
				$this->setAttribute('accesskey' , $this->accessKey);
			}
			if($this->opensNewWindow!==false)
			{
				$span=new DOMTag
				(
					'span',
					sprintf
					(
						gettext('%s en una nueva ventana.'),
						$this->offsetSuffix
					)
				);
				$span->addToAttribute('class' , 'offscreen');

				$this->setAttribute('target' , '_blank')->appendChild
				(
					$span
				);
			}

			return parent::renderChilds($tag);
		}
	}
?>