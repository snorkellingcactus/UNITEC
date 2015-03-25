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
/*
Pasos:
//Interfaz: Crea Protos
//GetBD
//BD a Obj
//Interfaz: Crea

//Interaccion:
//

*/
//Obtiene un string con el directorio absoluto actual.
function getUrlDir()
{
	var url=window.location.toString();
	
	return url.substr(0,url.lastIndexOf('/'));
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
PanelAdmin=function()
{
	this.pattern='';
	this.lab='edetec';
	this.getConfPath='/php/getConfig.php';
	this.cfg=[];

	this.proto=new CajaProto();
	this.diag=new Diag();
	this.proto.diag=this.diag;

	this.xmlObj=new XMLObj();

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
					addEventListener:['click',this.intVista.bind(this)]
				}
			},
			'hijo':
			{
				nom:'vistaP',
				tag:'div',
				forma:
				{
					setAttribute:['class','vista']
				}
			},
			dist:function(caja , val , n)
			{
				if(caja.nom==="p")
				{
					caja.doc.innerHTML=val;
					caja.doc.setAttribute('vista','vistaP'+n);
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
						addEventListener:['click' , this.intHandNOpc.bind(this)]
					}
				},
				{
					nom:'cfgOpcRem',
					tag:'div',
					innerHTML:'-',
					forma:
					{
						setAttribute:['class','bottom'],
						addEventListener:['click' , this.intHandROpc.bind(this)]
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
					addEventListener:['click',this.intSel.bind(this)]
				},
				hijos:
				[
					{
						tag:'p',
						forma:
						{
							addEventListener:['dblclick',this.intHandInput.bind(this)]
						}
					},
					{
						tag:'p',
						forma:
						{
							addEventListener:['dblclick',this.intHandInput.bind(this)]
						}
					},
					{
						tag:'p',
						forma:
						{
							addEventListener:['dblclick',this.intHandInput.bind(this)]
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
}
PanelAdmin.prototype.prepareXmlHttp=function()
{
	this.xmlObj.conf
	(
		{
			url:getUrlDir()+this.getConfPath,
			args:{dom:this.pattern},
			handler:this.xmlToCfg.bind(this)
		}
	);
}
PanelAdmin.prototype.parseConf=function()
{
	this.xmlToCfg();
	this.cfgToInt();
}
//Convierte el resultado XML en un objeto
PanelAdmin.prototype.xmlToCfg=function()
{
	var xmlObj=this.xmlObj.xmlHttp;
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

		//domObj(this.cfg , dConf);

		//window.console.log(dConf);
		//Cuando es un único resultado Opcion, XMLToObj no cree que sea un array, pero debe serlo.
		if(nConf.constructor.toString().indexOf('Array')===-1)
		{
			nConf=[nConf];
		}

		window.console.log(nConf);

		for(var i=0;i<nConf.length;i++)
		{
			var cfg=nConf[i];

			this.cfg.push(nConf[i]);
		}
	}
}
PanelAdmin.prototype.cfgToInt=function()
{
	for(var i=0;i<this.cfg.length;i++)
	{
		var cfg=this.cfg[i];
		this.proto.creaTipo('cfgOpc' , [cfg['Dominio'],cfg['Tipo'],cfg['Valor']] , i);
	}
}
//Averigua el número de hermano del elemento en la jerarquía.
PanelAdmin.prototype.intVista=function(event)
{
	this.proto.diag.selV('panel',event.target.getAttribute('vista'));
}
//Selecciona opciones de la interfaz.
PanelAdmin.prototype.intSel=function(event)
{
	var ele=event.target.parentNode;

	if(ele.lastChild&&ele.lastChild.tagName==='INPUT')
	{
		return;
	}

	if(this.diag.sel)
	{
		this.diag.sel.style.backgroundColor=this.diag.selBackground;
	}
	this.diag.sel=ele;
	this.diag.nOpc=ele.num;

	window.console.log('Seleccionado ele N '+ele.num);

	this.diag.selBackground=ele.style.backgroundColor
	ele.style.backgroundColor='blue';
}
//Crea un campo.
PanelAdmin.prototype.intNInput=function(ele)
{
	this.proto.creaTipo('opcValInput' , 'text' , 0);

	this.diag.valAct=ele.innerHTML || false;

	var input=this.diag.caja('opcValInput').doc
		input.addEventListener('keydown',this.intHandInput.bind(this));
		input.addEventListener('blur',this.intHandInput.bind(this));
		input.value=ele.innerHTML||'';

	ele.innerHTML='';
	ele.appendChild(input);

	return input;
}
//Handler para eliminar una entrada.
PanelAdmin.prototype.intHandROpc=function(event)
{
	this.diag.sel.parentNode.removeChild(this.diag.sel);
	this.intHandBD(2);
}
//Handler para crear una entrada.
PanelAdmin.prototype.intHandNOpc=function(event)
{
	this.proto.creaTipo('cfgOpc' , false , this.cfg.length);

	window.console.log(this.diag.caja('cfgOpc').doc.childNodes);
	var campos=this.diag.caja('cfgOpc').doc.childNodes;

	var iMax=campos.length-1;
	for(var i=iMax;i>=0;i--)
	{
		var input=this.intNInput(campos[i]);
	}

	input.focus();
}
//Handler para campos.
PanelAdmin.prototype.intHandInput=function(event)
{
	var ele=event.target;

	if(event.type==='dblclick' && (!ele.lastChild || ele.lastChild.tagName!=='INPUT'))
	{
		input=this.intNInput(ele);

		input.focus();
	}
	if(event.type==='keydown' || event.type==='blur')
	{
		//Enter , TAB o BLUR.
		if(event.keyCode===13 || event.keyCode===9 || event.type==='blur')
		{
			var padre=ele.parentNode;
			var accion=1;

			padre.innerHTML=ele.value||'';
			this.diag.valAct=false;


			if(padre===padre.parentNode.lastChild && !this.cfg[padre.parentNode.num])
			{
				var accion=0;
			}

			this.intHandBD(accion , padre);
		}
		//Escape.
		if(event.keyCode===27)
		{
			ele.parentNode.innerHTML=this.diag.valAct||'';

			this.diag.valAct=false;
		}
	}
}
//Handler para eiminar, crear o modificar entradas.
PanelAdmin.prototype.intHandBD=function(accion , padre)
{
	var log=['Nueva','Modifica','Elimina'];
	window.console.log('Accion = '+log[accion]);

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
		window.console.log(this.diag.nOpc)

		args.id=this.cfg[this.diag.nOpc].ID;

		window.console.log('ID '+args.id);
	}

	args.accion=accion;
	
	this.xmlObj.conf
	(
		{
			url:getUrlDir()+'/php/opciones_op.php',
			args:args,
			handler:function()
			{
				xmlObj=this.xmlObj.xmlHttp;

				if(xmlObj.status===200&&xmlObj.readyState===4)
				{
					if(xmlObj.responseXML)
					{
						if(this.xmlObj.args.accion===2)
						{
							this.diag.sel.parentNode.removeChild(this.diag.sel);
						}
						this.xmlToCfg();
					}
				}
			}.bind(this)
		}
	)

	this.xmlObj.padre=padre;
	this.xmlObj.envia()
}