function firstTextNode(ele)
{
	var nodes=ele.childNodes
	for(i=0;i<nodes.length;i++)
	{
		var node=nodes[i];

		if(node.childNodes.length)
		{
			node=node.childNodes[0];
			if(node===null)
			{
				var nodeHasText=firstTextNode(node);

				if(nodeHasText!==false)
				{
					return nodeHasText;
				}
				else
				{
					return false
				}
			}
			else
			{
				return [node , i];
			}
		}
	}
}
function inicializa()
{
	var sangrias=document.getElementsByClassName('sangria');

	for(var i=0;i<sangrias.length;i++)
	{
		var sangria=sangrias[i];
		var sangriaTextNode=firstTextNode(sangria);

		if(sangriaTextNode)
		{
			var sangriaParent=sangriaTextNode[0].parentNode;

			var nSpan=document.createElement('span');
				nSpan.textContent=sangriaParent.textContent[0];
				nSpan.setAttribute('class' , 'sangriaJS');


			sangriaParent.parentNode.insertBefore(nSpan , sangriaParent);

			sangriaParent.textContent=sangriaParent.textContent.substr(1);
			sangria.classList.remove('sangria');
			sangriaParent.classList.add('sangriaHiddenJS');
/*
			nSpan.style.position='absolute';
			nSpan.style.top=(sangriaParent.offsetTop)+'px';
			nSpan.style.left=(sangriaParent.offsetLeft)+'px';
*/
			var h=0;
			nSpan.style.fontSize='1px';
			while(nSpan.offsetHeight<2*sangriaParent.offsetHeight)
			{
				nSpan.style.fontSize=parseInt(nSpan.style.fontSize)+1+'px';
			}
			sangriaParent.style.position='relative';
			sangriaParent.style.overflow='hidden';
			sangriaParent.style.marginTop=-nSpan.offsetHeight+'px';

			espacio=document.createElement('span');
			
			//espacio.style.backgroundColor='blue';
			espacio.style.width=nSpan.offsetWidth+5+'px';
			espacio.style.height=nSpan.offsetHeight-2*(sangriaParent.offsetTop-nSpan.offsetTop)+'px';
			//espacio.style.height=(+nSpan.offsetHeight)+'px';

			window.console.log('T + H Sangria:'+(sangriaParent.offsetTop+sangriaParent.offsetHeight))
			window.console.log('T + H nSpan:'+(nSpan.offsetTop+nSpan.offsetHeight))

			sangriaParent.insertBefore(espacio , sangriaParent.childNodes[0]);

			//window.console.log('Ancho: '+sWidth+' ; Alto:'+sHeight);


		}
	}
/*
	letraCap=document.getElementsByTagName('span')
	if(letraCap.length)
	{
		for(i=0;i<letraCap.length;i++)
		{
			letraCap[i].getElementsByClassName('sangria')[0];

			textNode=false;
			while(textNode)
			{

			}
		}
	}
*/
}