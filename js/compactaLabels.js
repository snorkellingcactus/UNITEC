function stringIsEmpty(texto)
{
	var texto=texto.replace(/\s/g , '');
	return texto==='';
}
function labelBlur()
{
	if(stringIsEmpty(this.value))
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
function labelChange()
{
	if(stringIsEmpty(this.value))
	{
		labelBlur.bind(this)();
	}
	else
	{
		labelFocus.bind(this)();
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

				if(!stringIsEmpty(input.value))
				{
					labelFocus.bind(input)();
				}

				input.onfocus=labelFocus;
				input.onblur=labelBlur;
				input.onchange=labelChange;
			}

			removeBootstrap(labelAct)
			labelAct.classList.add('compacto');
		}
	}
}