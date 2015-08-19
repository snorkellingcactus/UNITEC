head.ready
(
	function()
	{
		CKEDITOR.editorConfig=function(cfg)
		{
			cfg.customConfig='';
			cfg.entities=false;
		}

		CKEDITOR.replaceAll
		(
			'ckeditorjs',
			function(nEditor , config)
			{
				window.console.log('Hello');
				nEditor.insertHtml(nEditor.element.innerHTML);
				nEditor.element.innerHTML='';

				config.customConfig='';
				config.entities=false;

				return true;
			}
		);
	}
);