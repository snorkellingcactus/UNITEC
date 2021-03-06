<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class DOMRoleTag extends DOMTag
	{
		private $role;
		private $tabindex;
		private $hidden;

		function __construct()
		{
			call_user_func_array
			(
				[
					'parent',
					'__construct'
				],
				func_get_args()
			);

			$this->setRole(false)->setTabindex(false)->setHidden(false);
		}

		function setRole($role)
		{
			$this->role=$role;

			return $this;
		}
		function setHidden($hidden)
		{
			$this->hidden=$hidden;

			return $this;
		}
		function setTabindex($index)
		{
			$this->tabindex=$index;

			return $this;
		}
		function renderChilds(&$tag)
		{
			if($this->role!==false)
			{
				$this->setAttribute('role' , $this->role);
			}
			if($this->tabindex!==false)
			{
				$this->setAttribute('tabindex' , $this->tabindex);
			}
			if($this->hidden!==false)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/printBool.php';

				$this->setAttribute('aria-hidden' , printBool($this->hidden));
			}

			return parent::renderChilds($tag);
		}
	}
?>