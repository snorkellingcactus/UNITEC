<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');

	function nTag($name)
	{
		global $con;
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php');

		$name=nTraduccion(filterTagName($name) , $_SESSION['lang']);
		$name->insSQL();

		echo '<pre>nTag:';
		print_r
		(
			'	INSERT INTO Tags(NombreID)
				VALUES('.$name->ContenidoID.')
			'
		);
		echo '</pre>';

		$con->query
		(
			'	INSERT INTO Tags(NombreID)
				VALUES('.$name->ContenidoID.')
			'
		);

		return $con->insert_id;
	}
	function getTagName($id)
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php');
		global $con;

		$nameID=fetch_all
		(
			$con->query
			(
				'	SELECT Tags.NombreID
					FROM Tags
					WHERE ID='.intVal($id)
			),
			MYSQLI_NUM
		);
		if(isset($nameID[0][0]))
		{
			return getTraduccion($nameID[0][0] , $_SESSION['lang']);
		}
		return false;
	}
	function getDuplicatedTag($name)
	{
		global $con;

		echo '<pre>getDuplicates: Consulta:';
		print_r
		(
			' 	SELECT Tags.ID
				FROM Tags
				LEFT OUTER JOIN Traducciones
				ON Traducciones.Texto="'.addslashes($name).'"
				WHERE Traducciones.ContenidoID=Tags.NombreID
				LIMIT 1
			'
		);
		echo '</pre>';

		$duplicates=fetch_all
		(
			$con->query
			(
				' 	SELECT Tags.ID
					FROM Tags
					LEFT OUTER JOIN Traducciones
					ON Traducciones.Texto="'.addslashes($name).'"
					WHERE Traducciones.ContenidoID=Tags.NombreID
					LIMIT 1
				'
			),
			MYSQLI_NUM
		);
/*
		echo '<pre>getDuplicates: $duplicates:';
		print_r
		(
			$duplicates
		);
		echo '</pre>';
*/
		if(isset($duplicates[0][0]))
		{
			return $duplicates[0][0];
		}
		else
		{
			return false;
		}
	}
	function isDuplicatedTagTarget($tagID , $tagsGrpID)
	{
		global $con;
/*
		echo '<pre>getDuplicatedTagTarget: Consulta:';
		print_r
		(
			'	SELECT 1
				FROM TagsTarget
				WHERE TagsTarget.TagID='.$tagID.'
				AND GrupoID='.$tagsGrpID.'
				LIMIT 1
			'
		);
		echo '</pre>';
*/
		if
		(
			isset
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT 1
							FROM TagsTarget
							WHERE TagsTarget.TagID='.$tagID.'
							AND GrupoID='.$tagsGrpID.'
							LIMIT 1
						'
					),
					MYSQLI_NUM
				)[0][0]
			)
		)
		{
			return true;
		}
		return false;
	}
	function nTagIfNot($name)
	{
		$tagID=getDuplicatedTag($name);
		if($tagID===false)
		{
			$tagID=nTag($name);
			echo '<pre>nTagTarget: Nuevo Tag: '.$name.'</pre>';
		}
		else
		{
			echo '<pre>nTagTarget: Ignorando Tag Duplicado: '.$name.'</pre>';
		}

		return $tagID;
	}
	function nTagsGrp()
	{
		global $con;
/*
		echo '<pre>nTagsGrp: Consulta:';
		print_r
		(
			'	INSERT INTO TagsGrp(ID) VALUES(NULL)'
		);
		echo '</pre>';
*/
		$con->query
		(
			'	INSERT INTO TagsGrp(ID) VALUES(NULL)
			'
		);
		return $con->insert_id;
	}
	function filterTagName($tagName)
	{
		return strtolower
		(
			preg_replace
			(
				"/\s+/",
				" ",
				trim($tagName)
			)
		);
	}
	function sepTagsStr($tagsStr)
	{
		return explode
		(
			',',
			$tagsStr
		);
	}
	
	function nTagTarget($name , $grupoID)
	{
		global $con;

		$tagID=nTagIfNot($name);

		if(!isDuplicatedTagTarget($tagID , $grupoID))
		{
			$con->query
			(
				'	INSERT INTO TagsTarget(TagID , GrupoID)
					VALUES('.$tagID.' , '.$grupoID.')
				'
			);
			//echo '<pre>nTagTarget: Insertado TagTarget: '.$name.'</pre>';
		}
		else
		{
			//echo '<pre>nTagTarget: Ignorando TagTarget duplicado: '.$name.'</pre>';
		}
	}
	function nTagsTargets($tags , $grupoID)
	{
		$tags=sepTagsStr($tags);

		$t=0;
		while(isset($tags[$t]))
		{
			$tagName=filterTagName($tags[$t]);
			if(!empty($tagName))
			{
				nTagTarget($tagName , $grupoID);
			}

			++$t;
		}
	}
	
	function getTagsStr($tagsGrpID)
	{
		global $con;

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		$tagsNamesID=fetch_all
		(
			$con->query
			(
				'	SELECT Tags.NombreID
					FROM TagsTarget
					LEFT OUTER JOIN Tags
					ON Tags.ID=TagsTarget.TagID
					WHERE TagsTarget.GrupoID='.$tagsGrpID
			),
			MYSQLI_NUM
		);
		//Revisar. Optimizar.
		$t=0;
		while(isset($tagsNamesID[$t][0]))
		{
			$tagsNamesID[$t]=getTraduccion($tagsNamesID[$t][0] , $_SESSION['lang']);
			++$t;
		}

		sort($tagsNamesID);

		return implode
		(
			' , ',
			$tagsNamesID
		);
	}
	function rmTagsOrphans($tagLst , $tagsGrpID)
	{
		global $con;
		$tagLst=sepTagsStr($tagLst);

		if(!isset($tagLst[0]))
		{
			return;
		}

		$tagLstStr='';
		$efectivo=false;
		$t=0;
		while(isset($tagLst[$t]))
		{
			$tagName=filterTagName($tagLst[$t]);

//			echo '<pre>TagName:"'.$tagName.'"</pre>';

			if(!empty($tagName))
			{
				if($efectivo)
				{
					$tagLstStr=$tagLstStr.' , ';
				}
				$efectivo=true;

				$tagLstStr=$tagLstStr.'"'.$tagName.'"';
			}
			else
			{
//				echo '<pre>Is Empty</pre>';
			}

			++$t;
		}
		if(empty($tagLstStr))
		{
			return;
		}
/*
		echo '<pre>rmTagOrphans: Consulta:';
		print_r
		(
			'	SELECT Tags.ID
				FROM Tags
				LEFT OUTER JOIN Traducciones
				ON Traducciones.Texto not in ('.$tagLstStr.')
				LEFT OUTER JOIN TagsTarget
				ON TagsTarget.TagID=Tags.ID
				WHERE Traducciones.ContenidoID=Tags.NombreID and TagsTarget.GrupoID='.$tagsGrpID.'
			'
		);
		echo '</pre>';
*/
		$orphans=fetch_all
		(
			$con->query
			(
				'	SELECT Tags.ID
					FROM Tags
					LEFT OUTER JOIN Traducciones
					ON Traducciones.Texto not in ('.$tagLstStr.')
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.TagID=Tags.ID
					WHERE Traducciones.ContenidoID=Tags.NombreID and TagsTarget.GrupoID='.$tagsGrpID.'
				'
			),
			MYSQLI_NUM
		);

		if(!isset($orphans[0][0]))
		{
			return;
		}

		$orphanStr='';
		$t=0;
		while(isset($orphans[$t][0]))
		{
			$tagName=$orphans[$t][0];

			if($t>0)
			{
				$tagName=','.$tagName;
			}
			$orphanStr=$orphanStr.$tagName;

			++$t;
		}
/*
		echo '<pre>rmTagOrphans: Huerfanos:';
		print_r($orphanStr);
		echo '</pre>';
*/
		$con->query
		(
			'	DELETE FROM TagsTarget
				WHERE TagsTarget.TagID in
				(
					'.$orphanStr.'
				)
			'
		);
	}
?>