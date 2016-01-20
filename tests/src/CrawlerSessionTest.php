<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\CrawlerSession;
use GuzzleHttp\Psr7\Uri;

/**
 * @coversDefaultClass SP\Spiderling\CrawlerSession
 */
class CrawlerSessionTest extends PHPUnit_Framework_TestCase
{
    private $crawler;
    private $session;

    public function setUp()
    {
        $this->crawler = $this->getMock('SP\Spiderling\CrawlerInterface');
        $this->session = new CrawlerSession($this->crawler);
    }

    /**
     * @covers ::__construct
     * @covers ::getCrawler
     */
    public function testConstruct()
    {
        $session = new CrawlerSession($this->crawler);

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
        $uri = new Uri('https://example.com');

        $this->crawler
            ->expects($this->exactly(2))
            ->method('open')
            ->with($uri);

        $this->session->open($uri);
        $this->session->open((string) $uri);
    }

    /**
     * @covers ::getUri
     */
    public function testGetUri()
    {
        $uri = new Uri('https://example.com');

        $this->crawler
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($uri);

        $this->assertSame($uri, $this->session->getUri());
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
     * @covers ::saveHtml
     */
    public function testSaveHtml()
    {
        $html = '<a href="/close.html"></a>';

        $this->crawler
            ->expects($this->once())
            ->method('getFullHtml')
            ->willReturn($html);

        $filename = tempnam(sys_get_temp_dir(), 'saveHtml');

        $this->session->saveHtml($filename, 'https://example.com');

        $this->assertContains(
            '<a href="https://example.com/close.html"></a>',
            file_get_contents($filename),
            'Should convert the link to absolute, using the base provided'
        );

        unlink($filename);
    }

}
