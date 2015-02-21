<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;


/**
 * Directives: set, unset
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @subpackage         Directives
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          (c) 2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class AssignmentDirectives
{

    use BladeExtenderTrait;

    /**
     * Adds `set` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addSet($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/@set\((?:\$|(?:\'))(.*?)(?:\'|),\s(.*)\)/';

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Adds `unset` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addUnset($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/@unset\((?:\$|(?:\'))(.*?)(?:\'|)\)/';

        return preg_replace($matcher, $configured, $value);
    }
}
