<?php
	//echo '<pre>Paso A</pre>';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormMenu.php';

	$this->form=new FormMenu($this , $this->contador);
?>