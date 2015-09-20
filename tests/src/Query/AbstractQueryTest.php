<?php

namespace SP\Spiderling\Query\Test;

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
}
