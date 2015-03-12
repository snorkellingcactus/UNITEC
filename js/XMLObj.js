function recXML(nodo , fn)
{
	for(var i=0;i<nodo.childNodes.length;i++)
	{
		var nodoAct=nodo.childNodes[i];

		if(nodoAct.childNodes.length)
		{
			if(nodoAct.childNodes[0].nodeName=='#text')
			{
				fn(nodoAct.nodeName , nodoAct.childNodes[0].nodeValue , i);
				continue;
			}

			fn(nodoAct.nodeName ,undefined, i);

			recXML(nodo.childNodes[i] , fn);
		}
	}
}
XMLObj=function()
{
	this.xmlHttp=new XMLHttpRequest();
	this.defHeader=['Content-Type','application/x-www-form-urlencoded'];
	this.defArgs=null;
	this.defMethod='POST';
	this.defAsync=1;
	this.defHandler=function(){}
	
	if(typeof(arguments[0])=='object')
	{
		//window.console.log(arguments[0]);

		this.conf(arguments[0]);
	}
	else
	{
		this.url=arguments[0];
		this.handler=arguments[1];

		if(arguments[2])
		{
			this.defArgs=arguments[2];
		}
	}
}
XMLObj.prototype.header=function(header)
{
	this.defHeader=header;
}
XMLObj.prototype.method=function(method)
{
	this.defMethod=method;
}
XMLObj.prototype.url=function(url)
{
	this.url=url;
}
XMLObj.prototype.handler=function(handler)
{
	this.defHandler=handler;
}
XMLObj.prototype.args=function(args)
{
	this.defArgs=args;
}
XMLObj.prototype.async=function(async)
{
	this.defAsync=async;
}
XMLObj.prototype.envia=function()
{
	this.xmlHttp.onreadystatechange=this.defHandler;
	//window.console.log('Open:');
	this.xmlHttp.open(this.defMethod , this.url , this.defAsync);
	//window.console.log('setHeader:');
	this.xmlHttp.setRequestHeader(this.defHeader[0] , this.defHeader[1])
	//window.console.log('Send:');
	this.xmlHttp.send(this.encArgs(this.defArgs));
}

XMLObj.prototype.conf=function(cfg)
{
	for(var clave in cfg)
	{
		this[clave](cfg[clave]);
	}
}
XMLObj.prototype.encArgs=function(args)
{
	var res='';

	for(var clave in args)
	{
		var valor=args[clave];

		res+=clave+'='+valor+'&';
	}

	res=res.substr(0,res.length-1);

	//window.console.log('argsEnc: '+res);

	return res;
}

XMLObj.prototype.parseXML=function()
{
	if(this.xmlHttp.responseXML)
	{
		recXML(this.xmlHttp.responseXML.childNodes[0] , this.parseFn.bind(this));
	}
}
XMLObj.prototype.parseFn=function(clave , valor , n)
{
	window.console.log(this);
}