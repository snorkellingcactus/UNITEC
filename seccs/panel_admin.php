<!DOCTYPE html >
<?php
//Solo si se está en modo administrador.
if(isset($_SESSION['adminID']))
{
	include_once 'php/conexion.php';
	include_once 'php/SQL_DOM.php';

	$usuario=$con->query('select * from Usuarios where ID='.$_SESSION['adminID']);
	$usuario=$usuario->fetch_all(MYSQLI_ASSOC)[0];
?>

<div class 'panelAdmin'>
	<script type="text/javascript" src="js/Caja.js"></script>
	<script type="text/javascript" src="js/Diag.js"></script>
	<script type="text/javascript" src="js/XMLObj.js"></script>
	<script type="text/javascript" src="js/Menu_XML.js"></script>
	<script type="text/javascript">
	function nHijo()
	{
		var hijos=this.parentNode.getElementsByTagName(this.tagName);
		var i=0;
		var iMax=20;
		while(hijos[i]!=this)
		{
			i++
		}

		return i+1;
	}

	document.body.appendChild
	(
		new Caja
		(
			{
				tag:'div',
				forma:
				{
					style:
					[
						['clear','both'],
						['minWidth','1px']
					]
				}
			}
		).doc
	)

	menuXML=new MenuProto();
	menuXML.diag=new Diag();
	menuXML.tipos=
	{
		'raiz':
		{
			hijo:
			{
				nom:'panel',
				tag:'div',
				forma:
				{
					style:
					[
						['width','80%'],
						['backgroundColor','white'],
						['color','black'],
						['margin','auto']
					],
					setAttribute:['id','panel']
				}
			}
		},
		'Tit':
		{
			'panel':
			[
				{
					nom:'titulo',
					tag:'h1',
					forma:
					{
						style:
						[
							['width','100%'],
							['textAlign','center'],
							['position','relative']
						]
					}
	
				},
				{
					nom:'pestanas',
					tag:'div',
					forma:
					{
						style:
						[
							['width','100%'],
							['minHeight','1em'],
							['border','1px solid gray']
						],
						setAttribute:['class','pestanas'],
					}
				}
			],
			dist:function(caja , val , n)
			{
				if(caja.nom=='titulo')
				{
					caja.doc.innerHTML=val;
				}
			}
		},
		'Pes':
		{
			'pestanas':
			{
				nom:'p',
				tag:'div',
				forma:
				{
					setAttribute:['class','pestana'],
					addEventListener:['click',function(){menuXML.diag.selV('panel','vistaP'+nHijo.bind(this)())}]
				}
			},
			'hijo':
			{
				nom:'vistaP',
				tag:'div',
				forma:
				{
					setAttribute:['class','vista'],
					innerHTML:'vistaP'
				}
			},
			dist:function(caja , val , n)
			{
				if(caja.nom=="p")
				{
					caja.doc.innerHTML=val;
				}
				if(caja.nom=='vistaP')
				{
					caja.doc.innerHTML+=n;
				}
				caja.nom+=n;
			}
		},
		'cfgEdit':
		{
			'vistaPCfg':
			{
				nom:'cuadroOpc',
				tag:'div',
				forma:
				{
					setAttribute:['class','cuadroOpc']
				},
				hijo:
				{
					tag:'div',
					hijos:
					[
						{
							tag:'p',
							innerHTML:'Nombre'
						},
						{
							tag:'p',
							innerHTML:'Tipo'
						},
						{
							tag:'p',
							innerHTML:'Valor'
						}
					]
				}
			}
		},
		'cfgOpc':
		{
			'cuadroOpc':
			{
				nom:'Opc',
				tag:'span',
				forma:
				{
					addEventListener:['click',thisSel]
				},
				hijos:
				[
					{
						tag:'p',
						forma:
						{
							addEventListener:['dblclick',thisInput]
						}
					},
					{
						tag:'p',
						forma:
						{
							addEventListener:['dblclick',thisInput]
						}
					},
					{
						tag:'p',
						forma:
						{
							addEventListener:['dblclick',thisInput]
						}
					}
				],
			},
			dist:function(caja , val , n)
			{
				var color='dimgray';
				if(n%2===0)
				{
					color='gray';
				}
				caja.doc.style.backgroundColor=color;
				caja.doc.num=n;

				for(var i=0;i<val.length;i++)
				{
					caja.doc.childNodes[i].innerHTML=val[i];
				}
			}
		},
		'opcValInput':
		{
			'hijo':
			{
				nom:'opcValInput',
				tag:'input'
			},
			dist:function(caja , val , n)
			{
				caja.doc.setAttribute('type',val);
			}
		}
	}
	function thisSel(event)
	{
		var ele=event.target.parentNode;

		if(menuXML.sel)
		{
			menuXML.sel.style.backgroundColor=menuXML.selBackground;
		}
		menuXML.sel=ele;
		menuXML.nOpc=this.num;

		menuXML.selBackground=ele.style.backgroundColor
		window.console.log(ele.style.backgroundColor);
		ele.style.backgroundColor='blue';
	}
	function thisInput(event)
	{
		menuXML.valAct=event.target.innerHTML;

		menuXML.creaTipo('opcValInput' , 'text' , 0);

		var input=menuXML.diag.caja('opcValInput').doc

		this.innerHTML='';
		this.appendChild(input);

		input.focus();
	}
	function XMLToMenu()
	{
		if(this.readyState==4 && this.status==200)
		{
			var response=this.responseXML.childNodes[0];

			menuXML.XMLTags(response);

			//Fix ancho pestañas.
			var pestanas=menuXML.diag.caja('pestanas').doc.getElementsByTagName('div');

			multipleCSS
			(
				{width:(100/pestanas.length)+'%'},
				pestanas
			)

			menuXML.diag.selV('panel','vistaP1');

			document.body.appendChild(menuXML.diag.caja('panel').doc);
		}
	}

	function XMLToObj(nodo , cfg)
	{
		//var res=this.responseXML.childNodes[0];

		for(var i=0;i<nodo.childNodes.length;i++)
		{
			var nodoHijo=nodo.childNodes[i];
			var nodoNieto=nodoHijo.childNodes[0];

			var clave=nodoHijo.nodeName;

			var cfgMask=cfg;
			var claveMask=clave;

			if(cfg[clave])
			{
				if(cfg[clave].constructor.toString().indexOf('Array')===-1)
				{
					cfg[clave]=[cfg[clave]];
				}

				cfgMask=cfg[clave];
				claveMask=cfg[clave].length;
			}

			if(nodoNieto && nodoNieto.nodeName==='#text')
			{
				cfgMask[claveMask]=nodoNieto.nodeValue;
			}
			else
			{
				cfgMask[claveMask]={};
				XMLToObj(nodoHijo , cfgMask[claveMask]);
			}
		}
	}
	function domObjStructStr(obj , str)
	{
		var puntero=obj;
		var clave;
		var intacto=true;

		for(var i=0;i<str.length;i++)
		{
			clave=str[i];

			if(!puntero[clave])
			{
				puntero[clave]={};
				intacto=false;
			}

			if(i<str.length-1)
			{
				puntero=puntero[clave];
			}
		}

		if(intacto)
		{
			if(puntero[clave].constructor.toString().indexOf('Array')===-1)
			{
				puntero[clave]=[puntero[clave]];
			}

			puntero[clave][puntero[clave].length]={};
		}
		return puntero[clave];
	}
	function domObj(obj , res)
	{
		var puntero=res;
		if(obj.Dominio)
		{
			var str=obj.Dominio.split('.');;

			var puntero=domObjStructStr(res , str);
		}
		for(var clave in obj)
		{
			if(clave==='Dominio')
			{
				continue;
			}
			else
			{
				if(typeof(obj[clave])==='object')
				{
					domObj(obj[clave] , res);
				}
				else
				{
					if(puntero.constructor.toString().indexOf('Array')!==-1)
					{
						var i=puntero.length-1;

						puntero[i][clave]=obj[clave];
					}
					else
					{
						puntero[clave]=obj[clave];
					}
				}
			}
		}
	}
	function getConf()
	{
		if(this.readyState==4 && this.status==200)
		{
			var conf={};
			var dConf={};

			if(this.responseXML)
			{
				XMLToObj(this.responseXML.childNodes[0] , conf);
			}
			window.conf=conf;

			window.console.log(window.conf);

			domObj(conf , dConf);

			window.dConf=dConf;

			window.console.log(window.dConf);


			menuXML.creaTipo('raiz' , 0 , 0);
			menuXML.creaTipo('Tit' , 'Panel Admin' ,0);
			menuXML.creaTipo('Pes' , 'Edita Configuración' , 'Cfg');
			menuXML.creaTipo('cfgEdit' , 'Edita Configuración' , 'Cfg');
			menuXML.diag.selV('panel','vistaPCfg');

			for(var i=0;i<conf.Opcion.length;i++)
			{
				var cfg=conf.Opcion[i];
				menuXML.creaTipo('cfgOpc' , [cfg['Dominio'],cfg['Tipo'],cfg['Valor']] , i);
			}

			document.body.appendChild(menuXML.diag.caja('panel').doc);
		}
	}
	getConfReq=new XMLObj
	(
		{
			url:'http://localhost/Web/Pasant%C3%ADa/edetec/php/getConfig.php',
			args:{dom:'edetec'},
			handler:getConf
		}
	);

	getConfReq.envia();
	</script>
	<h1>Bienvenido <?php echo $usuario['Nombre'] ?></h1>
</div>

<?php
}
?>