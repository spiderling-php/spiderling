<?php

namespace SP\Spiderling\Query\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Query\Filters;

/**
 * @coversDefaultClass SP\Spiderling\Query\Filters
 */
class FiltersTest extends PHPUnit_Framework_TestCase
{
    private $crawler;

    public function setUp()
    {
        $this->crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
    }

    /**
     * @covers ::__construct
     * @covers ::all
     * @covers ::getPatterns
     */
    public function testConstruct()
    {
        $items = ['text' => 'text', 'visible' => 'true'];
        $filters = new Filters($items);

        $this->assertEquals($items, $filters->all());

        $patterns = Filters::getPatterns();

        $this->assertEquals(Filters::TEXT, $patterns['text']);
        $this->assertEquals(Filters::VISIBLE, $patterns['visible']);
        $this->assertEquals(Filters::VALUE, $patterns['value']);
    }

    public function dataPattern()
    {
        return [
            [Filters::TEXT, 'test', false],
            [Filters::TEXT, 'test:text("my my")', 'my my'],
            [Filters::TEXT, 'test:text("my \'my\'")', 'my \'my\''],
            [Filters::TEXT, "test:text('my \\'my\\'')", "my \\'my\\'"],
            [Filters::VALUE, 'test', false],
            [Filters::VALUE, 'test:value("my my")', 'my my'],
            [Filters::VALUE, 'test:value("my \'my\'")', 'my \'my\''],
            [Filters::VALUE, "test:value('my \\'my\\'')", "my \\'my\\'"],
            [Filters::VISIBLE, 'test', false],
            [Filters::VISIBLE, 'test:visible(true)', 'true'],
            [Filters::VISIBLE, 'test:visible(false)', 'false'],
            [Filters::VISIBLE, 'test:visible(on)', 'on'],
            [Filters::VISIBLE, 'test:visible(off)', 'off'],
            [Filters::VISIBLE, 'test:visible(1)', '1'],
            [Filters::VISIBLE, 'test:visible(0)', '0'],
        ];
    }

    /**
     * @dataProvider dataPattern
     * @coversNothing
     */
    public function testPattern($pattern, $selector, $expected)
    {

        if (false === $expected) {
            $this->assertNotRegExp($pattern, $selector);
        } else {
            $this->assertRegExp($pattern, $selector);

            preg_match($pattern, $selector, $matches);

            $this->assertEquals($expected, $matches[2], 'Should extract value into match 2');
        }
    }

    /**
     * @covers ::extractPattern
     */
    public function testExtractPattern()
    {
        $filters = new Filters();

        $selector = 'test some:value("my")';

        $result = $filters->extractPattern('value', Filters::VALUE, $selector);

        $this->assertEquals('test some', $result);

        $this->assertEquals(['value' => 'my'], $filters->all());

        $result = $filters->extractPattern('visible', Filters::VISIBLE, $result);

        $this->assertEquals(
            'test some',
            $result,
            'Should not change selector if no match is found'
        );

        $this->assertEquals(['value' => 'my'], $filters->all());

    }

    /**
     * @covers ::extractAllPatterns
     */
    public function testExtractAllPattern()
    {
        $filters = $this
            ->getMockBuilder('SP\Spiderling\Query\Filters')
            ->setMethods(['extractPattern'])
            ->getMock();

        $filters
            ->expects($this->at(0))
            ->method('extractPattern')
            ->with('text', Filters::TEXT, 'test one')
            ->willReturn('test two');

        $filters
            ->expects($this->at(1))
            ->method('extractPattern')
            ->with('value', Filters::VALUE, 'test two')
            ->willReturn('test three');

        $filters
            ->expects($this->at(2))
            ->method('extractPattern')
            ->with('visible', Filters::VISIBLE, 'test three')
            ->willReturn('test four');

        $selector = 'test one';

        $result = $filters->extractAllPatterns($selector);

        $this->assertEquals(
            'test four',
            $result,
            'Should go through all three patterns and return the last'
        );
    }

    /**
     * @covers ::match
     */
    public function testMatch()
    {
        $crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
        $id = '10';

        $filters = $this
            ->getMockBuilder('SP\Spiderling\Query\Filters')
            ->setMethods(['text', 'value', 'visible'])
            ->setConstructorArgs([['text' => 'test1', 'value' => 'test2', 'visible' => 'test3']])
            ->getMock();

        $filters
            ->expects($this->at(0))
            ->method('text')
            ->with($crawler, $id, 'test1')
            ->willReturn(true);

        $filters
            ->expects($this->at(1))
            ->method('value')
            ->with($crawler, $id, 'test2')
            ->willReturn(true);

        $filters
            ->expects($this->at(2))
            ->method('visible')
            ->with($crawler, $id, 'test3')
            ->willReturn(true);

        $result = $filters->match($crawler, $id);

        $this->assertTrue($result);
    }

    /**
     * @covers ::matchAll
     */
    public function testMatchAll()
    {
        $crawler = $this->getMock('SP\Spiderling\CrawlerInterface');

        $ids = ['10', '20', '32'];
        $expected = ['10', '32'];

        $filters = $this->getMock('SP\Spiderling\Query\Filters', ['isEmpty', 'match']);

        $filters
            ->expects($this->once())
            ->method('isEmpty')
            ->willReturn(false);

        $filters
            ->expects($this->exactly(3))
            ->method('match')
            ->will($this->returnValueMap([
                [$crawler, '10', true],
                [$crawler, '20', false],
                [$crawler, '32', true]
            ]));

        $result = $filters->matchAll($crawler, $ids);

        $this->assertSame($expected, $result);
    }

    /**
     * @covers ::matchAll
     */
    public function testMatchAllEmpty()
    {
        $crawler = $this->getMock('SP\Spiderling\CrawlerInterface');

        $ids = ['10', '20', '32'];

        $filters = $this->getMock('SP\Spiderling\Query\Filters', ['isEmpty', 'match']);

        $filters
            ->expects($this->once())
            ->method('isEmpty')
            ->willReturn(true);

        $filters
            ->expects($this->never())
            ->method('match');

        $result = $filters->matchAll($crawler, $ids);

        $this->assertSame($ids, $result);
    }

    /**
     * @covers ::isEmpty
     */
    public function testIsEmpty()
    {
        $filters = new Filters(['text' => 'test']);

        $this->assertFalse($filters->isEmpty());

        $filters = new Filters();

        $this->assertTrue($filters->isEmpty());
    }

    /**
     * @covers ::match
     */
    public function testMatchFalse()
    {
        $crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
        $id = '10';

        $filters = $this
            ->getMockBuilder('SP\Spiderling\Query\Filters')
            ->setMethods(['text', 'value', 'visible'])
            ->setConstructorArgs([['text' => 'test1']])
            ->getMock();

        $filters
            ->expects($this->once())
            ->method('text')
            ->with($crawler, $id, 'test1')
            ->willReturn(false);

        $result = $filters->match($crawler, $id);

        $this->assertFalse($result);
    }

    public function dataValue()
    {
        return [
            ['test', true],
            ['other', false],
        ];
    }

    /**
     * @dataProvider dataValue
     * @covers ::value
     */
    public function testValue($value, $expected)
    {
        $id = '10';

        $this->crawler
            ->expects($this->once())
            ->method('getValue')
            ->with($id)
            ->willReturn('test');

        $filters = new Filters();

        $this->assertSame($expected, $filters->value($this->crawler, $id, $value));
    }

    public function dataVisible()
    {
        return [
            ['true', true],
            ['false', false],
            ['yes', true],
            ['no', false],
            ['on', true],
            ['off', false],
            ['1', true],
            ['0', false],
            [true, true],
            [false, false],
        ];
    }

    /**
     * @dataProvider dataVisible
     * @covers ::visible
     */
    public function testVisible($visible, $expected)
    {
        $id = '10';

        $this->crawler
            ->expects($this->once())
            ->method('isVisible')
            ->with($id)
            ->willReturn(true);

        $filters = new Filters();

        $this->assertSame($expected, $filters->visible($this->crawler, $id, $visible));
    }

    public function dataText()
    {
        return [
            ['some', true],
            ['text', true],
            ['some text', true],
            ['abra', false],
        ];
    }

    /**
     * @dataProvider dataText
     * @covers ::text
     */
    public function testText($text, $expected)
    {
        $id = '10';

        $this->crawler
            ->expects($this->once())
            ->method('getText')
            ->with($id)
            ->willReturn('Some text here');

        $filters = new Filters();

        $this->assertSame($expected, $filters->text($this->crawler, $id, $text));
    }
}
