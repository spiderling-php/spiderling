<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\EmptyNode;
use SP\Spiderling\Query;

/**
 * @coversDefaultClass SP\Spiderling\EmptyNode
 */
class EmptyNodeTest extends PHPUnit_Framework_TestCase
{
    private $crawler;
    private $node;

    public function setUp()
    {
        $this->crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
        $this->node = new EmptyNode($this->crawler);
    }

    /**
     * @covers ::__construct
     * @covers ::getCrawler
     * @covers ::getId
     */
    public function testConstruct()
    {
        $node = new EmptyNode($this->crawler);

        $this->assertSame($this->crawler, $node->getCrawler());
        $this->assertSame(null, $node->getId());
    }

    /**
     * @covers ::queryIds
     */
    public function testQueryIds()
    {
        $query = $this
            ->getMockBuilder('SP\Spiderling\Query\AbstractQuery')
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->node->queryIds($query);

        $this->assertEquals([], $result);
    }

    /**
     * @covers ::getAttribute
     */
    public function testGetAttribute()
    {
        $this->assertNull($this->node->getAttribute('name'));
    }

    /**
     * @covers ::getHtml
     */
    public function testGetHtml()
    {
        $this->assertNull($this->node->getHtml());
    }

    /**
     * @covers ::getText
     */
    public function testGetText()
    {
        $this->assertNull($this->node->getText());
    }

    /**
     * @covers ::setValue
     */
    public function testSetValue()
    {
        $node = new EmptyNode($this->crawler, new Query\Css('#input'));

        $this->setExpectedException('DomainException', 'Cannot set value, element not found: [Css: #input]');

        $node->setValue('10');
    }

    /**
     * @covers ::setFile
     */
    public function testSetFile()
    {
        $node = new EmptyNode($this->crawler, new Query\Field('Logo'));

        $this->setExpectedException('DomainException', 'Cannot set file, element not found: [Field: Logo]');

        $node->setFile('example.jpg');
    }

    /**
     * @covers ::getValue
     */
    public function testGetValue()
    {
        $this->assertNull($this->node->getValue());
    }

    /**
     * @covers ::isVisible
     */
    public function testIsVisible()
    {
        $this->assertFalse($this->node->isVisible());
    }

    /**
     * @covers ::isSelected
     */
    public function testIsSelected()
    {
        $this->assertFalse($this->node->isSelected());
    }

    /**
     * @covers ::isChecked
     */
    public function testIsChecked()
    {
        $this->assertFalse($this->node->isChecked());
    }

    /**
     * @covers ::select
     */
    public function testSelect()
    {
        $node = new EmptyNode($this->crawler, new Query\Css('option#name'));

        $this->setExpectedException('DomainException', 'Cannot select, element not found: [Css: option#name]');

        $node->select();
    }

    /**
     * @covers ::click
     */
    public function testClick()
    {
        $node = new EmptyNode($this->crawler, new Query\Button('new btn:text(orange)'));

        $this->setExpectedException('DomainException', 'Cannot click, element not found: [Button: new btn:text(orange)]');

        $node->click();
    }

}
