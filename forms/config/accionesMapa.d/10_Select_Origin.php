<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepCommon.php';

	class Select_Origin extends SrvStepCommon
	{
		function onNew()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMapa.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormBaseCommon.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';

			$form=new SrvFormBaseCommon();
			
			$html=new HTMLUForms();
			$html->head_include( '/seccs/contacto.css' );
			$html->setAttribute( 'id' , 'gmapsDiag' );

			$html->appendChild
			(
				$form->appendChild
				(
					new LabelsMapa()
				)->setAction
				(
					$this->getRouter()->getStepUrlByName
					(
						'00_pasoA.php'
					)
				)
			);

			echo $html->getHTML();
		}
	}

?>