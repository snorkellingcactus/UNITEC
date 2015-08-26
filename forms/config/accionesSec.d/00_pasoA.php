<?php
	//echo '<pre>Paso A</pre>';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSec.php';
	$this->form=new FormSec($this);
	//$bb->setName('Hola')->setValue('Mundo');
/*
	$bb=new DOMTagContainer();
	echo $bb->getHTML();
	
	$jj=new DOMTag('Hola' , 'mundo');
	$jj->classList->add('hola');
	$jj->col['xs']=12;

	$hh=new DOMTag('input');
	$hh->classList->add('inputeable');
	$hh->col['xs']=6;
	$hh->setAttribute('type' , 'radio');

	$bb->appendChild($jj);
	$jj->appendChild($hh);
	
	echo $bb->getHTML();
	*/
	
?>