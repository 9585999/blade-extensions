<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license   https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

class BladeExtensions
{
    /** @var \Illuminate\View\Compilers\BladeCompiler */
    protected $compiler;

    /** @var \Radic\BladeExtensions\DirectiveRegistry */
    protected $directives;

    /** @var \Radic\BladeExtensions\HelperRepository */
    protected $helpers;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    /** @var bool */
    protected $hooked = false;

    /** @var string */
    protected $mode;

    /** @var \Closure|null */
    protected $customModeHandler;

    /** @var string */
    protected $cachePath;

    /**
     * BladeExtensions constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Radic\BladeExtensions\DirectiveRegistry     $directives
     * @param \Radic\BladeExtensions\HelperRepository      $helpers
     * @param \Illuminate\View\Compilers\BladeCompiler     $compiler
     */
    public function __construct(DirectiveRegistry $directives, HelperRepository $helpers)
    {
        $this->directives = $directives;
        $this->helpers = $helpers;
        $this->fs = new Filesystem;
        $this->cachePath = storage_path('blade-extensions');
    }

    /**
     * getCompiler method.
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    protected function getCompiler()
    {
        if (! isset($this->compiler)) {
            if ($this->fs->exists($this->cachePath) === false) {
                $this->fs->makeDirectory($this->cachePath);
            }
            $this->compiler = new BladeCompiler($this->fs, $this->cachePath);
        }

        return $this->compiler;

    }

    public function compileString($string, array $vars = [], $tmpfile = false)
    {
        $fileName = uniqid('compileString', true).'.php';
        $filePath = $this->cachePath.DIRECTORY_SEPARATOR.$fileName;
        $string = $this->getCompiler()->compileString($string);
        $this->fs->put($filePath, $string);
        $compiledString = $this->getCompiledContent($filePath, $vars);
        $this->fs->delete($filePath);

        return $compiledString;
    }

    protected function getCompiledContent($filePath, array $vars = [])
    {
        if (is_array($vars) && ! empty($vars)) {
            extract($vars, EXTR_OVERWRITE);
        }
        ob_start();
        include $filePath;
        $var = ob_get_contents();
        ob_end_clean();

        return $var;
    }

    /**
     * @return bool
     */
    public function isHooked()
    {
        return $this->hooked;
    }

    /**
     * @return \Radic\BladeExtensions\DirectiveRegistry
     */
    public function getDirectives()
    {
        return $this->directives;
    }

    /**
     * @return \Radic\BladeExtensions\HelperRepository
     */
    public function getHelpers()
    {
        return $this->helpers;
    }

    /**
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function setCustomModeHandler($handler)
    {
        $this->customModeHandler = $handler;
    }
}
