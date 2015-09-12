<?php namespace Radic\Tests\BladeExtensions;

use Caffeinated\Dev\Testing\AbstractTestCase;
use Caffeinated\Dev\Testing\Traits\ViewTester;
use Collective\Html\HtmlServiceProvider;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
abstract class TestCase extends AbstractTestCase
{
    use ViewTester;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
    }

    /** @var array */
    public static $data;

    /**
     * @return DataGenerator
     */
    public static function getData()
    {
        if (!isset(static::$data)) {
            static::$data = new DataGenerator();
        }
        return static::$data;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory
     */
    public function view()
    {
        return $this->app[ 'view' ];
    }

    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return 'Radic\BladeExtensions\BladeExtensionsServiceProvider';
    }

    protected function getPackageRootPath()
    {
        return realpath(__DIR__ . '/..');
    }

    /**
     * Adds assertion directives to blade and removes cached views
     */
    protected function loadViewTesting()
    {
        $this->addViewTesting(true, __DIR__ . '/views');
        $this->cleanViews();
    }

    protected function registerBladeMarkdownServiceProvider()
    {
        $this->app->register('Radic\BladeExtensions\Providers\MarkdownServiceProvider'); //new MarkdownServiceProvider($this->app));
    }
}
