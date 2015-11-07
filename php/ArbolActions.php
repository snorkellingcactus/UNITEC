<?php
	Interface ArbolActions
	{
		public function onNewNode();
		public function onNewChild($child , $newNode);
		public function onHasChilds($newChild , $newNode);
	}
?>