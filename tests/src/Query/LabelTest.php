<?php

namespace SP\Spiderling\Test\Integration;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Query\Label;
use SP\Spiderling\Query\Filters;
use SP\PhpunitDomConstraints\DomConstraintsTrait;
use SP\Spiderling\Test\Crawler;


/**
 * @coversDefaultClass SP\Spiderling\Query\Label
 */
class QueryLabelTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    public function dataMatchers()
    {
        return [
            ['Enter Country', 1, 'label[for=country]'],
            ['Logo Image', 1, 'label[for=file]'],
            ['Logo Title', 1, 'label[for=file]'],
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

        $query = new Label($selector, new Filters());
        $result = $index->query($query->getXPath());

        $this->assertMatchesSelector(
            $expected,
            $result[0],
            sprintf('Label "%s" should match "%s"', $selector, $expected)
        );
    }
}
