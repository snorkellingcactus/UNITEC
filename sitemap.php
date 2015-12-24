<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class SMapUrlSet extends DOMTagBase
	{
		public function __construct()
		{
			parent::__construct('urlset');

			$this->setAttribute
			(
				'xmlns',
				'http://www.sitemaps.org/schemas/sitemap/0.9'
			);
		}
		public function renderChilds(&$doc , &$tag)
		{
			//echo '<pre>SMapUrlSet::renderChilds';echo '</pre>';

			return parent::renderChilds($doc , $tag);
		}
	}

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagBase.php';
	class SMapUrl extends DOMTagBase
	{
		public $location;
		public $lastMod;
		public $chfreq;
		public $priority;

		function __construct($location)
		{
			parent::__construct('url');

			$this->location=$location;
			$this->lastMod=false;
			$this->chfreq=false;
			$this->priority=false;
		}
		public function setLastMod($date)
		{
			$this->lastMod=$date;

			return $this;
		}
		public function setChFreq($chfreq)
		{
			$this->chfreq=$chfreq;

			return $this;
		}
		public function setPriority($priority)
		{
			$this->priority=$priority;

			return $this;
		}
		public function renderChilds(&$doc , &$tag)
		{
			//echo '<pre>SMapUrl::renderChilds';echo '</pre>';

			$this->appendChild
			(
				new DOMTag
				(
					'loc',
					$this->location
				)
			);
			if($this->lastMod!==false)
			{
				$this->appendChild
				(
					new DOMTag
					(
						'lastmod',
						$this->lastMod
					)
				);
			}
			if($this->chfreq!==false)
			{
				$this->appendChild
				(
					new DOMTag
					(
						'changefreq',
						$this->chfreq
					)
				);
			}
			if($this->priority!==false)
			{
				$this->appendChild
				(
					new DOMTag
					(
						'priority',
						$this->priority
					)
				);
			}

			return parent::renderChilds($doc , $tag);
		}
	}
	class SMap extends DOMTagContainer
	{
		function __construct()
		{
			parent::__construct();

			$this->createDoc();
		}
		function load($load)
		{
			return $this->domDoc->load($load);
		}
		function save($path)
		{
			$this->buildDoc();

			return $this->domDoc->save($path);
		}
		function saveXML()
		{
			$this->buildDoc();

			return $this->domDoc->saveXML();
		}
	}


	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';
	global $con;
	detectLab();
	detectLang();
/*
	echo '<pre>';
	print_r($_SESSION['lab']);
	echo '</pre>';
*/
	$sitemap=new SMap();
	$urlSet=new SMapUrlSet();

	$url=new SMapUrl('http://'.$_SERVER['SERVER_NAME'].'/');

	$urlSet->appendChild($url);

	$tables=['Imagenes' , 'Novedades'];
	$urlNames=['galeria' , 'novedades'];
	$labs=fetch_all
	(
		$con->query
		(
			'	SELECT Laboratorios.*
				FROM Laboratorios
				WHERE 1
			'
		),
		MYSQLI_ASSOC
	);

	$j=0;
	while(isset($tables[$j]))
	{
		$tName=$tables[$j];
		$urlName=$urlNames[$j];

		$recLst=fetch_all
		(
			$con->query
			(
				'	SELECT '.$tName.'.* , Laboratorios.ID as LabID FROM '.$tName.'
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

			if(empty($rec['LabID']))
			{
				++$i;
				continue;
				$rec['LabID']=getDefaultLab()[0]['ID'];
			}

			$url='http://'.$_SERVER['SERVER_NAME'].'/espacios/'.strtolower(getLabName($rec['LabID'])).'/';

			if(isset($rec['Fecha']))
			{
				$rec['Fecha']=new DateTime(date($rec['Fecha']));
				$rec['Fecha']=$rec['Fecha']->format('Y-m-d');

				$url=$url.$urlName.'/'.$rec['Fecha'].'/';
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
			$url=new SMapUrl
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
	$sitemap->buildDoc();
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
		function __construct($content)
		{
			$this->content=$content;
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
				foreach($childs as $child)
				{

					if($child->nodeName!='#text')
					{
						$this->appendStartTag($child->nodeName , $tab);
					}
					else
					{
						$tab=substr($tab , 0 , -1);
					}
					

					$this->highlightLoop($child , $tab);

					if($child->nodeName!='#text')
					{
						$this->appendEndTag($child->nodeName , $tab);
					}
				}
			}
			else
			{
				if($content->nodeName!='#text')
				{
					$this->appendTag($content->nodeName , $content->nodeValue , $tab);
				}
				else
				{
					$tab=substr($tab , 0 , -1);
					$this->appendTagValue($content->nodeValue , $tab);
				}
			}
		}
		function appendTag($tName , $tValue , $tab)
		{
			$this->appendStartTag($tName , $tab);
			$this->appendTagValue($tValue , $tab);
			$this->appendEndTag($tName , $tab);
		}
		function appendTagValue($tValue , $tab)
		{
			return $this
			->append($tab."\t")
			->appendNodeContent($tValue)
			->newline();
		}
		function appendStartTag($tName , $tab)
		{
			return $this
			->append($tab)
			->appendTagOpener()
			->appendNodeName($tName)
			->appendTagCloser()
			->newline();
		}
		function appendEndTag($tName , $tab)
		{
			return $this
			->append($tab)
			->appendTagOpener()
			->appendNodeName($tName)
			->appendTagEndCloser()
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
		function appendTagEndCloser()
		{
			return $this->appendHighlight('/>' , '#007700');
		}
		function appendNodeName($str)
		{
			return $this->appendHighlight($str,'#0000BB');
		}
		function appendNodeContent($str)
		{
			$color='#FF8000';

			if(substr(trim($str) , 0 , 4)=='http')
			{
				$str='<a href="'.trim($str).'" target="_blank">'.$str.'</a>';

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
		function newline()
		{
			return $this->append("\n");
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/bootstrap.css" />
	</head>
	<body>
		<?php
			$jj=new Highlighter($sitemap);
			echo '<pre>';
			echo $jj->getHighlighted();
			echo '</pre>';
		?>
	</body>
</html>