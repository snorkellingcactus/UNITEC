function tipo(obj , nombre)
{
	return obj.constructor.toString().indexOf(nombre)!==-1;
}
function multipleCSS(cfg , eles)
{
	for(var clave in cfg)
	{
		for(var j=0;j<eles.length;j++)
		{
			eles[j].style[clave]=cfg[clave];
		}
	}
}
function vistaPes()
{
	var her=this.parentNode.childNodes;
	var i=0;

	while(her[i]!=this)
	{
		i++;
	}
	
	gCalDiag.selCaja('vista'+i)
}
Caja=function(cfg)
{
	this.doc=document.createElement(cfg.tag);
	this.nom=false||cfg.nom;

	if(cfg.innerHTML)
	{
		this.doc.innerHTML=cfg.innerHTML;
	}
	if(cfg.forma)
	{
		this.forma(cfg.forma);
	}
	if(cfg.hijos || cfg.hijo)
	{
		this.hijos(cfg.hijos|| cfg.hijo);
	}
}
Caja.prototype.forma=function(cfg)
{
	for(var clave in cfg)
	{
		if(!tipo(cfg[clave] , 'Array'))
		{
			this.doc[clave]=cfg[clave];

			continue;
		}
		if(!tipo(cfg[clave][0] , 'Array'))
		{
			this[clave](cfg[clave]);

			continue;
		}

		for(var i=0;i<cfg[clave].length;i++)
		{
				this[clave](cfg[clave][i]);
		}
	}
}
Caja.prototype.addEventListener=function(cfg)
{
	this.doc.addEventListener(cfg[0] , cfg[1]);
}
Caja.prototype.setAttribute=function(cfg)
{
	this.doc.setAttribute(cfg[0] , cfg[1]);
}
Caja.prototype.style=function(cfg)
{
	this.doc.style[cfg[0]]=cfg[1];
}
Caja.prototype.hijo=function(cfg)
{
	var caja=new Caja(cfg);
	this.doc.appendChild(caja.doc);

	return caja;
}
Caja.prototype.hijos=function()
{
	var cajas=[];

	if(arguments[0].constructor.toString().indexOf('Array')!=-1)
	{
		arguments=arguments[0];
	}
	for(var i=0;i<arguments.length;i++)
	{
		cajas[i]=this.hijo(arguments[i]);
	}

	return cajas;
}