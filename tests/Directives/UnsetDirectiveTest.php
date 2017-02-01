<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Tests\BladeExtensions\DirectivesTestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class UnsetDirectiveTest extends DirectivesTestCase
{
    /**
     * getDirectiveClass method
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\UnsetDirective';
    }

    /**
     * Test the set directive
     */
    public function testView()
    {
        $this->render('directives.unset', [
            'dataString'        => 'hello',
            'dataArray'         => static::getData()->getValues()[ 'names' ],
            'dataClassInstance' => static::getData(),
            'dataClassName'     => 'DataGenerator'
        ]);
    }
}
