CajaProto=function()
{
	this.tipos={};
	this.diag={};
}
CajaProto.prototype.creaTipo=function(tipoNom , val , n)
{
	var tipo=this.tipos[tipoNom];
	var dist=function(){};

	if(tipo.dist)
	{
		dist=tipo.dist;
	}

	//window.console.log(tipoNom);
	for(var clave in tipo)
	{
		//window.console.log('Clave : '+clave);
		var nCajaCfg=tipo[clave];
		var nCaja=[];

		switch(clave)
		{
			case 'hijo':
				if(nCajaCfg.constructor.toString().indexOf('Array')!=-1)
				{
					nCaja=[];
					for(var i=0;i<nCajaCfg.length;i++)
					{
						nCaja[i]=new Caja(nCajaCfg);
					}
				}
				else
				{
					nCaja[0]=new Caja(nCajaCfg);
				}
			break;
			case 'dist':
				continue;
			break;
			default:
				nCaja=this.diag.caja(clave).hijos(nCajaCfg);
		}

		for(var i=0;i<nCaja.length;i++)
		{
			dist(nCaja[i] , val , n);

			this.diag.nCaja(nCaja[i]);
		}
	}
}