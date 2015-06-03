<?php

namespace JBBCode\validators;

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'OptionParser.php';

/**
 * An InputValidator for CSS color values. This is a very rudimentary
 * validator. It will allow a lot of color values that are invalid. However,
 * it shouldn't allow any invalid color values that are also a security
 * concern.
 *
 * @author jbowens
 * @since May 2013
 */
class SizeParser implements \JBBCode\OptionParser
{

    /**
     * Returns true if $input uses only valid CSS color value
     * characters.
     *
     * @param $input  the string to validate
     */
    public function parse($input)
    {
        return (intVal($input)/10)+10;
    }
}
