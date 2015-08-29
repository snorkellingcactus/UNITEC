<?php
	//echo '<pre>Paso A</pre>';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormNov.php';

	$this->form=new FormNov($this , $this->contador);
?>