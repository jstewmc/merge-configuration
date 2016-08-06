<?php
/**
 * The file for the configuration interface
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2016 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\SquashConfigDirectory;

/**
 * The configuration interface
 *
 * @since  0.1.0
 */
interface Config
{
    /* !Public methods */ 
    
    /**
     * Merges a configuration array into the configuration
     *
     * @param   mixed[]  $config  the configuration array to merge
     * @return  Config
     * @since   0.1.0
     */
    public function merge(array $config);
}
