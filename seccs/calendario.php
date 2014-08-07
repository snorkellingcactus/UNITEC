<!--	:::::::::Calendario:::::::::	-->
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
//Variables Español.
global $Cal_Dias,$Cal_Meses,$Cal_Fecha;
$Cal_Tipo=CAL_GREGORIAN;
$Cal_Dias=["Lunes" , "Martes" , "Miércoles" , "Jueves" , "Viernes" , "Sábado" , "Domingo"];
$Cal_Meses=	[	"Enero"		,		"Febrero"		,		"Marzo"		,		"Abril"		,
				"Mayo"		,		"Junio"			,		"Julio"		,		"Agosto"	,
				"Septiembre"		,"Octubre"		,		"Noviembre"	,		"Diciembre"
			];
//Fecha Actual.
$Cal_Fecha=getdate();
//:::::::::::::::::::::::::::::
function Cal_Gen_TBody()
{
//35
	global $Cal_Fecha,$Cal_Tipo;
	//Cantidad dias mes actual:
	$diasMesAct=cal_days_in_month($Cal_Tipo , $Cal_Fecha["mon"] , $Cal_Fecha["year"]);
	$diasMesAnt=cal_days_in_month($Cal_Tipo , $Cal_Fecha["mon"]-1 , $Cal_Fecha["year"]);
	
	$diasDeshab=35-$diasMesAct;
	
	$buff="";
	
	for($i=0;$i<7;$i++)
	{
		$buff=$buff."<tr>";
		for($j=0;$j<5;$j++)
		{
			$cuenta=($i*$j+j);
			$buff=$buff."<td>";
			
			if($cuenta<$diasDeshab)
			{
				$buff=$buff.($diasMesAnt-($diasDeshab-$cuenta));
			}
			else
			{
				$buff=$buff.($cuenta-$diasDeshab);
			};
			$buff=$buff."</td>";
		}
		$buff=$buff."</tr>";
	}
	
	return $buff;
};
function Cal_Gen_THead()
{
	global $Cal_Dias;		//Se utilizará esta variable global.
	$buff="";						//Donde se va a almacenar el resultado.
	
	for($i=0;$i<count($Cal_Dias);$i++)
	{
		$buff=$buff."<th>".substr($Cal_Dias[$i],0,2)."</th>";
	};
	
	return $buff;
};
?>
<div class="container calendario">
	<div class="row">
		<div class="span12">
			<table class="table-condensed table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="7">
							<span class="btn-group">
								<a class="btn"><i class="icon-chevron-left"></i></a>
								<a class="btn active"><?php
									echo $Cal_Meses
									[
										$Cal_Fecha["mon"]
									]." ".$Cal_Fecha["year"];
								?></a>
								<a class="btn"><i class="icon-chevron-right"></i></a>
							</span>
						</th>
					</tr>
					<tr>
						<?php
							echo Cal_Gen_THead();
						?>
					</tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="muted">29</td>
                        <td class="muted">30</td>
                        <td class="muted">31</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>10</td>
                        <td>11</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>13</td>
                        <td>14</td>
                        <td>15</td>
                        <td>16</td>
                        <td>17</td>
                        <td>18</td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td class="btn-primary"><strong>20</strong></td>
                        <td>21</td>
                        <td>22</td>
                        <td>23</td>
                        <td>24</td>
                        <td>25</td>
                    </tr>
                    <tr>
                        <td>26</td>
                        <td>27</td>
                        <td>28</td>
                        <td>29</td>
                        <td class="muted">1</td>
                        <td class="muted">2</td>
                        <td class="muted">3</td>
                    </tr>
                </tbody>
            </table>
        </div>
	</div>
</div>
<?php
	//calendario();
?>