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
	function adEvento()
	{
		$args=func_get_args();
		$last=count($this->eventos);
		$this->eventos[$last]=[$args[0] , $args[1] , $args[2]];
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
	public $filas;				//Cantidad de filas por de fecto (7x5=35).

	function calcCeldas()
	{
		$args=func_get_args();

		$this->filas=5;
		$this->celdasMax=$this->filas*7;		//Máximo de celdas que aparentemente se van a mostrar.

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
			$this->celdasMax=$this->filas*7;		//Actualizo el máximo de celdas.
		};
		
		$this->celdasMin=$this->diasMesAct+$this->diasAnt;	//Cantidad celdas necesarias para mostrar todo el mes.

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
		if(isset($args[0]))
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
		<tr>\n
		";		//Donde se va a almacenar el resultado.
		
		$cantDias=count($this->cfg->dias);
		for($i=0;$i<$cantDias;$i++)
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
		$mes=$this->fecha["mon"];
		$args=func_get_args();

		if(isset($args[0]))
		{
			$mes=$args[0];
			$this->mes($mes);
		}

		//Genera tabla.
		for($i=0;$i<$this->filas;++$i)
		{
			$buff=$buff."<tr>\n";
			for($j=0;$j<7;$j++)
			{
				$clase="";				//Por si un td (dia) pertenece a una clase CSS en particular.
				$numDia=1;				//El número del dia.
				
				if($cuenta<$this->diasAnt)
				{
					$numDia+=
					(	
						$this->diasMesAnt-($this->diasAnt-$cuenta)
					);
					$clase=" class='muted";
				};
				if($cuenta>=($this->celdasMin))
				{
					$numDia+=
					(
						$cuenta-$this->celdasMin
					);
					$clase=" class='muted";
				};
				if($cuenta>=$this->diasAnt && $cuenta<$this->celdasMin)
				{
					$numDia+=
					(
						$cuenta-$this->diasAnt
					);
				};
				
				//Busco eventos que coincidan con esta fecha.
				$k=0;
				$evts=$this->cfg->eventos;
				$lastEvt=count($evts);
				
				while($k<$lastEvt)
				{
					$fechaEvtAct=$evts[$k][0];
					if
					(
						($fechaEvtAct["mon"]	==	$mes			)&&
						($fechaEvtAct["year"]	==	$this->fecha["year"]	)&&
						($fechaEvtAct["mday"]	==	$numDia			)
					)
					{
						//Si se encontró un evento, le asigno la clase CSS evento al td.
						if(isset($clase[1]))
						{
							$clase=$clase." evento";
						}
						else
						{
							$clase=" class='evento";
						}

						break;	//Dejo de buscar eventos, de momento no se contemplan varias coincidencias.
					}
					
					++$k;
				}
				if(isset($clase[1]))
				{
					$clase=$clase."'";
				}
				
				$cuenta++;
				$buff=$buff."<td".$clase."><p>".$numDia."</p></td>\n";
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
	//Genera las tablas de los números de meses pasados por argumento.
	function genMeses()
	{
		$buff="";
		$args=func_get_args();
		$cantArgs=count($args);

		for($i=0;$i<$cantArgs;$i++)
		{
			$buff=$buff.$this->genTable($args[$i]);
		}
		return $buff;
	}
	//Genera todo el año.
	function genAno()
	{
		$ano=$this->fecha["year"];
		$args=func_get_args();

		if(isset($args[0]))
		{
			$ano=$args[0];
			$this->ano($ano);
		}
		return $this->genMeses(1,2,3,4,5,6,7,8,9,10,11,12);
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
<section class="calendario" id="cal">
	<h1 class="ano">
		<?php
		$CalCfg=new Cal_Cfg();
		$GenHTML=new Cal_Gen_HTML($CalCfg);
		echo $GenHTML->ano(); 
		?>
	</h1>
		<?php
		$CalCfg->adEvento
		(
			
			getdate(mktime(0,0,0,3,6)),
			"Hoy , un dia como el resto",
			"Lorem ipsum dolor is amet..."
			
		);
		$CalCfg->adEvento
		(
			
			getdate(mktime(0,0,0,6,12)),
			"Hoy , un dia como el resto",
			"Lorem ipsum dolor is amet..."
			
		);
		$CalCfg->adEvento
		(
			
			getdate(),
			"Hoy , un dia como el resto",
			"Lorem ipsum dolor is amet..."
		);
		for($m=1;$m<13;$m+=1)
		{
			echo '<div class="col-xs-12 col-sm-6 col-md-4" col-lg-4>';

			$GenHTML->mes($m);
			echo $GenHTML->genTable();
			echo "</div>";
			if($m%3==0)
			{
				echo '<div class="clearfix visible-md visible-lg"></div>';
			}
			if($m%2==0)
			{
				echo '<div class="clearfix visible-sm"></div>';
			}
			echo '<div class="clearfix visible-xs"></div>';
		}
		
		
		?>
</section>