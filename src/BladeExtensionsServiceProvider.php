<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 1:40 AM.
 */

namespace Radic\BladeExtensions;

use Illuminate\Support\ServiceProvider;

class BladeExtensionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/blade-extensions.php' => config_path('blade-extensions.php'),
        ], 'config');

        $this->app['blade-extensions']->hookToCompiler();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-extensions.php', 'blade-extensions');

        $this->app->singleton('blade-extensions.directives', function ($app) {
            return new DirectiveRegistry($app);
        });
        $this->app->singleton('blade-extensions.helpers', function ($app) {
            return new HelperRepository();
        });
        $this->app->singleton('blade-extensions', function ($app) {
            $config = $app['config']['blade-extensions'];

            $factory = new Hooker($app, $app['blade-extensions.directives'], $app['blade-extensions.helpers']);
            $factory->setMode($config['mode']);

            $factory->getDirectives()->register($config['directives']);

            $helpers = $factory->getHelpers();
            $helpers->put('loop', $app->build(Helpers\Loop\LoopHelper::class));
            $helpers->put('embed', $app->build(Helpers\Embed\EmbedHelper::class));
            $helpers->put('minifier', $app->build(Helpers\Minifier\MinifierHelper::class));
            $helpers->put('markdown', $app->build(Helpers\Markdown\MarkdownHelper::class));

            return $factory;
        });
    }
}
