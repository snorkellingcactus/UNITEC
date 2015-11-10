<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Obj.php';

	class SQLTagged_Obj extends SQL_Obj
	{
		function __construct()
		{
			call_user_func_array
			(
				array('parent', '__construct'),
				func_get_args()
			);
		}
		function getTagsGrp()
		{
/*
			echo '<pre>getTagsGrp:';
			print_r
			(
						'	SELECT TagsGrpID
							FROM '.$this->table.'
							WHERE ID='.$this->ID
			);
			echo '</pre>';
*/
			return fetch_all
			(
				$this->con->query
				(
					'	SELECT TagsGrpID
						FROM '.$this->table.'
						WHERE ID='.$this->ID
				),
				MYSQLI_NUM
			);
		}
		function nTagsGrpIfNot()
		{
			//Revisar.
			$grupoID=$this->getTagsGrp();

			if(isset($grupoID[0][0]))
			{
				$grupoID=$grupoID[0][0];
			}
			else
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

				$grupoID=nTagsGrp();
			}

			$this->updSQL(['TagsGrpID'=>$grupoID]);

			return $grupoID;
		}
		function updTagsTargets($tagsTargetsNames)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			
			$grupoID=$this->nTagsGrpIfNot();
		
			nTagsTargets
			(
				$tagsTargetsNames,
				$grupoID
			);
			rmTagsOrphans($tagsTargetsNames , $grupoID);
		}
	}
?>