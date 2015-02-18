<?php namespace Radic\BladeExtensionsTests;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Html\HtmlServiceProvider;
use Mockery as m;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Traits\BladeViewTestingTrait;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 *
 */
class TestCase extends BaseTestCase
{
    use BladeViewTestingTrait;

    /**
     * @var TestData
     */
    protected $data;

    public function setUp()
    {
        parent::setUp();
        $this->data = new TestData();
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Adds assertion directives to blade and removes cached views
     */
    protected function loadViewTesting()
    {
        $this->addBladeViewTesting(__DIR__ . '/views');
        \File::delete(\File::glob(base_path('storage/framework/views') . '/*'));
    }

    /**
     * Registers the HtmlServiceProvider required for the macro directives
     */
    protected function registerHtml()
    {
        $this->app->register(new HtmlServiceProvider($this->app));
    }

    /**
     * Registers the BladeExtensionsServiceProvider
     */
    protected function registerBlade()
    {
        $this->app->register(new BladeExtensionsServiceProvider($this->app));
    }

    /**
     * Registers the IdeHelperServiceProvider and executes the ide-helper generate command
     */
    protected function generateIdeHelper()
    {
        $this->app->register(new IdeHelperServiceProvider($this->app));
        $this->getKernel()->call('ide-helper:generate');
    }

    /**
     * @return \Illuminate\Contracts\Console\Kernel
     */
    protected function getKernel()
    {
        return $this->app['Illuminate\Contracts\Console\Kernel'];
    }

    /**
     * Executes a kernel command
     *
     * @param string $command
     */
    protected function command($command)
    {
        $this->getKernel()->call($command);
    }
}
