<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\BrowserSession;
use SP\Spiderling\Session;
use SP\Spiderling\Query\Filters;

/**
 * @coversDefaultClass SP\Spiderling\TraverseTrait
 */
class TraverseTraitTest extends PHPUnit_Framework_TestCase
{
    private $traverse;
    private $crawler;

    public function setUp()
    {
        $this->traverse = $this->getMockForTrait('SP\Spiderling\TraverseTrait');
        $this->crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
        $this->traverse
            ->method('getCrawler')
            ->willReturn($this->crawler);
    }

    public function assertNodes($ids, array $nodes)
    {
        $this->assertCount(count($ids), $nodes);
        $this->assertContainsOnlyInstancesOf('SP\Spiderling\Node', $nodes);

        foreach ($ids as $index => $id) {
            $this->assertEquals($this->crawler, $nodes[$index]->getCrawler());
            $this->assertEquals($id, $nodes[$index]->getId());
        }
    }

    public function assertNode($id, $node)
    {
        $this->assertInstanceOf('SP\Spiderling\Node', $node);
        $this->assertEquals($this->crawler, $node->getCrawler());
        $this->assertEquals($id, $node->getId());
    }

    public function expectsQueryIds($ids, $class, $selector, Filters $filters)
    {
        $this->traverse
            ->expects($this->once())
            ->method('queryIds')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf($class),
                    $this->attributeEqualTo('selector', $selector),
                    $this->attribute($this->identicalTo($filters), 'filters')
                )
            )
            ->willReturn($ids);
    }

    /**
     * @covers ::newNode
     */
    public function testNewNode()
    {
        $id = '10';
        $node = $this->traverse->newNode($id);

        $this->assertNode($id, $node);
    }

    /**
     * @covers ::newEmptyNode
     */
    public function testNewEmptyNode()
    {
        $node = $this->traverse->newEmptyNode();

        $this->assertInstanceOf('SP\Spiderling\EmptyNode', $node);
        $this->assertEquals($this->crawler, $node->getCrawler());
    }

    /**
     * @covers ::query
     */
    public function testQuery()
    {
        $ids = ['10', '20'];

        $query = $this
            ->getMockBuilder('SP\Spiderling\Query\AbstractQuery')
            ->disableOriginalConstructor()
            ->getMock();

        $this->traverse
            ->expects($this->once())
            ->method('queryIds')
            ->with($this->identicalTo($query))
            ->willReturn($ids);

        $result = $this->traverse->query($query);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::queryFirst
     */
    public function testQueryFirst()
    {
        $ids = ['12', '13'];

        $query = $this
            ->getMockBuilder('SP\Spiderling\Query\AbstractQuery')
            ->disableOriginalConstructor()
            ->getMock();

        $this->traverse
            ->expects($this->once())
            ->method('queryIds')
            ->with($this->identicalTo($query))
            ->willReturn($ids);

        $result = $this->traverse->queryFirst($query);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getArray
     */
    public function testGetArray()
    {
        $ids = ['1', '2'];
        $selector = 'css selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Css', $selector, $filters);

        $result = $this->traverse->getArray($selector, $filters);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getLinkArray
     */
    public function testGetLinkArray()
    {
        $ids = ['1', '2'];
        $selector = 'link selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Link', $selector, $filters);

        $result = $this->traverse->getLinkArray($selector, $filters);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getButtonArray
     */
    public function testGetButtonArray()
    {
        $ids = ['1', '2'];
        $selector = 'button selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Button', $selector, $filters);

        $result = $this->traverse->getButtonArray($selector, $filters);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getFieldArray
     */
    public function testGetFieldArray()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector, $filters);

        $result = $this->traverse->getFieldArray($selector, $filters);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getLabelArray
     */
    public function testGetLabelArray()
    {
        $ids = ['1', '2'];
        $selector = 'label selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Label', $selector, $filters);

        $result = $this->traverse->getLabelArray($selector, $filters);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::get
     */
    public function testGet()
    {
        $ids = ['1', '2'];
        $selector = 'css selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Css', $selector, $filters);

        $result = $this->traverse->get($selector, $filters);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getLink
     */
    public function testGetLink()
    {
        $ids = ['1', '2'];
        $selector = 'link selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Link', $selector, $filters);

        $result = $this->traverse->getLink($selector, $filters);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getButton
     */
    public function testGetButton()
    {
        $ids = ['1', '2'];
        $selector = 'button selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Button', $selector, $filters);

        $result = $this->traverse->getButton($selector, $filters);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getField
     */
    public function testGetField()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector, $filters);

        $result = $this->traverse->getField($selector, $filters);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getLabel
     */
    public function testGetLabel()
    {
        $ids = ['1', '2'];
        $selector = 'label selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Label', $selector, $filters);

        $result = $this->traverse->getLabel($selector, $filters);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::clickButton
     */
    public function testClickButton()
    {
        $ids = ['1', '2'];
        $selector = 'button selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Button', $selector, $filters);

        $this->crawler
            ->expects($this->once())
            ->method('click')
            ->with($ids[0]);

        $this->traverse->clickButton($selector, $filters);
    }

    /**
     * @covers ::clickLink
     */
    public function testClickLink()
    {
        $ids = ['1', '2'];
        $selector = 'link selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Link', $selector, $filters);

        $this->crawler
            ->expects($this->once())
            ->method('click')
            ->with($ids[0]);

        $this->traverse->clickLink($selector, $filters);
    }

    /**
     * @covers ::clickOn
     */
    public function testClickOn()
    {
        $ids = ['1', '2'];
        $selector = 'css selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Css', $selector, $filters);

        $this->crawler
            ->expects($this->once())
            ->method('click')
            ->with($ids[0]);

        $this->traverse->clickOn($selector, $filters);
    }

    /**
     * @covers ::setField
     */
    public function testSetField()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';
        $value = 'new value';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector, $filters);

        $this->crawler
            ->expects($this->once())
            ->method('setValue')
            ->with($ids[0], $value);

        $this->traverse->setField($selector, $value, $filters);
    }

    /**
     * @covers ::check
     */
    public function testCheck()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector, $filters);

        $this->crawler
            ->expects($this->once())
            ->method('setValue')
            ->with($ids[0], true);

        $this->traverse->check($selector, $filters);
    }

    /**
     * @covers ::uncheck
     */
    public function testUncheck()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';
        $filters = new Filters();

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector, $filters);

        $this->crawler
            ->expects($this->once())
            ->method('setValue')
            ->with($ids[0], false);

        $this->traverse->uncheck($selector, $filters);
    }

    public function dataSelect()
    {
        return [
            ['select', true],
            ['unselect', false],
        ];
    }

    /**
     * @covers ::select
     * @covers ::unselect
     * @dataProvider dataSelect
     */
    public function testSelect($method, $expected)
    {
        $ids = ['1', '2'];
        $ids2 = ['3', '4'];
        $selector = 'field selector';
        $filters = new Filters();

        $session = new Session($this->crawler);

        $this->crawler
            ->expects($this->at(0))
            ->method('queryIds')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf('SP\Spiderling\Query\Field'),
                    $this->attributeEqualTo('selector', $selector),
                    $this->attribute($this->identicalTo($filters), 'filters')
                )
            )
            ->willReturn($ids);

        $this->crawler
            ->expects($this->at(1))
            ->method('queryIds')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf('SP\Spiderling\Query\Css'),
                    $this->attributeEqualTo('selector', 'option'),
                    $this->attributeEqualTo('filters', new Filters(['text' => 'option text']))
                ),
                $ids[0]
            )
            ->willReturn($ids2);

        $this->crawler
            ->expects($this->at(2))
            ->method('setValue')
            ->with($ids2[0], $expected);

        $session->$method($selector, 'option text', $filters);
    }

}
