<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\BrowserSession;
use SP\Spiderling\Session;

/**
 * @coversDefaultClass SP\Spiderling\TraverseTrait
 */
class TraverseTraitTest extends PHPUnit_Framework_TestCase
{
    private $traverse;
    private $session;

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

    public function expectsQueryIds($ids, $class, $selector)
    {
        $this->traverse
            ->expects($this->once())
            ->method('queryIds')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf($class),
                    $this->attributeEqualTo('selector', $selector)
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

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Css', $selector);

        $result = $this->traverse->getArray($selector);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getLinkArray
     */
    public function testGetLinkArray()
    {
        $ids = ['1', '2'];
        $selector = 'link selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Link', $selector);

        $result = $this->traverse->getLinkArray($selector);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getButtonArray
     */
    public function testGetButtonArray()
    {
        $ids = ['1', '2'];
        $selector = 'button selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Button', $selector);

        $result = $this->traverse->getButtonArray($selector);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getFieldArray
     */
    public function testGetFieldArray()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector);

        $result = $this->traverse->getFieldArray($selector);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::getLabelArray
     */
    public function testGetLabelArray()
    {
        $ids = ['1', '2'];
        $selector = 'label selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Label', $selector);

        $result = $this->traverse->getLabelArray($selector);

        $this->assertNodes($ids, $result);
    }

    /**
     * @covers ::get
     */
    public function testGet()
    {
        $ids = ['1', '2'];
        $selector = 'css selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Css', $selector);

        $result = $this->traverse->get($selector);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getLink
     */
    public function testGetLink()
    {
        $ids = ['1', '2'];
        $selector = 'link selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Link', $selector);

        $result = $this->traverse->getLink($selector);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getButton
     */
    public function testGetButton()
    {
        $ids = ['1', '2'];
        $selector = 'button selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Button', $selector);

        $result = $this->traverse->getButton($selector);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getField
     */
    public function testGetField()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector);

        $result = $this->traverse->getField($selector);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::getLabel
     */
    public function testGetLabel()
    {
        $ids = ['1', '2'];
        $selector = 'label selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Label', $selector);

        $result = $this->traverse->getLabel($selector);

        $this->assertNode($ids[0], $result);
    }

    /**
     * @covers ::clickButton
     */
    public function testClickButton()
    {
        $ids = ['1', '2'];
        $selector = 'button selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Button', $selector);

        $this->crawler
            ->expects($this->once())
            ->method('click')
            ->with($ids[0]);

        $this->traverse->clickButton($selector);
    }

    /**
     * @covers ::clickLink
     */
    public function testClickLink()
    {
        $ids = ['1', '2'];
        $selector = 'link selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Link', $selector);

        $this->crawler
            ->expects($this->once())
            ->method('click')
            ->with($ids[0]);

        $this->traverse->clickLink($selector);
    }

    /**
     * @covers ::clickOn
     */
    public function testClickOn()
    {
        $ids = ['1', '2'];
        $selector = 'css selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Css', $selector);

        $this->crawler
            ->expects($this->once())
            ->method('click')
            ->with($ids[0]);

        $this->traverse->clickOn($selector);
    }

    /**
     * @covers ::setField
     */
    public function testSetField()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';
        $value = 'new value';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector);

        $this->crawler
            ->expects($this->once())
            ->method('setValue')
            ->with($ids[0], $value);

        $this->traverse->setField($selector, $value);
    }

    /**
     * @covers ::check
     */
    public function testCheck()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector);

        $this->crawler
            ->expects($this->once())
            ->method('setValue')
            ->with($ids[0], true);

        $this->traverse->check($selector);
    }

    /**
     * @covers ::uncheck
     */
    public function testUncheck()
    {
        $ids = ['1', '2'];
        $selector = 'field selector';

        $this->expectsQueryIds($ids, 'SP\Spiderling\Query\Field', $selector);

        $this->crawler
            ->expects($this->once())
            ->method('setValue')
            ->with($ids[0], false);

        $this->traverse->uncheck($selector);
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

        $session = new Session($this->crawler);

        $this->crawler
            ->expects($this->at(0))
            ->method('queryIds')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf('SP\Spiderling\Query\Field'),
                    $this->attributeEqualTo('selector', $selector)
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
                    $this->attribute(
                        $this->attributeEqualTo('filters', ['text' => 'option text']),
                        'filters'
                    )
                ),
                $ids[0]
            )
            ->willReturn($ids2);

        $this->crawler
            ->expects($this->at(2))
            ->method('setValue')
            ->with($ids2[0], $expected);

        $session->$method($selector, 'option text');
    }

}
