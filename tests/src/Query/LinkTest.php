<?php

namespace SP\Spiderling\Test\Integration;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Query\Link;
use SP\Spiderling\Query\Filters;
use SP\PhpunitDomConstraints\DomConstraintsTrait;
use SP\Spiderling\Test\Crawler;

/**
 * @coversDefaultClass SP\Spiderling\Query\Link
 */
class QueryLinkTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    public function dataMatchers()
    {
        return [
            ['Subpage 1', 1, 'a[href="/test_functest/subpage1"]'],
            ['Subpage 2', 1, 'a[href="/test_functest/subpage2"]'],
            ['navlink-3', 1, 'a[href="/test_functest/subpage3"]'],
            ['Subpage Title 1', 1, 'a[href="/test_functest/subpage1"]'],
            ['icon 3', 1, 'a[href="/test_functest/subpage3"]'],
        ];
    }

    /**
     * @dataProvider dataMatchers
     * @covers  ::getType
     * @covers  ::getMatchers
     */
    public function testMatchers($selector, $expectedCount, $expected)
    {
        $index = new Crawler('index.html');

        $query = new Link($selector, new Filters());
        $result = $index->query($query->getXPath());

        $this->assertEquals($expectedCount, $result->length);

        $this->assertMatchesSelector(
            $expected,
            $result->item(0),
            sprintf('Link "%s" should match "%s"', $selector, $expected)
        );
    }
}
