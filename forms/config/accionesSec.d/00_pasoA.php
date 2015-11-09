<?php

	if($this->getAction()===2)
	{
		$this->redirectToStepName('90_SQL_Evts.php');
	}
	if($this->getAction()!==3)
	{
		$this->redirectToStepN(1);
	}
	else
	{
		$this->redirectToStepName('20_configura.php');
	}
?>