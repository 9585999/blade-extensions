<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0
 */

namespace Radic\Tests\BladeExtensions;

use Laradic\Testing\Laravel\Traits\ViewTester;

/**
 * Class ViewTest.
 *
 * @author     Robin Radic
 * {@inheritdoc}
 */
abstract class TestCase extends \Laradic\Testing\Laravel\AbstractTestCase
{
    use ViewTester;

    /** {@inheritdoc} */
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
        if (! isset(static::$data)) {
            static::$data = new DataGenerator();
        }

        return static::$data;
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
        return realpath(__DIR__.'/..');
    }

    public function testTest()
    {
        $this->assertTrue(true);
    }
}
