<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Testing\Traits\BladeViewTestingTrait;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 *
 */
class MacrosDirectivesTest extends TestCase
{
    use BladeViewTestingTrait;

    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
    }

    public function testMacros()
    {
        $this->registerHtml();
        $this->registerBlade();
        $this->assertEquals('my age is3', $this->view->make('macro')->render());
        $this->assertEquals('my age is 6', $this->view->make('macro2')->render());
        $this->assertEquals('patatmy age is3', $this->view->make('macro3')->render());
    }
}
