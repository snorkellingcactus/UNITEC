<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SMapUrlMulti.php';

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