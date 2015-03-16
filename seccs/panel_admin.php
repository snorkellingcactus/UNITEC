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
	<script type="text/javascript" src="js/MenuProto.js"></script>
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
			'titulo':
				{
				nom:'cierra',
				tag:'a',
				innerHTML:'X',
				forma:
				{
					setAttribute:
					[
						['class','cerrar'],
						['href' , '?cSesion#']
					]
				}
			},
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
			},
			'cuadroOpc':
			[
				{
					nom:'cfgOpcLst',
					tag:'div'
				},
				{
					nom:'cfgOpcNue',
					tag:'div',
					innerHTML:'+',
					forma:
					{
						setAttribute:['class','bottom'],
						addEventListener:['click' , cfgNOpc]
					}
				},
				{
					nom:'cfgOpcRem',
					tag:'div',
					innerHTML:'-',
					forma:
					{
						setAttribute:['class','bottom'],
						addEventListener:['click' , cfgNOpc]
					}
				}
			]
		},
		'cfgOpc':
		{
			'cfgOpcLst':
			{
				nom:'cfgOpc',
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

				if(val)
				{
					for(var i=0;i<val.length;i++)
					{
						caja.doc.childNodes[i].innerHTML=val[i];
					}
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
	function cfgNOpc(event)
	{
		menuXML.creaTipo('cfgOpc' , false , conf.Opcion.length);

		window.console.log(menuXML.diag.caja('cfgOpc').doc.childNodes);
		var campos=menuXML.diag.caja('cfgOpc').doc.childNodes;

		var iMax=campos.length-1;
		for(var i=iMax;i>=0;i--)
		{
			var input=mkInput(campos[i]);
		}

		input.focus();
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
	function mkInput(ele)
	{
		menuXML.creaTipo('opcValInput' , 'text' , 0);

		menuXML.valAct=ele.innerHTML || false;

		var input=menuXML.diag.caja('opcValInput').doc
			input.addEventListener('keyup',thisInput);
			input.value=ele.innerHTML||'';

		ele.innerHTML='';
		ele.appendChild(input);

		return input;
	}
	function thisInput(event)
	{
		if(event.type==='dblclick')
		{
			input=mkInput(this);

			input.focus();
		}
		if(event.type==='keyup')
		{
			//Enter.
			if(event.keyCode===13)
			{
				var padre=this.parentNode;
				var accion=1;

				padre.innerHTML=this.value||'';
				menuXML.valAct=false;


				if(padre===padre.parentNode.lastChild && !conf.Opcion[padre.parentNode.num])
				{
					var accion=0;
				}

				cfgOpcBD(accion , padre);
			}
			//Escape.
			if(event.keyCode===27)
			{
				this.parentNode.innerHTML=menuXML.valAct||'';

				menuXML.valAct=false;
			}
			if( event.keyCode===9)
			{

			}
		}
	}
	function cfgOpcBD(accion , padre)
	{
		var hermanos=padre.parentNode.childNodes;

		var datos=new Array(hermanos.length);

		for(var i=0;i<hermanos.length;i++)
		{
			var actual=hermanos[i];
			var text=hermanos[i].childNodes[0];
			if(!text || text.nodeName!=='#text' || !text.nodeValue.length)
			{
				return;
			}

			if(!accion || actual===padre)
			{
				datos[i]=actual.innerHTML;
			}
		}
		var req=new XMLObj
		(
			{
				url:'http://localhost/Web/Pasant%C3%ADa/edetec/php/opciones_op.php',
				args:{'datos':datos,accion:accion},
				handler:function()
				{
					xmlObj=this.xmlHttp;

					if(xmlObj.status=200&&xmlObj.readyState==4)
					{
						if(xmlObj.responseXML)
						{
							this.padre.parentNode.parentNode.removeChild(this.padre.parentNode);
							getConf.call(this);
						}
					}
				}
			}
		)

		req.padre=padre;
		req.envia()
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
	conf={Opcion:[]};
	dConf={};

	menuXML.creaTipo('raiz' , 0 , 0);
	menuXML.creaTipo('Tit' , 'Panel Admin' ,0);
	menuXML.creaTipo('Pes' , 'Edita Configuración' , 'Cfg');
	menuXML.creaTipo('cfgEdit' , 'Edita Configuración' , 'Cfg');
	menuXML.diag.selV('panel','vistaPCfg');
	document.body.appendChild(menuXML.diag.caja('panel').doc);
	function getConf()
	{
		var xmlObj=this.xmlHttp;
		if(xmlObj.readyState==4 && xmlObj.status==200)
		{

			var nConf={};

			if(xmlObj.responseXML)
			{
				XMLToObj(xmlObj.responseXML.childNodes[0] , nConf);
			}
			else
			{
				return;
			}

			window.console.log(nConf);

			//domObj(conf , dConf);

			//window.console.log(dConf);
			//Cuando es un único resultado Opcion, XMLToObj no cree que sea un array, pero debe serlo.
			if(nConf.Opcion.constructor.toString().indexOf('Array')===-1)
			{
				nConf.Opcion=[nConf.Opcion];
			}

			var n=conf.Opcion.length;
			for(var i=0;i<nConf.Opcion.length;i++)
			{
				var cfg=nConf.Opcion[i];

				menuXML.creaTipo('cfgOpc' , [cfg['Dominio'],cfg['Tipo'],cfg['Valor']] , n+i);
				conf.Opcion.push(nConf.Opcion[i]);
			}
		}
	}
	//LabTIC
	//'http://localhost/edetec/php/getConfig.php'
	//Casa
	//'http://localhost/Web/Pasant%C3%ADa/edetec/php/getConfig.php'
	var url=window.location.toString();
		url=url.substr(0,url.lastIndexOf('/'));
	window.console.log(url);
	getConfReq=new XMLObj
	(
		{
			url:url+'/php/getConfig.php',
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