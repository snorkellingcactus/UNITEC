<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');

	function nTag($name)
	{
		global $con;
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php');

		$name=nTraduccion(filterTagName($name) , $_SESSION['lang']);
		$name->insSQL();
/*
		echo '<pre>nTag:';
		print_r
		(
			'	INSERT INTO Tags(NombreID)
				VALUES('.$name->ContenidoID.')
			'
		);
		echo '</pre>';
*/
		$con->query
		(
			'	INSERT INTO Tags(NombreID)
				VALUES('.$name->ContenidoID.')
			'
		);

		return $con->insert_id;
	}
	function getTagName( $id )
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
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
		if( isset( $nameID[0][0] ) )
		{
			return getTraduccion( $nameID[0][0] , $_SESSION['lang'] );
		}

		return false;
	}
	function getDuplicatedTag($name)
	{
		global $con;
/*
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
*/
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
			//echo '<pre>getDuplicatedTag: ';print_r('Ya existe un duplicado para '.$name.'.');echo '</pre>';
			return $duplicates[0][0];
		}
		else
		{
			//echo '<pre>getDuplicatedTag: ';print_r('NO existe un duplicado para '.$name.'.');echo '</pre>';
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
		print_r
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
			)
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
			//echo '<pre>isDuplicatedTagTarget: Ya existe un target con grupo "'.$tagsGrpID.'" e ID "'.$tagID.'"</pre>';
			return true;
		}
		//echo '<pre>isDuplicatedTagTarget: NO existe un target con grupo "'.$tagsGrpID.'" e ID "'.$tagID.'"</pre>';
		return false;
	}
	function nTagIfNot($name)
	{
		$tagID=getDuplicatedTag($name);
		if($tagID===false)
		{
			$tagID=nTag($name);
			//echo '<pre>nTagTarget: Nuevo Tag: '.$name.'</pre>';
		}
		else
		{
			//echo '<pre>nTagTarget: Ignorando Tag Duplicado: '.$name.'</pre>';
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
			'	INSERT INTO TagsGrp() VALUES()'
		);
		echo '</pre>';
*/
		$con->query
		(
			'	INSERT INTO TagsGrp() VALUES()
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
/*
			echo '<pre>nTagTarget: Insertando TagTarget: '.$name.'</pre>';
			echo '<pre>';
			print_r
			(
				'	INSERT INTO TagsTarget(TagID , GrupoID)
					VALUES('.$tagID.' , '.$grupoID.')
				'
			);
			echo '</pre>';
*/
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
		while( isset( $tags[$t] ) )
		{
			$tagName=filterTagName( $tags[$t] );
			if( !empty($tagName) )
			{
				nTagTarget( $tagName , $grupoID );
			}

			++$t;
		}
	}

	function getTagsNamesID( $tagsGrpID )
	{
		global $con;

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		return fetch_all
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
	}
	function tagsNamesIDToTrad($tagsNamesID)
	{
		//Revisar. Optimizar.
		$t=0;
		while( isset( $tagsNamesID[$t][0] ) )
		{
			$tagsNamesID[$t]=getTraduccion( $tagsNamesID[$t][0] , $_SESSION['lang'] );
			++$t;
		}

		return $tagsNamesID;
	}
	function getTagsNamesStr( $tagsGrpID )
	{
		return tagsNamesIDToTrad
		(
			getTagsNamesID($tagsGrpID)
		);
	}
	function getTagsStr($tagsGrpID)
	{
		
		$tagsNamesID=getTagsNamesStr( $tagsGrpID );

		sort( $tagsNamesID );

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
				//echo '<pre>Is Empty</pre>';
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
				WHERE TagsTarget.GrupoID= '.$tagsGrpID.'
				AND TagsTarget.TagID in
				(
					'.$orphanStr.'
				)
			'
		);
	}
	function getLabNameTreeLoop( $labID , &$array , $arrayLen )
	{
		getLabTreeLoop
		(
			$labID ,
			$array ,
			$arrayLen ,
			$field='Laboratorios.NombreID' ,
			$join=''
		);
	}
	function getLabIDTreeLoop( $labID , &$array , $arrayLen )
	{
		getLabTreeLoop
		(
			$labID ,
			$array ,
			$arrayLen ,
			$field='Laboratorios.ID' ,
			$join=''
		);
	}
	function getLabTagTreeLoop( $labID , &$array , $arrayLen )
	{
		getLabTreeLoop
		(
			$labID ,
			$array ,
			$arrayLen ,
			$field='Tags.NombreID' ,
			$join='
				LEFT OUTER JOIN Tags
				ON Tags.ID=Laboratorios.TagID
			'
		);
	}
	function getLabTreeLoop( $labID , &$array , $arrayLen , $field , $join )
	{
		global $con;

		$lab=fetch_all
		(
			$lab=$con->query
			(
				'	SELECT Laboratorios.PadreID , '.$field.'
					FROM Laboratorios'.$join.'
					WHERE Laboratorios.ID='.$labID.'
					LIMIT 1
				'
			),
			MYSQLI_NUM
		);

		if(isset($lab[0]))
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			$array[$arrayLen]=getTraduccion( $lab[0][1] , $_SESSION['lang'] );

			getLabTreeLoop( $lab[0][0] , $array , ++$arrayLen , $field , $join );
		}
	}
	function getLabTree( $labID , $which )
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		$array=array();

		//Revisar. A futuro crear una clase de utilidad con constantes para tag, name o ID.
		if( $which === 1 )
		{
			getLabTagTreeLoop	( $labID , $array , 0 );
		}
		if( $which === 2 )
		{
			getLabNameTreeLoop	( $labID , $array , 0 );
		}
		if( $which === 3 )
		{
			getLabIDTreeLoop	( $labID , $array , 0 );
		}

		return implode( ' , ' , $array );
	}
	function getLabNameTree( $labID )
	{
		return getLabTree( $labID , false );
	}
	function getLabTagTree( $labID )
	{
		return getLabTree( $labID , true );	
	}
	function isTagInSQLObj($tagsStr , $sqlObj)
	{
		$tags=$sqlObj->getTagsGrp();

		if( !isset( $tags[0][0] ) )
		{
			return false;
		}
		return strpos
		(
			$tagsStr,
			getTagsStr( $tags[0][0] )
		) !== false;
	}
	function hasSQLObjPriority($sqlObj , $lab)
	{
		global $con;
/*
		echo '<pre>hasSQLObjPriority: ';
		print_r
		(
			'	SELECT Prioridad
				FROM Prioridades
				WHERE LabID='.$lab.'
				AND GrupoID='.$sqlObj->PrioridadesGrpID.'
			'
		);
		echo '</pre>';
*/
		
		return isset
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT Prioridad
						FROM Prioridades
						WHERE LabID='.$lab.'
						AND GrupoID='.$sqlObj->PrioridadesGrpID.'
					'
				),
				MYSQLI_NUM
			)[0][0]
		);
	}
	function nPriorityGrp()
	{
		global $con;

		$con->query
		(
			'	INSERT INTO PrioridadesGrp()
				VALUES()
			'
		);
		return $con->insert_id;
	}
	function getSQLObjPriority($grupoID , $labID)
	{
		global $con;

		return fetch_all
		(
			$con->query
			(
				'	SELECT Prioridad
					FROM Prioridades
					WHERE GrupoID='.$grupoID.'
					AND LabID='.$labID.'
					LIMIT 1
				'
			),
			MYSQLI_NUM
		)[0][0];
	}
	function insertSQLObjPriority($grupoID , $labID , $priority)
	{
		global $con;

/*
		echo '<pre>insertSQLObjPriority:';
		print_r
		(
			'	INSERT INTO Prioridades(GrupoID , LabID , Prioridad)
				VALUES('.$grupoID.' , '.$labID.' , '.intVal(trim($priority)).')
			'
		);
		echo '</pre>';
*/
		$con->query
		(
			'	INSERT INTO Prioridades(GrupoID , LabID , Prioridad)
				VALUES('.$grupoID.' , '.$labID.' , '.intVal(trim($priority)).')
			'
		);
		return $con->insert_id;
	}
	function updSQLObjPriority($grupoID , $labID , $priority)
	{
		global $con;
		
		$con->query
		(
			'	UPDATE Prioridades set Prioridad='.$priority.'
				WHERE GrupoID='.$grupoID.'
				AND LabID='.$labID.'
			'
		);
	}
	function updTagsPriority($tagsStr , $nPriority , $sqlObj)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
		global $con;
		$tags=sepTagsStr($tagsStr);

		$k=0;
		while(isset($tags[$k]))
		{
			$tag=filterTagName($tags[$k]);

			$labID=getLabByName($tag);

			if(isset($labID[0]['ID']))
			{
				$labID=$labID[0]['ID'];

				if(!hasSQLObjPriority($sqlObj , $labID))
				{
					if($labID==$_SESSION['lab'])
					{
						$nVal=$nPriority;
					}
					else
					{
						$nVal=0;
					}

					//echo '<pre>Este elemento no tiene prioridad asignada. Creando una...</pre>';

					insertSQLObjPriority
					(
						$sqlObj->PrioridadesGrpID,
						$labID,
						$nVal
					);
				}
				else
				{
					//echo '<pre>Este elemento ya tiene una prioridad asignada. Se actualizará</pre>';

					if($labID==$_SESSION['lab'])
					{
						updSQLObjPriority
						(
							$sqlObj->PrioridadesGrpID,
							$labID,
							$nPriority
						);
					}
				}
			}
			++$k;
		}
	}
	function updLabsTagsPriority($tagsStr , $sqlObj , $condicion , $lugar , $discProp , $edita)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

		global $con;
		
		$tags=sepTagsStr($tagsStr);
/*
		echo '<pre>Exploded:';
		print_r($tags);
		echo '</pre>';
*/
		$k=0;
		while(isset($tags[$k]))
		{
			$tag=filterTagName($tags[$k]);

			$labID=getLabByName($tag);
/*
			echo '<pre>Lab:';
			print_r($labID);
			echo '</pre>';
*/
			if(isset($labID[0]['ID']))
			{
				$labID=$labID[0]['ID'];

				//echo '<pre>Tag '.$tag.' Is Lab '.$labID.'</pre>';

				if(!hasSQLObjPriority($sqlObj , $labID))
				{
					//echo '<pre>No Priority for this lab, creating new one</pre>';
					if($labID==$_SESSION['lab'])
					{
						$nVal=reordena
						(
							$lugar,
							$sqlObj,
							$condicion,
							$discProp,
							false,
							false
						);
					}
					else
					{
/*
						echo '<pre>GetMax:';
						print_r
						(
							'	SELECT IFNULL(MAX(Prioridad) , 0) AS Prioridad
								FROM Prioridades
								WHERE LabID='.$labID.'
							'
						);
						echo '</pre>';
*/
						$nVal=fetch_all
						(
							$con->query
							(
								'	SELECT IFNULL(MAX(Prioridad) , 0) AS Prioridad
									FROM Prioridades
									WHERE LabID='.$labID.'
								'
							),
							MYSQLI_NUM
						)[0][0]+1;
					}
					insertSQLObjPriority
					(
						$sqlObj->PrioridadesGrpID,
						$labID,
						$nVal
					);
				}
				else
				{
					//echo '<pre>NoLab';echo '</pre>';
					if($labID==$_SESSION['lab'] && $edita)
					{
						updSQLObjPriority
						(
							$sqlObj->PrioridadesGrpID,
							$labID,
							reordena
							(
								$lugar,
								$sqlObj,
								$condicion,
								$discProp,
								$sqlObj->$discProp,
								true
							)
						);
					}
				}
			}
			++$k;
		}
	}
?>