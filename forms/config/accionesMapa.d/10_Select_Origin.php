<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepCommon.php';

	class Select_Origin extends SrvStepCommon
	{
		function onNew()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMapa.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvForm.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';

			$form=new SrvForm();
			
			$html=new HTMLUForms();
			$html->head_include( '/seccs/contacto.css' );
			$html->addToAttribute( 'class' , 'MapsSelOrigin' );

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
				)->setMethod
				(
					'GET'
				)
			);

			echo $html->getHTML();
		}
	}

?>