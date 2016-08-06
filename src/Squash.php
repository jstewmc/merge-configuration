<?php
/**
 * The file for the squash-configuration-directory context
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2016 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\SquashConfigDirectory;

use DirectoryIterator;
use InvalidArgumentException;


/**
 * The squash-configuration-directory context
 *
 * @since  0.1.0
 */
class Squash
{    
    /* !Magic methods */
    
    /**
     * Squashes the configuration directory
     *
     * @param   string         $directory  the configuration directory
     * @param   Configuration  $config     the configuration result
     * @return  Configuration
     * @since   0.1.0
     */
    public function __invoke(string $directory, Config $config): Config
    {
        // if $directory is not readable, short-circuit
        if ( ! is_readable($directory)) {
            throw new InvalidArgumentException(
                __METHOD__."() expects parameter one, directory, to be readable"
            );
        }
        
        // otherwise, loop through the directory's items
        foreach (new DirectoryIterator($directory) as $item) {
            // if the item is a file
            if ($item->isFile()) {
                // merge the file's contents
                $config->merge(require $item->getPathname());
            }
        }

        return $config;
    }
}
