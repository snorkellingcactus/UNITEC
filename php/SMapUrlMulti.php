<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SMapUrl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SMapXHTMLLink.php';

	class SMapUrlMulti extends SMapUrl
	{
		public $baseURL;
		public $langs;
		public $resource;

		function __construct($baseURL , $langs , $resource)
		{
			parent::__construct($baseURL.$langs[0].'/'.$resource);

			$this->baseURL=$baseURL;
			$this->langs=$langs;
			$this->resource=$resource;
		}
		
		function renderChilds(&$doc , &$tag)
		{
			$i=0;
			while(isset($this->langs[$i]))
			{
				$lang=$this->langs[$i];

				$this->appendChild
				(
					new SMapXHTMLLink
					(
						$lang,
						$this->baseURL.$lang.'/'.$this->resource
					)
				);

				++$i;
			}

			//echo '<pre>SMapUrlMulti::renderChilds';;echo '</pre>';
			return parent::renderChilds($doc , $tag);
		}

	}
?>