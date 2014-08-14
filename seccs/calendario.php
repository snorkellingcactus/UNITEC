<?php
/*:::::::::::RECORDATORIO::::::::::
"seconds"
"minutes"
"hours"
"mday"
"wday"
"mon"
"year"
"yday"
"weekday"
"month"
:::::::::::::::::::::::::::::::::*/
//::::Variables Globales::::
global $Cal_Dias,$Cal_Meses,$Cal_Fecha	;

class Evento
{	
	function __construct($fecha , $desc , $titulo)
	{
		$this->setFecha($fecha);
		$this->setDesc($desc);
		$this->setTitulo($titulo);
	}
	function setFecha($fecha)
	{
		$this->fecha=$fecha;
	}
	function setDesc($desc)
	{
		$this->desc=$desc;
	}
	function setTitulo($titulo)
	{
		$this->titulo=$titulo;
	}
}
class Cal_Cfg
{
	public $fecha;
	public $eventos;

	public $tipo	=	CAL_GREGORIAN;
	public $dias	=	["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes", "Sabado"];
	public $meses	=
	[
	"Enero"		,	"Febrero"	,	"Marzo"		,	"Abril"		,
	"Mayo"		,	"Junio"		,	"Julio"		,	"Agosto"	,
	"Septiembre"	,	"Octubre"	,	"Noviembre"	,	"Diciembre"
	];

	function __construct()
	{
		$this->fecha	=	getdate();
		

		$args=func_get_args();			//Array con argumentos.
		//El primer argumento es la fecha en que se basa el calendario.
		if(count($args))
		{
			$this->fecha=$args[0];
		}
	}
	function nEvento($evento)
	{
		$last=count($this->eventos);
		$this->eventos[$last]=$evento;
	}
}
class Cal_Gen_HTML
{
	public $cfg;
	public $fecha;
	public $diasAnt;
	public $diasMesAct;
	public $diasMesAnt;

	public $celdasMax;
	public $celdasMin;
	public $filas=5;			//Cantidad de filas por de fecto (7x5=35).

	function calcCeldas()
	{
		$args=func_get_args();
		$this->celdasMax=$this->filas*7;		//Máximo de celdas que aparentemente se van a mostrar.
		$this->filas=5;

		//Cantidad dias mostrados anteriores al mes:
		$this->diasAnt=getdate
		(
			mktime
			(
				0,
				0,
				0,
				$this->fecha["mon"],
				0,
				$this->fecha["year"]
			)
		)["wday"]+1;
		//Cantidad dias mes actual:
		$this->diasMesAct=cal_days_in_month
		(
			$this->cfg->tipo ,
			$this->fecha["mon"],
			$this->fecha["year"]
		);
		//Cantidad dias mes anterior:
		$this->diasMesAnt=cal_days_in_month
		(
			$this->cfg->tipo ,
			$this->fecha["mon"],
			$this->fecha["year"]
		);

		//Si se pasa un argumento, se trata de el número de filas.
		if(count($args) && $args[0]>5)
		{
			$this->filas=$args[0];
		};
		
		$this->celdasMin=$this->diasMesAct+$this->diasAnt;	//Cantidad celdas necesarias para mostrar todo el mes.
		$this->celdasMax=$this->filas*7;					//Actualizo el máximo de celdas.

		//Si el mes tiene 31 o más dias necesito minimo 6 filas.
		if($this->celdasMin>$this->celdasMax)
		{
			$this->filas=6;
		}
	}
	//Setea el mes si se le pasa un argumento, sino lo devuelve.
	function mes()
	{
		$args=func_get_args();
		if(count($args))
		{
			$this->fecha=getdate
			(
				mktime
				(
					$this->fecha["hours"],
					$this->fecha["minutes"],
					$this->fecha["seconds"],
					$args[0],
					$this->fecha["mday"],
					$this->fecha["year"]
				)
			);
			//Refresca cálculos.
			$this->calcCeldas();
		}
		else
		{
			return $this->cfg->meses
			[
				$this->fecha["mon"]-1
			];
		}
	}
	//Setea el año si se le pasa un argumento, sino lo devuelve.
	function ano()
	{
		$args=func_get_args();
		if(count($args))
		{
			$this->fecha=getdate
			(
				mktime
				(
					$this->fecha["hours"],
					$this->fecha["minutes"],
					$this->fecha["seconds"],
					$this->fecha["mon"],
					$this->fecha["mday"],
					$args[0]
				)
			);
			//Refresca cálculos.
			$this->calcCeldas();
		}
		else
		{
			return $this->fecha["year"];
		}
	}

	//Genera las celdas para el <thead>
	function genThead()
	{
		$buff	=
		"
		<tr>
			<th colspan='7'>
			"
				.$this->mes().
			"</th>
		</tr>
		<tr>\n";		//Donde se va a almacenar el resultado.
	
		for($i=0;$i<count($this->cfg->dias);$i++)
		{
			$buff=$buff.
			"<th>"
			.substr
			(
				$this->cfg->dias[$i],
				0,
				2
			).
			"</th>\n";
		};
		
		$buff=$buff.
		"</tr>\n";

		return $buff;
	}
	//Genera las celdas para el <tbody>.
	function genTbody()
	{
		
		$buff="";				//Buffer de Respuesta HTML.
		$cuenta=0;				//Para llevar la cuenta de la celda actual.
	
		//Genera tabla.
		for($i=0;$i<$this->filas;$i++)
		{
			$buff=$buff."<tr>\n";
			for($j=0;$j<7;$j++)
			{
				$clase="";				//Por si un td (dia) pertenece a una clase CSS en particular.
				$numDia=0;				//El número del dia.
				$mes=0;
				
				if($cuenta<$this->diasAnt)
				{
					$numDia=
					(	
						$this->diasMesAnt-($this->diasAnt-$cuenta)
					);
					$mes=1;
					$clase=" class='muted";
				};
				if($cuenta>=($this->celdasMin))
				{
					$numDia=
					(
						$cuenta-$this->celdasMin
					);
					$mes=-1;
					$clase=" class='muted";
				};
				if($cuenta>=$this->diasAnt && $cuenta<$this->celdasMin)
				{
					$numDia=
					(
						$cuenta-$this->diasAnt
					);
				};
				
				$k=0;
				while($k<count($this->cfg->eventos))
				{
					
					$evtAct=$this->cfg->eventos[$k];
					
					
					if
					(
						($this->fecha["mon"]==$evtAct->fecha["mon"])	&&
						($this->fecha["year"]==$evtAct->fecha["year"])	&&
						($evtAct->fecha["mday"]==($numDia+1))
					)
					{
						if(strlen($clase))
						{
							$clase=$clase." evento";
						}
						else
						{
							$clase=" class='evento";
						}
						break;
					}
					
					$k++;
				}
				if(strlen($clase))
				{
					$clase=$clase."'";
				}
				
				$cuenta++;
				$buff=$buff."<td".$clase."><p>".($numDia+1)."</p></td>\n";
			};
			$buff=$buff."</tr>\n";
		};
		
		
		return $buff;
	}
	function genTable()
	{
		$buff=
		"
			<table>
				<thead>
					\n"
					.$this->genThead().
					"\n
				</thead>
				<tbody>
					\n"
					.$this->genTbody().
					"\n
                		</tbody>
			</table>
		";

		return $buff;
	}

	function genAno()
	{
		$buff="";
		for($i=1;$i<13;$i++)
		{
			$this->mes($i);
			$buff=$buff.$this->genTable();
		}
		return $buff;
	}
	function __construct($cal_cfg)
	{
		$this->cfg=$cal_cfg;
		$this->fecha=$cal_cfg->fecha;
		$this->calcCeldas();
	}
}
?>

<!--	:::::::::Calendario:::::::::	-->
<section>
	<h1 class="ano">
		<?php
		$CalCfg=new Cal_Cfg();
		$GenHTML=new Cal_Gen_HTML($CalCfg);
		echo $GenHTML->ano(); 
		?>
	</h1>
	<div class="calendario">
		<?php
		$CalCfg->nEvento
		(
			new Evento
			(
				getdate(mktime(0,0,0,3,6)),
				"Hoy , un dia como el resto",
				"Lorem ipsum dolor is amet..."
			)
		);
		$CalCfg->nEvento
		(
			new Evento
			(
				getdate(mktime(0,0,0,6,12)),
				"Hoy , un dia como el resto",
				"Lorem ipsum dolor is amet..."
			)
		);
		$CalCfg->nEvento
		(
			new Evento
			(
				getdate(),
				"Hoy , un dia como el resto",
				"Lorem ipsum dolor is amet..."
			)
		);
		echo $GenHTML->genAno();
		?>
	</div>
</section>