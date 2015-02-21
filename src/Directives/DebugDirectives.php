<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Variable manipulation directives like `set`, `unset`, `debug`
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Directives
 * @version        2.0.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class DebugDirectives
{

    use BladeExtenderTrait;


    /**
     * Adds `set` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addBreakpoint($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('breakpoint');

        return preg_replace($matcher, $configured, $value);
    }
    
    /**
     * Adds `debug` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addDebug($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/@debug(?:s?)\(([^()]+)*\)/';

        return preg_replace($matcher, $configured, $value);
    }
}
