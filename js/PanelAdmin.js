//Convierte un objeto como el siguiente:
//[ {Dominio:'jj'} , {Dominio:'jj.aa' , val:'2'} , {Dominio:'jj.aa' , val:'2'} , {Dominio:'jj.bb' , val:'3'}]
//En:
//{
//	'jj':
//	{
//		'aa':[2,2],
//		'bb':2
//	}	
//}
function cfgROpc(event)
{
	menuXML.sel.parentNode.removeChild(menuXML.sel);
	cfgOpcBD(2);
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
		input.addEventListener('keydown',thisInput);
		input.addEventListener('blur',thisInput);
		input.value=ele.innerHTML||'';

	ele.innerHTML='';
	ele.appendChild(input);

	return input;
}
function thisInput(event)
{
	if(event.type==='dblclick' && (!this.lastChild || this.lastChild.tagName!=='INPUT'))
	{
		input=mkInput(this);

		input.focus();
	}
	if(event.type==='keydown' || event.type==='blur')
	{
		//Enter , TAB o BLUR.
		if(event.keyCode===13 || event.keyCode===9 || event.type==='blur')
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
	}
}
function cfgOpcBD(accion , padre)
{
	var args={};

	if(padre)
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

		args.datos=datos;
	}
	if(accion===1 || accion===2)
	{
		args.id=conf.Opcion[menuXML.nOpc].ID;
	}

	args.accion=accion;
	
	window.console.log(args);
	var req=new XMLObj
	(
		{
			url:getUrl()+'/php/opciones_op.php',
			args:args,
			handler:function()
			{
				xmlObj=this.xmlHttp;

				if(xmlObj.status===200&&xmlObj.readyState===4)
				{
					window.console.log(xmlObj.response);
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
function domObj(obj , res)
{
	var puntero=res;
	if(obj.Dominio)
	{
		var str=obj.Dominio.split('.');

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
//Obtiene un string con el directorio absoluto actual.
function getUrlDir()
{
	var url=window.location.toString();
	
	return url.substr(0,url.lastIndexOf('/'));
}
PanelAdmin=function()
{
	this.pattern='edetec';
	this.lab='edetec';
	this.getConfPath='/php/getConfig.php';
	this.cfg=[];

	this.proto=new CajaProto();
	this.diag=new Diag();
	this.proto.diag=this.diag;

	this.proto.tipos=
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
					addEventListener:['click',function(){this.proto.diag.selV('panel','vistaP'+nHijo.bind(this)())}]
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
						addEventListener:['click' , cfgROpc]
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

	this.proto.creaTipo('raiz' , 0 , 0);
	this.proto.creaTipo('Tit' , 'Panel Admin' ,0);
	this.proto.creaTipo('Pes' , 'Edita Configuración' , 'Cfg');
	this.proto.creaTipo('cfgEdit' , 'Edita Configuración' , 'Cfg');

	this.diag.selV('panel','vistaPCfg');
}
PanelAdmin.prototype.getConf=function()
{
	var getConfReq=new XMLObj
	(
		{
			url:getUrlDir()+this.getConfPath,
			args:{dom:this.pattern},
			handler:this.parseConf
		}
	);

	getConfReq.envia();
}
//Convierte un XML a un objeto.
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
//Convierte un string como el siguiente:
//"jj.bb.aa"
//En un objeto:
//{
//	'jj':
//	{
//		'bb':
//		{
//			'aa':{}
//		}
//	}
//}	
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
PanelAdmin.prototype.parseConf=function()
{
	var xmlObj=this.xmlHttp;
	if(xmlObj.readyState===4 && xmlObj.status===200)
	{

		var nConf={};

		if(xmlObj.responseXML)
		{
			XMLToObj(xmlObj.responseXML.childNodes[0] , nConf);
			nConf=nConf.Opcion;
		}
		else
		{
			return;
		}

		window.console.log(nConf);

		//domObj(conf , dConf);

		//window.console.log(dConf);
		//Cuando es un único resultado Opcion, XMLToObj no cree que sea un array, pero debe serlo.
		if(nConf.constructor.toString().indexOf('Array')===-1)
		{
			nConf=[nConf];
		}

		var n=this.cfg.length;
		for(var i=0;i<nConf.length;i++)
		{
			var cfg=nConf[i];

			menuXML.creaTipo('cfgOpc' , [cfg['Dominio'],cfg['Tipo'],cfg['Valor']] , n+i);
			this.cfg.push(nConf[i]);
		}
	}
}