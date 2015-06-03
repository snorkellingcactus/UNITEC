<?php

namespace JBBCode;

require_once 'CodeDefinition.php';
require_once 'CodeDefinitionBuilder.php';
require_once 'CodeDefinitionSet.php';
require_once 'validators/CssColorValidator.php';
require_once 'validators/UrlValidator.php';
require_once 'validators/SizeParser.php';

/**
 * Provides a default set of common bbcode definitions.
 *
 * @author jbowens
 */
class MainCodeDefinitionSet implements CodeDefinitionSet
{

    /* The default code definitions in this set. */
    protected $definitions = array();

    /**
     * Constructs the default code definitions.
     */
    public function __construct()
    {
        /* [b] bold tag */
        $builder = new CodeDefinitionBuilder('b', '<strong>{param}</strong>');
        array_push($this->definitions, $builder->build());

        /* [i] italics tag */
        $builder = new CodeDefinitionBuilder('i', '<em>{param}</em>');
        array_push($this->definitions, $builder->build());

        /* [u] underline tag */
        $builder = new CodeDefinitionBuilder('u', '<u>{param}</u>');
        array_push($this->definitions, $builder->build());

        $urlValidator = new \JBBCode\validators\UrlValidator();

        /* [url] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a href="{param}">{param}</a>');
        $builder->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [url=http://example.com] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a href="{option}">{param}</a>');
        $builder->setUseOption(true)->setParseContent(true)->setOptionValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [img] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" />');
        $builder->setUseOption(false)->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [img=alt text] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" alt="{option}" />');
        $builder->setUseOption(true)->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [color] color tag */
        $builder = new CodeDefinitionBuilder('color', '<span style="color: {option}">{param}</span>');
        $builder->setUseOption(true)->setOptionValidator(new \JBBCode\validators\CssColorValidator());
        array_push($this->definitions, $builder->build());

        //::::::::::CENTER:::::::::::::::
        $builder = new CodeDefinitionBuilder('center', '<span class="center">{param}</span>');
        array_push($this->definitions, $builder->build());

        //::::::::::SIZE:::::::::::::::
        $builder = new CodeDefinitionBuilder('size', '<font style="font-size:{option}px">{param}</font>');
        $builder->setUseOption(true)->setOptionParser(new \JBBCode\validators\SizeParser());

        array_push($this->definitions, $builder->build());

        //::::::::::FONT:::::::::::::::
        $builder = new CodeDefinitionBuilder('font', '<font family="{option}">{param}</font>');
        $builder->setUseOption(true);
        array_push($this->definitions, $builder->build());

        //::::::::::SUP:::::::::::::::
        $builder = new CodeDefinitionBuilder('sup', '<sup>{param}</sup>');
        array_push($this->definitions, $builder->build());

        //::::::::::SUB:::::::::::::::
        $builder = new CodeDefinitionBuilder('sub', '<sub>{param}</sub>');
        array_push($this->definitions, $builder->build());

        //::::::::::QUOTE:::::::::::::::
        $builder = new CodeDefinitionBuilder('quote', '<blockquote>{param}</blockquote>');
        array_push($this->definitions, $builder->build());

        //::::::::::CODE:::::::::::::::
        $builder = new CodeDefinitionBuilder('code', '<pre class="code">{param}</pre>');
        array_push($this->definitions, $builder->build());

        //::::::::::S:::::::::::::::
        $builder = new CodeDefinitionBuilder('s', '<font class="through">{param}</font>');
        array_push($this->definitions, $builder->build());

        //::::::::::TABLE:::::::::::::::
        $builder = new CodeDefinitionBuilder('table', '<table>{param}</table>');
        array_push($this->definitions, $builder->build());

        //::::::::::TR:::::::::::::::
        $builder = new CodeDefinitionBuilder('tr', '<tr>{param}</tr>');
        array_push($this->definitions, $builder->build());

        //::::::::::TD:::::::::::::::
        $builder = new CodeDefinitionBuilder('td', '<td>{param}</td>');
        array_push($this->definitions, $builder->build());

        //::::::::::VIDEO:::::::::::::::
        $builder = new CodeDefinitionBuilder('video', '<iframe src="https://www.youtube.com/embed/{param}" frameborder="0" allowfullscreen></iframe>');
        array_push($this->definitions, $builder->build());
    }

    /**
     * Returns an array of the default code definitions.
     */
    public function getCodeDefinitions() 
    {
        return $this->definitions;
    }

}
