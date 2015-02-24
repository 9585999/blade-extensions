<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: macro, endmacro, domacro
 *
 * @package                Radic\BladeExtensions
 * @version                2.1.0
 * @subpackage             Directives
 * @author                 Robin Radic
 * @license                MIT License - http://radic.mit-license.org
 * @copyright          (c) 2011-2015, Robin Radic
 * @link                   http://robin.radic.nl/blade-extensions
 *
 */
class MacroDirectives
{
    use BladeExtenderTrait;


    /**
     * Starts `macro` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function openMacro($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/@macro\([\'"]([\w\d]*)[\'"],(.*)\)/';

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Ends `macro` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function closeMacro($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endmacro');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Adds `domacro` directive.
     * Executes a macro
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function doMacro($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/@domacro\([\'"]([\w\d]*)[\'"],(.*)\)/';

        return preg_replace($matcher, $configured, $value);
    }
}
