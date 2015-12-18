<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\CrawlerSession;
use SP\Spiderling\Node;

/**
 * @coversDefaultClass SP\Spiderling\Node
 */
class NodeTest extends PHPUnit_Framework_TestCase
{
    private $crawler;
    private $session;
    private $node;

    public function setUp()
    {
        $this->crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
        $this->session = new CrawlerSession($this->crawler);
        $this->node = new Node($this->crawler, '10');
    }

    /**
     * @covers ::__construct
     * @covers ::getCrawler
     * @covers ::getId
     */
    public function testConstruct()
    {
        $node = new Node($this->crawler, '10');

        $this->assertSame($this->crawler, $node->getCrawler());
        $this->assertSame('10', $node->getId());
    }

    /**
     * @covers ::queryIds
     */
    public function testQueryIds()
    {
        $ids = ['1', '2'];

        $query = $this
            ->getMockBuilder('SP\Spiderling\Query\AbstractQuery')
            ->disableOriginalConstructor()
            ->getMock();

        $this->crawler
            ->expects($this->once())
            ->method('queryIds')
            ->with($query, $this->node->getId())
            ->willReturn($ids);

        $this->node->queryIds($query);
    }

    /**
     * @covers ::getAttribute
     */
    public function testGetAttribute()
    {
        $attribute = 'name';

        $this->crawler
            ->expects($this->once())
            ->method('getAttribute')
            ->with($this->node->getId(), $attribute)
            ->willReturn('test');

        $result = $this->node->getAttribute($attribute);

        $this->assertEquals('test', $result);
    }

    /**
     * @covers ::getTagName
     */
    public function testGetTagName()
    {
        $this->crawler
            ->expects($this->once())
            ->method('getTagName')
            ->with($this->node->getId())
            ->willReturn('test');

        $result = $this->node->getTagName();

        $this->assertEquals('test', $result);
    }

    /**
     * @covers ::with
     */
    public function testWith()
    {
        $this->node->with(function($node) {
            $this->assertEquals($this->node, $node);
        });
    }

    /**
     * @covers ::getHtml
     */
    public function testGetHtml()
    {
        $this->crawler
            ->expects($this->once())
            ->method('getHtml')
            ->with($this->node->getId())
            ->willReturn('test');

        $result = $this->node->getHtml();

        $this->assertEquals('test', $result);
    }

    /**
     * @covers ::getText
     */
    public function testGetText()
    {
        $this->crawler
            ->expects($this->once())
            ->method('getText')
            ->with($this->node->getId())
            ->willReturn('test');

        $result = $this->node->getText();

        $this->assertEquals('test', $result);
    }

    /**
     * @covers ::setValue
     */
    public function testSetValue()
    {
        $value = 'new value';

        $this->crawler
            ->expects($this->once())
            ->method('setValue')
            ->with($this->node->getId(), $value)
            ->willReturn('test');

        $this->node->setValue($value);
    }

    /**
     * @covers ::setFile
     */
    public function testSetFile()
    {
        $value = '/var/usr/example.jpg';

        $this->crawler
            ->expects($this->once())
            ->method('setFile')
            ->with($this->node->getId(), $value)
            ->willReturn('test');

        $this->node->setFile($value);
    }

    /**
     * @covers ::getValue
     */
    public function testGetValue()
    {
        $this->crawler
            ->expects($this->once())
            ->method('getValue')
            ->with($this->node->getId())
            ->willReturn('test');

        $result = $this->node->getValue();

        $this->assertEquals('test', $result);
    }

    /**
     * @covers ::isVisible
     */
    public function testIsVisible()
    {
        $this->crawler
            ->expects($this->once())
            ->method('isVisible')
            ->with($this->node->getId())
            ->willReturn(true);

        $result = $this->node->isVisible();

        $this->assertEquals(true, $result);
    }

    /**
     * @covers ::isSelected
     */
    public function testIsSelected()
    {
        $this->crawler
            ->expects($this->once())
            ->method('isSelected')
            ->with($this->node->getId())
            ->willReturn(true);

        $result = $this->node->isSelected();

        $this->assertEquals(true, $result);
    }

    /**
     * @covers ::isChecked
     */
    public function testIsChecked()
    {
        $this->crawler
            ->expects($this->once())
            ->method('isChecked')
            ->with($this->node->getId())
            ->willReturn(true);

        $result = $this->node->isChecked();

        $this->assertEquals(true, $result);
    }

    /**
     * @covers ::click
     */
    public function testClick()
    {
        $this->crawler
            ->expects($this->once())
            ->method('click')
            ->with($this->node->getId());

        $this->node->click();
    }

    /**
     * @covers ::select
     */
    public function testSelect()
    {
        $this->crawler
            ->expects($this->once())
            ->method('select')
            ->with($this->node->getId());

        $this->node->select();
    }

}
