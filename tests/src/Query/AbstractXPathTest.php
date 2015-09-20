<?php

namespace SP\Spiderling\Query\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Query\Filters;

/**
 * @coversDefaultClass SP\Spiderling\Query\AbstractXPath
 */
class AbstractXPathTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getXPath
     */
    public function testConstruct()
    {
        $selector = 'test';
        $expected = '//*[(testtype) and (match1(test) or match2(test) or match3(test))]';

        $query = $this
            ->getMockBuilder('SP\Spiderling\Query\AbstractXPath')
            ->setConstructorArgs([$selector, new Filters()])
            ->setMethods(['getType', 'getMatchers'])
            ->getMock();

        $query
            ->method('getType')
            ->willReturn('testtype');

        $query
            ->method('getMatchers')
            ->willReturn(['match1(%s)', 'match2(%s)', 'match3(%s)']);

        $this->assertEquals($expected, $query->getXPath());
    }
}
