<?php
class Gal_HTML
{
	public	$maxCols=10;
	public	$minHeight=200;
	public	$minWidth=200;
	public	$width=500;
	public	$height=500;
	private	$bootsTrap=[12,6,4,3];		// xs , sm , md , lg
	public	$imgLst=[];
	
	function __construct($imgLst)
	{
		$this->imgLst=$imgLst;
	}
	function nImg($img)
	{
		$index=count($this->imgLst);
		$this->imgLst[$index]=$img;
	}
	function gen()
	{
		$buff='';
		
		$divIni=
			"<a class='col-xs-".
			$this->bootsTrap[0].' col-sm-'.
			$this->bootsTrap[1].' col-md-'.
			$this->bootsTrap[2].' col-lg-'.
			$this->bootsTrap[3]."' href=\"";
		$divFin='" width="'.$this->minWidth.'" height="'.$this->minHeight.'" /></a>';
		$iMax=$this->maxCols;
		$jMax=count($this->imgLst);
		$j=0;
		
		while($j<$jMax)
		{
			$buff=$buff."<div class='row'>";
			
			for($i=0;$i<$iMax;$i++)
			{
				if(isset($this->imgLst[$i]))
				{
					$buff=
						$buff.
						$divIni.
						$this->imgLst[$i]->Url.
						'" ><img src="'.
						$this->imgLst[$i]->Url.
						$divFin."\n";
				}
				++$j;
			}
			
			$buff=$buff.'</div>';
		}
			return $buff;
	}
	function minTam($width , $height)
	{
		$this->minWidth=$width;
		$this->minHeight=$height;
	}
}
?>