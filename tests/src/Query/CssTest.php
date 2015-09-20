<?php

namespace SP\Spiderling\Test\Integration;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Query\Css;
use SP\Spiderling\Query\Filters;
use SP\PhpunitDomConstraints\DomConstraintsTrait;
use SP\Spiderling\Test\Crawler;

/**
 * @coversDefaultClass SP\Spiderling\Query\Css
 */
class CssTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    public function dataMatchers()
    {
        return [
            ['.content .subnav', 1, 'ul.subnav'],
            ['form[action="/test_functest/contact"]', 1, '#form'],
            ['.content .subnav > li > a', 3, 'a.navlink'],
            ['#index', 1, 'div#index'],
            ['.page p', 3, 'p#p-1'],
        ];
    }

    /**
     * @dataProvider dataMatchers
     * @covers  ::getXPath
     */
    public function testMatchers($selector, $expectedCount, $expected)
    {
        $index = new Crawler('index.html');

        $query = new Css($selector, new Filters());
        $result = $index->query($query->getXPath());

        $this->assertEquals($expectedCount, $result->length);

        $this->assertMatchesSelector(
            $expected,
            $result->item(0),
            sprintf('Css "%s" should match "%s"', $selector, $expected)
        );
    }
}
