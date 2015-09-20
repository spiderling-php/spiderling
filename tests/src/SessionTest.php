<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Session;

/**
 * @coversDefaultClass SP\Spiderling\Session
 */
class SessionTest extends PHPUnit_Framework_TestCase
{
    private $crawler;
    private $session;

    public function setUp()
    {
        $this->crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
        $this->session = new Session($this->crawler);
    }

    /**
     * @covers ::__construct
     * @covers ::getCrawler
     */
    public function testConstruct()
    {
        $session = new Session($this->crawler);

        $this->assertSame($this->crawler, $session->getCrawler());
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
            ->with($query)
            ->willReturn($ids);

        $this->session->queryIds($query);
    }

    /**
     * @covers ::newNode
     */
    public function testNewNode()
    {
        $id = '12';
        $node = $this->session->newNode($id);

        $this->assertInstanceOf('SP\Spiderling\Node', $node);
        $this->assertSame($id, $node->getId());
        $this->assertSame($this->crawler, $node->getCrawler());
    }

    /**
     * @covers ::newEmptyNode
     */
    public function testNewEmptyNode()
    {
        $node = $this->session->newEmptyNode();

        $this->assertInstanceOf('SP\Spiderling\EmptyNode', $node);
        $this->assertSame($this->crawler, $node->getCrawler());
    }

    /**
     * @covers ::open
     */
    public function testOpen()
    {
        $url = 'https://example.com';

        $this->crawler
            ->expects($this->once())
            ->method('open')
            ->with($url);

        $this->session->open($url);
    }

    /**
     * @covers ::getUrl
     */
    public function testGetUrl()
    {
        $url = 'https://example.com';

        $this->crawler
            ->expects($this->once())
            ->method('getUrl')
            ->willReturn($url);

        $this->assertEquals($url, $this->session->getUrl());
    }

    /**
     * @covers ::getPath
     */
    public function testGetPath()
    {
        $path = '/test';

        $this->crawler
            ->expects($this->once())
            ->method('getPath')
            ->willReturn($path);

        $this->assertEquals($path, $this->session->getPath());
    }

    /**
     * @covers ::getHtml
     */
    public function testGetHtml()
    {
        $html = '<div></div>';

        $this->crawler
            ->expects($this->once())
            ->method('getFullHtml')
            ->willReturn($html);

        $this->assertEquals($html, $this->session->getHtml());
    }

    /**
     * @covers ::getUserAgent
     */
    public function testGetUserAgent()
    {
        $userAgent = 'Mozzila';

        $this->crawler
            ->expects($this->once())
            ->method('getUserAgent')
            ->willReturn($userAgent);

        $this->assertEquals($userAgent, $this->session->getUserAgent());
    }

}
