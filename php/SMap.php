<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SMapUrlMulti.php';

	class XSSchema extends DOMTag
	{
		function __construct()
		{
			parent::__construct('xs:schema');

			$this->setAttribute('xmlns:xs' , 'http://www.w3.org/2001/XMLSchema');
		}
	}

	class XSImport extends DOMTag
	{
		function __construct($nspace , $sloc)
		{
			parent::__construct('xs:import');

			$this->setAttribute
			(
				'namespace',
				$nspace
			)->setAttribute
			(
				'schemaLocation',
				$sloc
			);
		}
	}

	class SMap extends DOMTagContainer
	{
		public $baseURL;
		public $langs;

		function __construct()
		{
			parent::__construct();

			$this->setBaseURL('http://'.$_SERVER['SERVER_NAME'].'/');
			$this->langs=[];

			$this->createDoc();
		}
		function setBaseURL($url)
		{
			$this->baseURL=$url;
		}
		function addLang($lName)
		{
			$this->langs[count($this->langs)]=$lName;
		}
		function createUrlMulti($resource)
		{
			return new SMapUrlMulti($this->baseURL , $this->langs , $resource);
		}
		function load($load)
		{
			return $this->domDoc->load($load);
		}
		function save($path)
		{
			$this->buildDoc();

			return $this->domDoc->save($path);
		}
		function saveXML()
		{
			$this->buildDoc();

			return $this->domDoc->saveXML();
		}
	}
?>