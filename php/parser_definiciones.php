<?php
	//::::::::::POR DEFECTO:::::::::::::::
	$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());

	//::::::::::CENTER:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('center', '<span class="center">{param}</span>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::SIZE:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('size', '<font size="{option}">{param}</font>');
	$builder->setUseOption(true);
	$parser->addCodeDefinition($builder->build());

	//::::::::::FONT:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('font', '<font family="{option}">{param}</font>');
	$builder->setUseOption(true);
	$parser->addCodeDefinition($builder->build());

	//::::::::::SUP:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('sup', '<sup>{param}</sup>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::SUB:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('sub', '<sub>{param}</sub>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::QUOTE:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('quote', '<blockquote>{param}</blockquote>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::CODE:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('code', '<pre class="code">{param}</pre>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::S:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('s', '<font class="through">{param}</font>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::TABLE:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('table', '<table>{param}</table>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::TR:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('tr', '<tr>{param}</tr>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::TD:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('td', '<td>{param}</td>');
	$parser->addCodeDefinition($builder->build());

	//::::::::::VIDEO:::::::::::::::
	$builder = new JBBCode\CodeDefinitionBuilder('video', '<iframe src="https://www.youtube.com/embed/{param}" frameborder="0" allowfullscreen></iframe>');
	$parser->addCodeDefinition($builder->build());
?>