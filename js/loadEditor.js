head.ready
(
	function()
	{
		CKEDITOR.editorConfig=function(cfg)
		{
			cfg.customConfig='';
			cfg.entities=false;
			cfg.width="100%";
		}
		CKEDITOR.config.width="100%";

		CKEDITOR.replaceAll
		(
			'ckeditorjs',
			function(nEditor , config)
			{
				window.console.log('Hello');
				nEditor.insertHtml(nEditor.element.innerHTML);
				nEditor.element.innerHTML='';
				//nEditor.element.style.width="100%";

				config.customConfig='';
				config.entities=false;

				return true;
			}
		);
	}
);