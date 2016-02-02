<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLang.php';

	class DOMLangUnitec extends DOMLang
	{
		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$lenguajes=fetch_all
			(
				$con->query
				(
					'	SELECT * , 
						CASE ID
						WHEN '.$_SESSION['lang'].' THEN 0
						ELSE 1 END AS ord
						FROM `Lenguajes`
						ORDER BY ord
					'
				),
				MYSQLI_ASSOC
			);

			$i=0;
			while(isset($lenguajes[$i]))
			{
				if($i===0)
				{
					$option=$this->newFirstOption($lenguajes[$i]);
				}
				else
				{
					$option=$this->newOption($lenguajes[$i]);
				}

				$this->addOption
				(
					$option
				);

				++$i;
			}
		}
	}
?>