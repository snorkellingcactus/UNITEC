<?php
/*
	include_once	$_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';

	$html=new HTMLUForms();

	echo $html->getHTML();
*/	
	include $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRouter.php';

	$formHandler=new SrvStepRouter();
?>