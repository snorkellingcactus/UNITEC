<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
/*
	echo '<pre>SESSION:';
	print_r($_SESSION);
	echo '</pre>';
	echo '<pre>POST:';
	print_r($_POST);
	echo '</pre>';
*/
class FormHandler
{
	private $session;
	private $post;
	private $actions;
	private $selectedAction;
	private $referrer;
	private $fId;
	private $ancla;
	private $docRoot;

	private $cantidad;

	function __construct()
	{
		$this->actions=['edita','nuevo','elimina'];
		//Sacar lo que se necesite de acá, es ridiculo hacer referencia localmente a
		//una variable que se puede referenciar donde sea.
		$this->session=& $_SESSION;
		$this->post=& $_POST;

		$this->checkAction();

		$this->referrer=$_SERVER['HTTP_REFERER'];
		$this->ancla="nCon";

		$_SESSION['form']=$_POST['form'];
		if(isset($_POST['conID']))
		{
			$this->session['conID']=$_POST['conID'];
		}
		if(isset($_POST['Tipo']))
		{
			$this->session['Tipo']=$_POST['Tipo'];
		}

		$this->cantidad=1;

		if(isset($this->post['cantidad']))
		{
			$this->cantidad=$this->post['cantidad'];
		}

		if(isset($_POST['conID']) && count($_POST['conID']))
		{
			$this->cantidad=count($_POST['conID']);
		}

		if($this->session['accion']===$this->actions[2])
		{
			header('Location: '.$this->referrer);

			die();
		}
	}
	public function checkAction()
	{
		$iMax=count($this->actions);
		$i=0;

		while(!isset($this->post[$this->actions[$i]]) && $i<$iMax)
		{
			++$i;
		}

		$this->selectedAction=$i;
		$_SESSION['accion']=$this->actions[$i];
	}
	public function getConfig()
	{
		//Incluyo la configuración del formulario en cuestión.
		include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/config/'.$this->post['form'].'.php';
	}
	public function buildIncludes()
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/head_include.php';

		$iMax=count($this->includes);

		for($i=0;$i<$iMax;$i++)
		{
			//echo '<pre>Include'.$includes[$i].'</pre>';
			head_include($this->includes[$i]);
		}
		unset($iMax);
	}
	public function buildForm()
	{
		$lMax=count($this->labels);

		$buff='';
		for($l=0;$l<$lMax;$l++)
		{
			$labelAct=$this->labels[$l];

			$tipo=$labelAct[0];
			$labelName=$labelAct[1];

			ob_start();
			
			?>
				<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<label for="<?php echo $labelName ?>"><?php echo $labelName ?>:</label>
				</p>

				<?php include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/'.$tipo; ?>

				<div class="clearfix"></div>

			<?php

			$buff=$buff.ob_get_contents();
			ob_end_clean();
		}

		unset($l , $labelName , $labelAct , $labels);

		return $buff;
	}
	public function buildForms()
	{
		?>
			<form method="POST" class="tresem nuevo" action="<?php echo $this->referrer.$this->ancla ?>">
				<?php
					$iMax=$this->cantidad;

					for($i=0;$i<$iMax;$i++)
					{
						$this->autocomp=[];

						if($this->selectedAction===0 && isset($this->session['conID']))
						{
							$this->conIDAct=$_POST['conID'][$i];

							include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/config/'.$this->post['form'].'Autocomp.php';
						}

						echo $this->buildForm();

						?>
							<div class="clearfix fin"></div>
						<?php
					}

					unset($i , $iMax);
				?>		
				<input type="submit" class="col-xs-12 col-sm-5 col-md-5 col-lg-5" name="Aceptar" value="Aceptar">
				<span class='hidden-xs col-sm-2 col-md-2 col-lg-2 '></span>
				<input type="submit" class="col-xs-12 col-sm-5 col-md-5 col-lg-5" name='Cancela' value="Cancelar">
			</form>
		<?php
	}
}
/*
if(isset($_POST['nMenu']))
{
	$_SESSION['accion']='nMenu';
	$_SESSION['form']=$_POST['form'];
	$_SESSION['conID']=$_POST['conID'];

	header('Location: '.$_SERVER['HTTP_REFERER']);

	die();
}
*/
if(isset($_SESSION['adminID']))
{
	$formHandler=new FormHandler();
	
	$formHandler->getConfig();
	?>
		<html>
			<head>
				<meta charset="utf-8" />

				<!--::::::Includes comunes a todos los formularios::::::-->
				<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
				<link rel="stylesheet" type="text/css" href="../forms/forms.css" />

				<!--::::::Includes variables pasados por parametro::::::-->
				<?php
					$formHandler->buildIncludes();
				?>

			</head>
			<body>
					<?php
						$formHandler->buildForms();
					?>
				<div class="clearfix"></div>
			</body>
		</html>
	<?php
}
?>