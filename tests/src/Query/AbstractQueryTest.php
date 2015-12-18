<?php

namespace SP\Spiderling\Query\Test;

use SP\Spiderling\Query;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass SP\Spiderling\Query\AbstractQuery
 */
class AbstractQueryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getSelector
     * @covers ::getFilters
     */
    public function testConstruct()
    {
        $selector = 'test selector';
        $filters = $this
            ->getMockBuilder('SP\Spiderling\Query\Filters')
            ->setMethods(['extractAllPatterns'])
            ->getMock();

        $filters
            ->expects($this->once())
            ->method('extractAllPatterns')
            ->with($selector)
            ->willReturn('test');

        $query = $this
            ->getMockBuilder('SP\Spiderling\Query\AbstractQuery')
            ->setConstructorArgs([$selector, $filters])
            ->setMethods(['getXPath'])
            ->getMock();

        $this->assertEquals(
            'test',
            $query->getSelector(),
            'Should use extractAllPatterns on the selector'
        );

        $this->assertEquals($filters, $query->getFilters());
    }

    public function dataToString()
    {
        return [
            [new Query\Button('test'), '[Button: test]'],
            [new Query\Css('.big:text(orange)'), '[Css: .big:text(orange)]'],
        ];
    }

    /**
     * @covers ::__toString
     * @dataProvider dataToString
     */
    public function testToString($query, $expected)
    {
        $this->assertEquals($expected, (string) $query);
    }
}
