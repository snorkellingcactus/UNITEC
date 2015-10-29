<div class="comentario"
<?php
	if
	(
		(isset($_SESSION['comConID'])&&$_SESSION['comConID']==$this->ContenidoID)
	)
	{
		unset($_SESSION['comConID']);

		?>
			id="comRes" 
		<?php
	}
?>
>
	<p class='comAutor'>
		<?php
			echo $this->Nombre;

			?>
				<span class="comResTxt">
			<?php

			//Nombre de la persona respondida.
			if($this->NombreDest!==NULL)
			{
				echo gettext('En respuesta a').' '.$this->NombreDest;
			}

			//Intervalo de tiempo desde el envío del comentario.
			
			$RangoTiempo=['y' , 'm' , 'd' , 'h' , 'i' , 's'];
			

			$Fecha=new DateTime();
			$Fecha=$Fecha->createFromFormat('Y-m-d H:i:s' , $this->Fecha);
			$Fecha=$Fecha->diff(new DateTime() , true);

			$t=0;
			$tMax=5;

			while($Fecha->$RangoTiempo[$t]<=0 && $t<$tMax)
			{
				++$t;
			}

			$valorTiempo=$Fecha->$RangoTiempo[$t];

			$RTHumano=
			[
				ngettext('Hace %s año' , 'Hace %s años' , $valorTiempo),
				ngettext('Hace %s mes' , 'Hace %s meses' , $valorTiempo),
				ngettext('Hace %s dia' , 'Hace %s dias' , $valorTiempo),
				ngettext('Hace %s hora' , 'Hace %s horas' , $valorTiempo),
				ngettext('Hace %s minuto' , 'Hace %s minutos' , $valorTiempo),
				ngettext('Hace %s segundo' , 'Hace %s segundos' , $valorTiempo)
			];

			echo ' - '.sprintf($RTHumano[$t] , $valorTiempo);

			?>
		</span>
	</p>

	<form action="#comRes" method="POST" class="formRes">
		<input type="hidden" name="comConID" value="<?php echo $this->ContenidoID ?>" >
	 	<input type="submit" value="<?php echo gettext('Responder')?>" title="<?php echo sprintf(gettext('Responder a %s') , $this->Nombre)?>">
	</form>

 	<?php
 		if($this->formBuilder!==false)
		{
			echo $this->formBuilder->buildActionCheckBox($this->ContenidoID)->getHTML();
		}
	?>


	<p class="comCont">
		<?php echo $this->ValorCont ?>
	</p>

	<?php
		if(isset($_POST['comConID'])&&$_POST['comConID']==$this->ContenidoID)
		{
			$_SESSION['comConID']=$_POST['comConID'];
			include $_SERVER['DOCUMENT_ROOT'] . '/forms/nuevo_coment.php';
		}
	?>
</div>