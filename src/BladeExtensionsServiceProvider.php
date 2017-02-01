<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
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

        $this->app['blade-extensions.directives']->hookToCompiler();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-extensions.php', 'blade-extensions');

        $this->registerDirectiveRegistry();

        $this->registerHelperRepository();

        $this->registerBladeExtensions();

        $this->registerAliases();
    }

    protected function registerBladeExtensions()
    {
        $this->app->singleton('blade-extensions', function ($app) {
            return new BladeExtensions($app['blade-extensions.directives'], $app['blade-extensions.helpers']);
        });
    }

    protected function registerDirectiveRegistry()
    {
        $this->app->singleton('blade-extensions.directives', function ($app) {
            $directives = new DirectiveRegistry($app);
            $directives->register($app['config']['blade-extensions.directives']);
            $directives->setMode($app['config']['blade-extensions.mode']);

            return $directives;
        });
    }

    protected function registerHelperRepository()
    {
        $this->app->singleton('blade-extensions.helpers', function ($app) {
            $helpers = new HelperRepository();
            $helpers->put('loop', $app->build(Helpers\Loop\LoopHelper::class));
            $helpers->put('embed', $app->build(Helpers\Embed\EmbedHelper::class));
            $helpers->put('minifier', $app->build(Helpers\Minifier\MinifierHelper::class));
            $helpers->put('markdown', $app->build(Helpers\Markdown\MarkdownHelper::class));

            return $helpers;
        });
    }

    protected function registerAliases()
    {
        $aliases = [
            'blade-extensions'            => [BladeExtensions::class, Contracts\BladeExtensions::class],
            'blade-extensions.directives' => [DirectiveRegistry::class, Contracts\DirectiveRegistry::class],
            'blade-extensions.helpers'    => [HelperRepository::class, Contracts\HelperRepository::class],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }
}
