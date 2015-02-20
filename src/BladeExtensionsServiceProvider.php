<?php namespace Radic\BladeExtensions;

use Illuminate\Support\ServiceProvider;
use Radic\BladeExtensions\Directives\ForeachDirective;
use Radic\BladeExtensions\Directives\MacroDirective;
use Radic\BladeExtensions\Directives\PartialDirective;
use Radic\BladeExtensions\Directives\VariablesDirective;
use Radic\BladeExtensions\Providers\MarkdownServiceProvider;

/**
 * Class BladeExtensionsServiceProvider
 *
 * @package        Radic\BladeExtensions
 * @version        2.0.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class BladeExtensionsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boots the services provided. Attaches the blade extensions to the current Application's - ViewEnvironment
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/blade-extensions.php';
        $this->publishes([$configPath => config_path('blade-extensions.php')], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/blade-extensions.php';
        $this->mergeConfigFrom($configPath, 'blade-extensions');

        VariablesDirective::attach($this->app);
        ForeachDirective::attach($this->app);
        PartialDirective::attach($this->app);

        # Optional macro directives
        if (array_key_exists('form', $this->app->getBindings()))
        {
            MacroDirective::attach($this->app);
        }

        # Optional markdown compiler, engines and directives
        if (class_exists('\Ciconia\Ciconia') && $this->app['config']->get('blade-extensions.markdown.enabled'))
        {
            $this->app->register(new MarkdownServiceProvider($this->app));
        }
    }
}
