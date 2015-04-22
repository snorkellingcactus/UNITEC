function rmAttr(obj , attr , valor)
{
	var str=obj.getAttribute(attr);

	if(str===null)
	{
		return;
	}
	var index=str.indexOf(valor);

	if(index!==-1)
	{
		str=str.replace(valor , '');
	}

	obj.removeAttribute(attr);

	if(new RegExp(/\S/).exec(str))
	{
		obj.setAttribute(attr,str);
	}
}
//Le da foco al elemento resaltado.
function reFocus()
{
	window.console.log('reFocus');

	ele=document.getElementsByClassName('noblur')[0]

	if(ele)
	{
		ele.focus();

		rmAttr(ele , 'class' , 'noblur');
	}
}
//Devuelve un elemento resaltado (si lo está) a su estado normal.
function normaliza(event)
{
	window.console.log('normaliza');

	var ele=event.target;
	var clase=ele.getAttribute('class');

	if(clase===null)
	{
		return;
	}

	//Si tiene como clase a noblur, se la quito y le devuelvo el foco en 30ms
	//Esto es así porque no se encontró una forma funcional alternativa.
	if(clase.indexOf('noblur')!==-1)
	{
		setTimeout(reFocus , 20);
	}
}
function addAttr(ele , attr , valor)
{
	var clase=ele.getAttribute(attr)||'';
	
	if(clase.length)
	{
		clase+=' ';
	}
	ele.setAttribute(attr, clase+valor);
}
//Le agrega la clase resalta al elemento target del evento.
function resalta(event)
{
	window.console.log('resalta');

	var ele=event.target;

	var eleAnt=document.getElementsByClassName('resalta')[0];	//Elemento resaltado anterior.

	//Si había un elemento resaltado, lo devuelvo a su estado normal.
	if(eleAnt)
	{
		if(ele===eleAnt)
		{
			return 1;
		}
		rmAttr(eleAnt , 'class' , 'resalta');
	}
	addAttr(ele , 'class' , 'resalta');

	var clase=ele.getAttribute('class');

	if(clase!==null && clase.indexOf('noblur')===-1)
	{
		addAttr(ele , 'class' , 'noblur');
	}

	ele.focus();
}
//Configura las cuestiones visuales y de accesibilidad del menú.
function cargaMenu()
{
	//Colecciono los menúes navegables.
	var navs=document.getElementsByTagName('nav');
	for(var i=0;i<navs.length;i++)
	{
		//Si tiene height=0 es porque no está activo.
		if(navs[i].offsetHeight===0)
		{
			continue;
		}

		var links=navs[i].getElementsByTagName('a');	//Colecciono las opciones del menú.
		var hash=window.location.hash;

		//Si no hay hash, resalto el primer elemento del menú.
		resalta({target:links[0]});

		//Agrego eventos necesarios a los links.
		for(var j=0;j<links.length;j++)
		{
			var link=links[j];

			//Si la opción coincide con el hash, la resalto.
			if(hash.length && link.getAttribute('href').indexOf(hash)!==-1)
			{
				resalta({target:links[j]});
			}

			link.addEventListener('click',resalta);
			//link.addEventListener('focus',resalta);

			link.addEventListener('blur',normaliza);
		}
	}

}