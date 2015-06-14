$(function()
	{
		var editor=document.getElementById("editor");
		
		wbb=new jQuery.wysibb
		(
			editor ,
			{
				resize_maxheight:600,
				buttons:"bold,italic,underline,strike,sup,sub,|,img,video,link,|,bullist,numlist,|,fontcolor,fontsize,fontfamily,|,justifyleft,justifycenter,justifyright,|,quote,code,table,removeFormat",
				allButtons:
				{
					numlist:
					{
						transform:
						{
							'<ol>{SELTEXT}</ol>':"[numlist]{SELTEXT}[/numlist]",
							'<li>{SELTEXT}</li>':"[*]{SELTEXT}[/*]"
						}
					}
				}
			}
		);


		/*
		var editorTextarea=document.getElementsByClassName('wysibb-text-editor')[0];
		editorTextarea.style.maxHeight="600px";
		*/
	}
 )