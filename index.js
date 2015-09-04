head.load('jsCols.css');

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
function addAttr(ele , attr , valor)
{
	var clase=ele.getAttribute(attr)||'';
	
	if(clase.length)
	{
		clase+=' ';
	}
	ele.setAttribute(attr, clase+valor);
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
		var hash=encodeURIComponent(window.location.hash.replace('#',''));

		//Si no hay hash, resalto el primer elemento del menú.
		resalta({target:links[0]});
		rmAttr(links[0] , 'class' , 'noblur');

		window.console.log(links[0]);

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
function removeBootstrap(ele)
{	
	var j=0;
	var iMax=ele.classList.length;
	for(var i=0;i<iMax;i++)
	{
		if(ele.classList[j].indexOf('col-')!==-1)
		{
			ele.classList.remove(ele.classList[j]);
		}
		else
		{
			j++
		}
	}
}

function labelBlur()
{
	var texto=this.value.replace(/\s/g , '');
	if(texto==='')
	{
		this.value='';
		this.parentNode.getElementsByTagName('label')[0].style.zIndex='5';
	}
	//this.addEventListener('focus',labelFocus);
}
function labelFocus()
{
	this.parentNode.getElementsByTagName('label')[0].style.zIndex='1';
	//this.addEventListener('blur',labelBlur);
}
function compactaLabels(ele)
{
	if(!ele)
	{
		ele=document;
	}
	var labelConts=ele.getElementsByClassName('label');

	for(var i=0;i<labelConts.length;i++)
	{
		var labelContAct=labelConts[i];

		var labelAct=labelContAct.getElementsByTagName('label')[0];
		var input=labelContAct.getElementsByTagName('input');

		if(!input.length)
		{
			input=labelContAct.getElementsByTagName('textarea');
		}
		if(labelAct)
		{
			if(input.length)
			{
				input=input[0];
				removeBootstrap(input);
				input.classList.add('compacto');

				input.onfocus=labelFocus;
				input.onblur=labelBlur;
			}

			removeBootstrap(labelAct)
			labelAct.classList.add('compacto');
		}
	}
}
function getActive()
{
	window.console.log(document.activeElement);
	window.timerGetActive=setTimeout(getActive,500);
}
function stopActive()
{
	clearTimeout(window.timerGetActive);
}
function langSwitching(ele)
{
	
}
function quitFocusOnFirst(event)
{
	if(quitFocus(event , true))
	{
		this.removeEventListener('keydown' , quitFocusOnFirst);
	}
}
function quitFocusOnLast(event)
{
	if(quitFocus(event , false))
	{
		this.removeEventListener('keydown' , quitFocusOnLast);
	}
}
function quitFocusOnEsc(event)
{
	if(event.keyCode===27)
	{
		document.getElementsByClassName('focus')[0].classList.remove('focus');

		this.removeEventListener('keydown' , quitFocusOnEsc);
		event.target.blur();
	}
}
function quitFocus(event , shift)
{
	window.console.log(event);
	//window.console.log('Captando tecla en primer elemento');

	if(event.keyCode===9)
	{
		//window.console.log('La tecla es Tab');

		if(event.shiftKey===shift)
		{
			//window.console.log('Shift = '+shift+'. El menú se va a cerrar');

			document.getElementsByClassName('focus')[0].classList.remove('focus');
			document.body.removeEventListener('keydown' , quitFocusOnEsc);
		}
		return 1;
	}

	return 0;
}
function inicializa()
{
	var hijos=document.getElementsByClassName('header')[0].getElementsByTagName('ul')[0].getElementsByTagName('a');

	hijos[hijos.length-1].addEventListener
	(
		'focus',
		function()
		{
			this.parentNode.parentNode.classList.add('focus');
			
			document.body.addEventListener
			(
				'keydown',
				quitFocusOnEsc
			);
			document.body.addEventListener
			(
				'keydown',
				quitFocusOnLast
			);
		}
	);

	hijos[0].addEventListener
	(
		'focus',
		function()
		{
			this.parentNode.parentNode.classList.add('focus');
			
			document.body.addEventListener
			(
				'keydown',
				quitFocusOnEsc
			);
			document.body.addEventListener
			(
				'keydown',
				quitFocusOnFirst
			);
		}
	);
}