<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepCommon.php';
	
	class Duplicated_Shortcut extends SrvStepCommon
	{
		public $parentStr;

		public function onNew()
		{
			$this->parentStr='';
		}
		public function onEdit()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$this->parentStr=
			'
				AND Menu.SeccionID <> "'.
				fetch_all
				(
					$con->query
					(
						'	SELECT Secciones.HTMLID
							FROM Secciones
							WHERE Secciones.ID='.FormActions::getContentID()[0]
					),
					MYSQLI_NUM
				)[0][0].'"';
		}
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
				$atajoTxt=strtoupper
				(
					trim
					(
						$session->getLabel('Atajo')
					)
				);

				$msg=false;
				if($atajoTxt === 'I')
				{
					$msg=gettext
					(
						'El atajo especificado ( "%s" ) está reservado para el encabezado. Por favor ingrese uno distinto.'
					);
				}
				else
				{
					$atajo=fetch_all
					(
						$con->query
						(
							'	SELECT 1 FROM Menu
								LEFT OUTER JOIN TagsTarget
								ON TagsTarget.GrupoID=Menu.TagsGrpID
								LEFT OUTER JOIN Laboratorios
								ON Laboratorios.ID='.$_SESSION['lab'].'
								WHERE TagsTarget.TagID=Laboratorios.TagID
								AND Menu.Atajo="'.$atajoTxt.'"
							'.$this->parentStr
						),
						MYSQLI_NUM
					);

					if(isset($atajo[0][0]))
					{
						$msg=gettext
						(
							'El atajo especificado ( "%s" ) ya existe. Por favor ingrese uno distinto.'
						);
					}
				}

				if( $msg !== false )
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
								$msg,
								$atajoTxt
							)
						)
					)->setAction
					(
						$this->getRouter()->getHistoryPrevUrl()
					);

					echo $html->getHTML();
				}
			}

			if( $msg === false )
			{
				$this->getRouter()->redirectToStepName
				(
					'01_PasoA_SQLEvts.php'
				);
			}
		}
	}
?>