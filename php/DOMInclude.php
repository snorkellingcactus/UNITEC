<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMIncludeBase.php';

	// implements DomIncludeInterface;
	class DOMInclude extends DOMIncludeBase
	{
		private $filter_visible;
		private $filter_limit;
		private $admin_form;

		function __construct()
		{
			parent::__construct();

			$this->setAdminForm( false );
		}
		public function calcLimit()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';
					
			$limit=getValFromNombreID( 'limit' , $this->opcGrpID , $this->opcSetsID );

			if( $this->isLimited() && is_array( $limit ) && $limit[0]!=='0' )
			{
				$this->setLimit( $limit[0] );
				$this->setFilterLimit( ' LIMIT '.$limit[0] );
			}
			else
			{
				$this->setLimit( false );
				$this->setFilterLimit( false );
			}

			return $this;
		}
		private function setFilterVisible( $filterStr )
		{
			$this->filter_visible=$filterStr;
		}
		protected function getFilterVisible()
		{
			return $this->filter_visible;
		}
		private function setFilterLimit( $filterStr )
		{
			$this->filter_limit=$filterStr;
		}
		protected function getFilterLimit()
		{
			return $this->filter_limit;
		}

		protected function setAdminFormName( $formName )
		{
			if( isset( $_SESSION['adminID'] ) )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/'.$formName.'.php';
				
				$this->setAdminForm( new $formName() );

				$this->appendChild( $this->getAdminForm() );
				
				$this->setFilterVisible('');
			}
			else
			{
				$this->setFilterVisible(' AND Visible=1 ');
			}
		}
		protected function setAdminForm( $adminForm )
		{
			$this->admin_form=$adminForm;
		}
		public function getAdminForm()
		{
			return $this->admin_form;
		}
	}
?>