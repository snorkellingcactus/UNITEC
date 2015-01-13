<?php
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
	function genTheadTrThMes()
	{
		$esq=new stdClass();

		$esq->mes=$this->mes();

		include('esq/cal_thead_tr_th_mes.php');
	}
	function genTheadTrThDias()
	{
		$cantDias=count($this->cfg->dias);

		for($i=0;$i<$cantDias;$i++)
		{
			$esq=new stdClass();

			$esq->nomDia=$this->cfg->dias[$i];
			
			include('esq/cal_thead_tr_th_dia.php');
		};
	}
	//Genera las celdas para el <thead>
	//Genera las celdas para el <tbody>.
	function genTbody()
	{
		$cuenta=0;				//Para llevar la cuenta de la celda actual.
		$mes=$this->fecha["mon"];
		$args=func_get_args();

		if(isset($args[0]))
		{
			$mes=$args[0];
			$this->mes($mes);
		}

		$this->cfg->verif=[0,0,1,1,1];	//Verificar mes dia y año.
		//Genera tabla.
		for($i=0;$i<$this->filas;++$i)
		{
			echo '<tr>';
			for($j=0;$j<7;$j++)
			{
				$clase=0;				//Por si un td (dia) pertenece a una clase CSS en particular.
				$numDia=1;				//El número del dia.
				
				if($cuenta<$this->diasAnt)
				{
					$numDia+=
					(	
						$this->diasMesAnt-($this->diasAnt-$cuenta)
					);
					$clase=1;
				};
				if($cuenta>=($this->celdasMin))
				{
					$numDia+=
					(
						$cuenta-$this->celdasMin
					);
					$clase=2;
				};
				if($cuenta>=$this->diasAnt && $cuenta<$this->celdasMin)
				{
					$numDia+=
					(
						$cuenta-$this->diasAnt
					);
					
					$eventos=$this->cfg->eventoEnFecha
					(
						[
							'mon'=>$mes,
							'year'=>$this->fecha['year'],
							'mday'=>$numDia
						]
					);
					//Si hay un evento asigno la clase evento al td.
					if($eventos!=-1)
					{
						$clase=3;
					}
				};
				
				//Busco eventos que coincidan con esta fecha.
				
				++$cuenta;

				$esq=new stdClass();

				$esq->numDia=$numDia;
				$esq->clase=$clase;

				include('esq/cal_tbody_tr_td.php');
			};
			echo '</tr>';
		};
	}
	function genTable()
	{
		$esq=$this;

		include('esq/cal_table.php');
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