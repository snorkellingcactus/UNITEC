Diag=function()
{
	this.id='';
	this.cajas=[];

	this.padre=false;
	this.vIndex={}
	this.cIndex={};

	this.vistaAct=false;
	this.cajaAct=false;
}
Diag.prototype.nCaja=function(caja)
{
	if(caja.nom)
	{
		this.cIndex[caja.nom]=this.cajas.length;
	}
	this.cajas.push(caja);
}
Diag.prototype.nCajas=function()
{
	if(arguments[0].constructor.toString().indexOf('Array')!=-1)
	{
		arguments=arguments[0];
	}
	for(var i=0;i<arguments.length;i++)
	{
		this.nCaja(arguments[i]);
	}
}
Diag.prototype.nCajaAct=function(caja)
{
	this.nCaja(caja);

	this.cajaAct=this.cajas.length-1;
}
Diag.prototype.cajaN=function(args)
{
	return this[args[0]][this.gIndex(args)];
}
Diag.prototype.gIndex=function(args)
{
	var n=this[args[0]+'Act'];

	if(args[1]&&args[1]!==undefined)
	{
		n=args[1];
		if(isNaN(n))
		{
			n=this[args[0][0]+'Index'][n];
		}
	}
	return n;
}
Diag.prototype.cajaInd=function(nom)
{
	return this.gIndex(['caja' , nom]);
}
Diag.prototype.vistaInd=function(nom)
{
	return this.gIndex(['vista' , nom]);
}
Diag.prototype.caja=function(n)
{
	return this.cajas[this.cajaInd(n)];
}
Diag.prototype.selCaja=function(nCaja)
{
	if(false!==this.cajaAct)
	{
		if(this.caja().doc.parentNode==this.padre)
		{
			this.padre.removeChild(this.caja().doc);
		}
	}
	this.padre.appendChild(this.caja(nCaja).doc);

	this.cajaAct=this.cajaInd(nCaja);
}
Diag.prototype.selV=function(cajaA , cajaB)
{
	this.padre=this.caja(cajaA).doc;

	this.selCaja(this.cajaInd(cajaB));
}