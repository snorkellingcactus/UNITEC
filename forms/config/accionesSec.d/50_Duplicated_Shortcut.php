<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepCommon.php';
	
	class Duplicated_Shortcut extends SrvStepBase
	{
		public function OnSetRouter()
		{
			parent::OnSetRouter();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';

			$session=new FormSession();
			$session->autoloadLabels();
			$session->save();

			global $con;

			$shouldRedirect=true;

			if( !$session->emptyTrimLabel( 'Atajo' ) )
			{
				$atajoTxt=trim
				(
					strtolower
					(
						$session->getLabel('Atajo')
					)
				);

				$atajo=fetch_all
				(
					$con->query
					(
						
						'	SELECT	1
							FROM	Menu
							WHERE	Atajo = "'.$atajoTxt.'"
						'
					),
					MYSQLI_NUM
				);

				if(isset($atajo[0][0]))
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormBaseCommon.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';

					$html=new HTMLUForms();

					$html->appendChild
					(
						$form=new SrvFormBaseCommon()
					);

					$form->appendChild
					(
						new MSGBox
						(
							sprintf
							(
								gettext
								(
									'El atajo especificado ( "%s" ) ya existe. Por favor intente con otro.'
								),
								$atajoTxt
							)
						)
					)->setAction
					(
						$this->getRouter()->getHistoryPrevUrl()
					);

					$shouldRedirect=false;

					echo $html->getHTML();
				}
			}

			if( $shouldRedirect )
			{
				$this->getRouter()->redirectToStepName
				(
					'01_PasoA_SQLEvts.php'
				);
			}
		}
	}
?>