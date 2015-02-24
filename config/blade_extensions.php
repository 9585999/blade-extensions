<?php
/**
 * Part of Radic - Blade Extensions
 *
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2015, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 */

return array(
    /*
     * Blacklisting of directives. These directives will not be extended. Example:
     *
     * 'blacklist' => array('foreach', 'set', 'debug')
     */
    'blacklist' => array(),

    'markdown' => array(
        'renderer' => 'Radic\BladeExtensions\Renderers\ParsedownRenderer', // ciconia, parsedown
        'enabled' => true,
        'views' => true,
        'gfm' => true // parsedown always uses gfm, ciconia has optional gfm support
    ),
    /*
     * The replacement code for each directive.
     * Provides the ability to easily adjust helper classes and view execution logic
     */
    'directives' => array(
        // MacroDirective
        'doMacro' => <<<'EOT'
<?php
if(array_key_exists("form", $__env->getContainer()->getBindings())){
    echo app("form")->$1($2);
} ?>
EOT
        ,'openMacro' => <<<'EOT'
<?php
if(array_key_exists("form", $__env->getContainer()->getBindings())){
    app("form")->macro("$1", function($2){
EOT
        ,'closeMacro' => <<<'EOT'
    });
} ?>
EOT
        // ForEachDirective
        ,'openForeach' => <<<'EOT'
<?php
\Radic\BladeExtensions\Helpers\LoopFactory::newLoop($1);
foreach($1 as $2):
    $loop = \Radic\BladeExtensions\Helpers\LoopFactory::loop();
?>
EOT
        ,'closeForeach' => <<<'EOT'
$1<?php
\Radic\BladeExtensions\Helpers\LoopFactory::looped();
endforeach;
\Radic\BladeExtensions\Helpers\LoopFactory::endLoop($loop);
?>$2
EOT
        ,'addBreak' => <<<'EOT'
$1<?php
    break;
?>$2
EOT
        ,'addContinue' => <<<'EOT'
$1<?php
\Radic\BladeExtensions\Helpers\LoopFactory::looped();
continue;
?>$2
EOT
        // PartialDirective
        ,'addPartial' => <<<'EOT'
$1<?php \Radic\BladeExtensions\Helpers\Partial::renderPartial$2,
get_defined_vars(), function($file, $vars) use ($__env) {
        $vars = array_except($vars, array('__data', '__path'));
        extract($vars); ?>
EOT
        ,'endPartial' => <<<'EOT'
$1<?php echo $__env->make($file, $vars)->render(); }); ?>$2
EOT
        ,'openBlock' => <<<'EOT'
$1<?php \Radic\BladeExtensions\Helpers\Partial::startBlock$2; ?>
EOT
        ,'endBlock' => <<<'EOT'
$1<?php \Radic\BladeExtensions\Helpers\Partial::stopBlock(); ?>$2
EOT
        ,'addRender' => <<<'EOT'
$1<?php echo \Radic\BladeExtensions\Helpers\Partial::renderBlock$2; ?>
EOT
        // VariablesDirective
        ,'addSet' => <<<'EOT'
<?php \$$1 = $2; ?>
EOT
        ,'addUnset' => <<<'EOT'
<?php unset(\$$1); ?>
EOT
        ,'addDebug' => <<<'EOT'
<h1>DEBUG OUTPUT:</h1>
<pre><code>
    <?php (class_exists('Kint') ? Kint::dump($1) : var_dump($1)) ?>
</code></pre>
EOT
        ,'openMarkdown' => <<<'EOT'
$1<?php echo \Radic\BladeExtensions\Helpers\Markdown::parse(<<<'EOT'$2
EOT
        ,'includeMarkdown' => <<<'EOT'
\n<?php include('$1'); ?>
EOT
        ,'closeMarkdown' => "$1\nEOT\n); ?>$2"




    )
);
