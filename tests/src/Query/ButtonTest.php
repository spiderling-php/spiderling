<?php

namespace SP\Spiderling\Test\Integration;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Query\Button;
use SP\Spiderling\Query\Filters;
use SP\Spiderling\Test\Crawler;
use SP\PhpunitDomConstraints\DomConstraintsTrait;

/**
 * @coversDefaultClass SP\Spiderling\Query\Button
 */
class ButtonTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    public function dataMatchers()
    {
        return [
            ['submit input', 1, 'input#submit'],
            ['Submit Item', 1, 'input#submit'],
            ['submit', 1, 'input#submit'],
            ['Submit Button', 1, 'button#submit-btn'],
            ['submit-btn', 1, 'button#submit-btn'],
            ['Submit Image', 1, 'button#submit-btn-icon'],
            ['Image Title', 1, 'button#submit-btn-icon'],
            ['submit-btn-icon', 1, 'button#submit-btn-icon'],
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

        $query = new Button($selector, new Filters());
        $result = $index->query($query->getXPath());

        $this->assertEquals($expectedCount, $result->length);

        $this->assertMatchesSelector(
            $expected,
            $result[0],
            sprintf('Button "%s" should match "%s"', $selector, $expected)
        );
    }

}
