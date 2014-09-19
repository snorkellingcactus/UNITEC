<?php
class Novedad_HTML
{
	public $novedad;
	public $imgWidth	=	200;
	public $imgHeight	=	200;

	public function __construct($novedad)
	{
		$this->novedad=$novedad;
	}

	public function gen()
	{
		$buff=
		'<div><h2>'.
		$this->novedad->titulo.
		' <span>'.
		$this->novedad->fecha.
		'</span></h2><img src="'.
		$this->novedad->imagen.
		'" width="'.
		$this->imgWidth.
		'" height="'.
		$this->imgHeight.
		'" /><div>'.
		$this->novedad->contenido.
		'</div></div>';

		return $buff;
	}
};  
 ?>