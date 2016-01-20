<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Html;
use GuzzleHttp\Psr7\Uri;
use DOMDocument;
use DOMXPath;

/**
 * @coversDefaultClass SP\Spiderling\Html
 */
class HtmlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $filename = __DIR__.'/../html/index.html';
        $html = new Html(file_get_contents($filename));

        $content = new DOMDocument();
        $content->loadHtmlFile($filename);

        $this->assertEquals($content->saveHtml(), $html->get());
    }

    /**
     * @covers ::resolveLinks
     * @covers ::resolveLinkAttribute
     * @covers ::get
     */
    public function testResolveLinks()
    {
        $html = new Html(file_get_contents(__DIR__.'/../html/index.html'));

        $result = $html
            ->resolveLinks(new Uri('http://google.com:9090'))
            ->get();

        $content = new DOMDocument();
        $content->loadHtml($result);
        $xpath = new DOMXPath($content);

        $this->assertEquals(
            'http://google.com:9090/test_functest/subpage1',
            $xpath->query('//a[@id="navlink-1"]')->item(0)->getAttribute('href'),
            'Links href should be resolved with base'
        );

        $this->assertEquals(
            'http://google.com:9090/Logo.png',
            $xpath->query('//img[@alt="Logo Image"]')->item(0)->getAttribute('src'),
            'Img src should be resolved with base'
        );

        $this->assertEquals(
            'http://google.com:9090/test_functest/contact',
            $xpath->query('//form')->item(0)->getAttribute('action'),
            'Img src should be resolved with base'
        );
    }
}
