<section id="gal">
	<?php
		$Img=
		[
			'http://www.nocturnar.com/imagenes/fotos/wallpapers-fondos-de-pantalla-wallpaper-wallpaper-lampadas-wallpapers.jpg',
			'http://techbeasts.com/wp-content/uploads/2014/04/Wallpaper-HD.jpg',
			'http://wallpaperswide.com/download/ford_gt40_le_mans_1969-wallpaper-960x600.jpg',
			'http://cdn.wonderfulengineering.com/wp-content/uploads/2014/01/digital-wallpaper-1.jpg',
			'http://www.hdwallpapersinn.com/wp-content/uploads/2014/08/8589130446148-3d-view-abstract-blue-black-dark-cubes-reflections-wallpaper-hd.jpg',
			'http://www.hdwallpapers.in/walls/tron_lamborghini_aventador-HD.jpg'
		];
	
	class GalHTML=
	{
		$maxCols=10;
		$bootsTrap=[1,2,3,4]		// xs , sm , md , lg
		$imgLst=[];
		
		function __construct($imgLst)
		{
			$this->imgLst=$imgLst;
		}
		function gen()
		{
			$buff='';
			
			$bootStr="<div class='col-xs-".
					$bootsTrap[0]." col-sm-".
					$bootsTrap[1]." col-md-".
					$bootsTrap[2]." col-lg-".
					$bootsTrap[3]."'>";
			$iMax=$this->maxCols;
			$jMax=count($this->imgLst);
			$j=0;
			
			while($j<$jMax)
			{
				$buff=$buff."<div class='row'>".$bootStr;
				
				for($i=0;$i<$iMax;$i++)
				{
					$buff=$buf."<img>"
				}
				
				$buff=$buff.'</div>';
			}
		}
	}
		
		
		$kMax=count($Img);
		for($k=0;$k<)
		{
			
		}
	?>
</section>