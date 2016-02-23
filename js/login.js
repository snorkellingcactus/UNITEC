loginBox=document.getElementsByClassName('LoginBox')[0];

if(loginBox)
{
	compactaLabels
	(
		login=loginBox.getElementsByClassName('FormCliLogin')[0]
	);

	lHeight=loginBox.offsetHeight;
	hHeight=document.getElementsByClassName('header')[0].offsetHeight;

	loginBox.style.position='relative';
	loginBox.style.top=loginBox.style.left=50+'%';

	loginBox.style.position='absolute';
	loginBox.style.marginLeft=-(loginBox.offsetWidth/2)+'px';
	loginBox.style.marginTop=-(lHeight/2)+'px';
	loginBox.style.height=lHeight+'px';
}