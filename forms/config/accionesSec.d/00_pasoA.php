<?php

	if($this->getAction()!==3)
	{
		$this->redirectToStepN(1);
	}
	else
	{
		$this->redirectToStepName('20_configura.php');
	}
?>