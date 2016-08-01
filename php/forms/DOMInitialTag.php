<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagObjectBase.php';
	
	class DOMInitialTag extends DOMTagObjectBase
	{
		public $tag;
		function __construct()
		{
			parent::__construct();

			$domImp=new DOMImplementation();

			$this->tag = $domImp->createDocument(null, 'html', $domImp->createDocumentType('html') );
			$this->tag->xmlVersion='1.0';
			$this->tag->encoding='UTF-8';

			$this->tag=new DOMDocument('1.0' , 'UTF-8');
			$this->tag->preserveWhiteSpace=false;
			$this->tag->formatOutput=false;
			$this->tag->substituteEntities=true;
		}
	}
?>