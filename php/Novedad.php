<?php
class Novedad
{
	public $fecha;
	public $titulo;
	public $contenido;
	public $imagen;
	public $prioridad;

	public function __construct
	(
		$fecha=0,
		$titulo='Novedad',
		$contenido='<p>Demasiado viejo para morir joven.</p>',
		$imagen='http://www.wallpaperup.com/uploads/wallpapers/2013/05/09/83994/89244f2f548da3df6c8d5ea61c69d131.jpg',
		$prioridad=50
	)
	{
		$this->fecha=$fecha;
		$this->titulo=$titulo;
		$this->contenido=$contenido;
		$this->imagen=$imagen;
		$this->prioridad=$prioridad;
	}
};
?>