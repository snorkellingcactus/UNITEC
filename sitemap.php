<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SMapUrl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SMapUrlSet.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SMap.php';
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';

	global $con;

	detectLang();
	detectLab();

	$sitemap=new SMap();
	$urlSet=new SMapUrlSet();

	$url=new SMapUrl('http://'.$_SERVER['SERVER_NAME'].'/');

	$urlSet->appendChild($url);

	$labs=fetch_all
	(
		$con->query
		(
			'	SELECT Laboratorios.NombreID
				FROM Laboratorios
				WHERE Enlace=1
			'
		),
		MYSQLI_NUM
	);
	$labsRef=array();

	$langs=fetch_all
	(
		$con->query
		(
			'	SELECT Lenguajes.Pais
				FROM Lenguajes
				WHERE 1
			'
		),
		MYSQLI_NUM
	);

	$i=0;
	while(isset($langs[$i]))
	{
		$sitemap->addLang
		(
			substr
			(
				$langs[$i][0],
				0,
				2
			)
		);

		++$i;
	}

//	$sitemap->appendUrlMulti('hola/mundo');
	//$sitemap->appendUrlMulti('un/recurso/copado');

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabUl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabLi.php';

	$mainUl=new DOMLabUl();

	$li=new DOMLabLi('Espacios' , 'red');
	$ulLabs=new DOMLabUl();

	$li->appendChild($ulLabs);
	$mainUl->appendNodo
	(
		$li
	)->classList->add('organigrama');

	$tables=['Imagenes' , 'Novedades'];
	$urlNames=['galeria' , 'novedades'];

	$i=0;
	while(isset($labs[$i]))
	{
		$labRef=& $labsRef[$labs[$i][0]];

		$name=$labRef[0]=getTraduccion
		(
			$labs[$i][0],
			$_SESSION['lang']
		);
		$url=$labRef[1]='espacios/'.rawurlencode
		(
			strtolower
			(
				$name
			)
		);

		$urlSet->appendChild
		(
			$sitemap->createUrlMulti
			(
				$url
			)
		);

		$liLab=new DOMLabLi($name , 'blue');

		$ulLabs->appendNodo
		(
			$liLab->setLink(getLabUrl($name))->setTarget
			(
				'_blank'
			)
		);

		$ul=new DOMLabUl();

		$j=0;
		while(isset($tables[$j]))
		{
			$li=new DOMLabLi($tables[$j] , 'colorD');

			$labRef[$j+3]=$ulSeccs=new DOMLabUl();

			$li->appendChild($ulSeccs);

			$ul->appendNodo($li);

			++$j;
		}

		if($j)
		{
			$liLab->appendChild($ul);
		}

		++$i;
	}

	$j=0;
	while(isset($tables[$j]))
	{
		$tName=$tables[$j];
		$urlName=$urlNames[$j];

		$recLst=fetch_all
		(
			$con->query
			(
				'	SELECT '.$tName.'.* , Laboratorios.NombreID as LabNameID
					FROM '.$tName.'
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID='.$tName.'.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.TagID=TagsTarget.TagID
					WHERE Visible=1
				'
			),
			MYSQLI_ASSOC
		);
/*
		echo '<pre>';
		print_r($recLst);
		echo '</pre>';
*/
		$i=0;
		while(isset($recLst[$i]))
		{
			$url='';
			$rec=$recLst[$i];

			if(isset($rec['Tiempo']))
			{
				$rec['Fecha']=$rec['Tiempo'];
			}
			if(isset($rec['NombreID']))
			{
				$rec['TituloID']=$rec['NombreID'];
			}
			$titulo='notitle';
			if(isset($rec['TituloID']))
			{
				$titulo=getTraduccion
				(
					$rec['TituloID'],
					$_SESSION['lang']
				);
			}

			if(empty($rec['LabNameID']))
			{
				++$i;
				continue;
			}

			$url=getLabUrl($labsRef[$rec['LabNameID']][0]);

			if(isset($rec['Fecha']))
			{
				$rec['Fecha']=new DateTime(date($rec['Fecha']));
				$rec['Fecha']=$rec['Fecha']->format('Y-m-d');

				$url=$url.'/'.$urlName.'/'.$rec['Fecha'].'/';
			}

			$url=$url.urlencode
			(
				str_replace
				(
					'/',
					' ',
					strtolower
					(
						$titulo
					)
				)
			).
			'-'.$rec['ID'];

			$ulSeccs=$labsRef[$rec['LabNameID']][$j+3];


			$li=new DOMLabLi( $titulo, 'colorC');
			
			$ulSeccs->appendNodo
			(
				$li->setLink($url)->setTarget('_blank')
			);

			$url=$sitemap->createUrlMulti
			(
					$url
			);

			if(isset($rec['Fecha']))
			{
				$url->setLastMod($rec['Fecha']);
			}

			$urlSet->appendChild
			(
				$url
			);

			++$i;
		}
		++$j;
	}

	$sitemap->appendChild($urlSet);
/*
	echo '<pre>Sitemap:';
	print_r
	(
		htmlentities
		(
			$sitemap->saveXML()
		)
	);
	echo '</pre>';
	*/
	//$sitemap->save($_SERVER['DOCUMENT_ROOT'] . '/sitemap.xml');
	class Highlighter
	{
		public $buff;
		public $content;
		public $num;

		function __construct($content)
		{
			$this->content=$content;
			$this->num=0;
		}
		function getHighlighted()
		{
			$this->buff='';

			$this->highlightLoop($this->content->domDoc , '');

			return $this->buff;
		}
		function highlightLoop($content , $tab)
		{
			$tab=$tab."\t";

			$childs=$content->childNodes;

			if(isset($childs->length) && $childs->length)
			{
				if($content->nodeName!='#document')
				{
					$this->appendStartTag($content , substr($tab , 0 , -1));
				}

				foreach($childs as $child)
				{
					$this->highlightLoop($child , $tab);
				}

				if($content->nodeName!='#document')
				{
					$this->newline();
					$this->appendEndTag($content->nodeName , substr($tab , 0 , -1));
				}
			}
			else
			{
				if($content->nodeName!='#text')
				{
					$this->appendTag($content ,  substr($tab , 0 , -1));
				}
				else
				{
					$tab=substr($tab , 0 , -2);

					if(!empty($content->nodeValue))
					{
						$this->appendTagValue($content , $tab);
					}
				}
			}
		}
		function appendAttribute($aName , $aValue)
		{
			$this->appendAttrName($aName)->appendAttrValue($aValue);
		}
		function appendAttributes($node)
		{
			$merge=[];
			$mergeLen=0;

			$xpath = new DOMXPath($this->content->domDoc);
			foreach( $xpath->query('namespace::*', $node) as $attrNode )
			{
				if($attrNode->nodeName==='xmlns')
				{
					$this->appendAttribute
					(
						$attrNode->nodeName,
						$attrNode->nodeValue
					);
				}
			}

			$attrs=$node->attributes;

			if(empty($attrs))
			{
				return $this;
			}

			foreach($attrs as $attr)
			{
				$this->appendAttribute
				(
					$attr->name,
					$attr->value
				);
			}

			return $this;
		}
		function appendAttrName($name)
		{
			return $this->appendHighlight
			(
				htmlentities
				(
					' '.$name.' = '
				),
				'green'
			);
		}
		function testURL($url)
		{
			if(substr(trim($url) , 0 , 4)=='http')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		function appendAttrValue($value)
		{
			if($this->testURL($value))
			{
				$value='<a href="'.htmlentities(trim($value)).'" target="_blank">'.$value.'</a>';

				$color='#FF8000';
			}
			return $this->appendHighlight
			(
				
				htmlentities('"').$value.htmlentities('" '),
				'orange'
			);	
		}
		function appendTag($tag , $tab)
		{
			$this->appendStartTag($tag , $tab);

			if(!empty($tag->value))
			{
				$this->appendTagValue($tag->nodeValue , $tab);
				$this->appendEndTag($tag->nodeName , $tab);
			}
		}
		function appendTagValue($tag , $tab)
		{
			$this->newline();
			return $this
			->append($tab."\t")
			->appendNodeContent($tag->nodeValue)
			;
		}
		function appendStartTag($tag , $tab)
		{
			$this->newline();
			
			$this
			->append($tab)

			->appendTagOpener()
			->appendNodeName($tag->nodeName)
			->appendAttributes($tag);

			if(empty($tag->nodeValue) || !isset($tag->childNodes->length))
			{
				$this->appendTagCloself();
			}
			else
			{
				$this->appendTagCloser();
			}
			
			return $this;
		}
		function appendEndTag($tName , $tab)
		{
			return $this
			->append($tab)
			->appendTagOpener()
			->appendHighlight('/' , '#007700')
			->appendNodeName($tName)
			->appendTagCloser()
			->newline();
		}
		function appendTagOpener()
		{
			return $this->appendHighlight('<' , '#007700');
		}
		function appendTagCloser()
		{
			return $this->appendHighlight('>' , '#007700');
		}
		function appendTagCloself()
		{
			return $this->appendHighlight('/>' , '#007700');
		}
/*
		function appendTagEndCloser()
		{
			return $this->appendHighlight('/>' , '#007700');
		}
*/		
		function appendNodeName($str)
		{
			return $this->appendHighlight($str,'#0000BB');
		}
		function appendNodeContent($str)
		{
			$color='#FF8000';

			if($this->testURL($str))
			{
				$str='<a href="'.htmlentities(trim($str)).'" target="_blank">'.$str.'</a>';

				$color='#FF8000';
			}
			return $this->appendHighlight($str , $color);
		}
		function appendHighlight($str , $color)
		{
			return $this->append('<span style="color:'.$color.'" >'.$str.'</span>');
		}
		function append($str)
		{
			$this->buff=$this->buff.$str;

			return $this;
		}
		function mkTab($q)
		{
			$tabs='';
			for($i=0;$i<$q;$i++)
			{
				$tabs=$tabs."\t";
			}
			return $tabs;
		}
		function appendNum()
		{
			$this->append('<span style=
				"
				bkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none
				-o-user-select: none;
				user-select: none;
				width:30px;
				display:block;
				float:left
				">'.++$this->num.'</span>');
		}
		function newline()
		{
			return $this->append("\n")->appendNum();
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/seccs/organigrama.css" />
		<link rel="stylesheet" type="text/css" href="/bootstrap.css" />
	</head>
	<body>
		<style>
			html body ul {display:block;}
			html body ul li{padding:0px;}
			*{padding:0px;}
			html body pre{display:block;width:100%;}
		</style>

		<?php
			echo $mainUl->getHTML();
/*
			$xsSchema=new XSSchema();

			$sitemap->appendChild
			(
				$xsSchema->appendChild
				(
					new XSImport
					(
						'http://www.sitemaps.org/schemas/sitemap/0.9',
						'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'
					)
				)->appendChild
				(
					new XSImport
					(
						'http://www.google.com/schemas/sitemap-image/1.1',
						'http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd'
					)
				)
			);
*/

			$sitemap->buildDoc();

			$jj=new Highlighter($sitemap);

			$sitemap->domDoc->formatOutput=1;

			echo '<pre>';
			echo htmlentities(highlight_string($sitemap->domDoc->saveXML()));
			//print_r($sitemap->domDoc);
/*			
			echo '<div>'.highlight_string('<?xml version="1.0" encoding="UTF-8"?>')."\n".'</div>';

			echo $jj->getHighlighted();
*/			
			echo '</pre>';
		
			//$sitemap->save("sitemap.xml");
		?>
	</body>
</html>