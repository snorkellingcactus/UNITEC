<?php

namespace JBBCode;
/**
 * Define una interfaz para parsear los valores de los atributos en el 
 * momento previo a reemplazarlos.
 *
 * @author Nadal Gonzalo García Zavala
 * @since May 2015
 */
interface OptionParser
{

    /**
     * Returns true iff the given input is valid, false otherwise.
     */
    public function parse($valor);

}
