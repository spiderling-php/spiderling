<?php

namespace SP\Spiderling\Test\Integration;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Query\Field;
use SP\Spiderling\Query\Filters;
use SP\PhpunitDomConstraints\DomConstraintsTrait;
use SP\Spiderling\Test\Crawler;

/**
 * @coversDefaultClass SP\Spiderling\Query\Field
 */
class QueryFieldTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    public function dataMatchers()
    {
        return [
            ['email', 1, 'input#email'],
            ['Enter Email', 1, 'input#email'],
            ['This is your email', 1, 'input#email'],
            ['name', 1, 'input#name'],
            ['message', 1, 'textarea#message'],
            ['Enter Message', 1, 'textarea#message'],
            ['country', 1, 'select#country'],
            ['Enter Country', 1, 'select#country'],
            ['submit', 0, null],
            ['gender', 2, 'input[type=radio][name=gender]'],
            ['Gender Male', 1, 'input[type=radio][name=gender][value=male]'],
            ['Gender Female', 1, 'input[type=radio][name=gender][value=female]'],
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

        $query = new Field($selector, new Filters());
        $result = $index->query($query->getXPath());

        if (null !== $expected) {
            $this->assertMatchesSelector(
                $expected,
                $result->item(0),
                sprintf('Field "%s" should match "%s"', $selector, $expected)
            );
        }
    }
}
