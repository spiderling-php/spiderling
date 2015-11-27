<?php

namespace SP\Spiderling\Test;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\BrowserSession;
use SP\Spiderling\Node;

/**
 * @coversDefaultClass SP\Spiderling\BrowserSession
 */
class BrowserSessionTest extends PHPUnit_Framework_TestCase
{
    private $browser;
    private $session;

    public function setUp()
    {
        $this->browser = $this->getMock('SP\Spiderling\BrowserInterface');
        $this->session = new BrowserSession($this->browser);
    }

    /**
     * @covers ::__construct
     * @covers ::getBrowser
     */
    public function testConstruct()
    {
        $session = new BrowserSession($this->browser);

        $this->assertSame($this->browser, $session->getBrowser());
        $this->assertSame($this->browser, $session->getCrawler());
    }

    /**
     * @covers ::getAlertText
     */
    public function testGetAlertText()
    {
        $text = 'test';

        $this->browser
            ->expects($this->once())
            ->method('getAlertText')
            ->willReturn($text);

        $this->assertEquals($text, $this->session->getAlertText());
    }

    /**
     * @covers ::confirm
     */
    public function testConfirm()
    {
        $text = 'My confirm';

        $this->browser
            ->expects($this->once())
            ->method('confirm')
            ->with($text);

        $this->session->confirm($text);
    }

    /**
     * @covers ::removeAllCookies
     */
    public function testRemoveAllCookies()
    {
        $name = 'test';

        $this->browser
            ->expects($this->once())
            ->method('removeAllCookies');

        $this->session->removeAllCookies();
    }

    /**
     * @covers ::executeJs
     */
    public function testExecuteJs()
    {
        $js = 'console.log("test")';

        $this->browser
            ->expects($this->once())
            ->method('executeJs')
            ->with($js);

        $this->session->executeJs($js);
    }

    /**
     * @covers ::getJsErrors
     */
    public function testGetJsErrors()
    {
        $errors = ['1', '2'];

        $this->browser
            ->expects($this->once())
            ->method('getJsErrors')
            ->willReturn($errors);

        $this->assertEquals($errors, $this->session->getJsErrors());
    }

    /**
     * @covers ::getJsMessages
     */
    public function testGetJsMessages()
    {
        $errors = ['1', '2'];

        $this->browser
            ->expects($this->once())
            ->method('getJsMessages')
            ->willReturn($errors);

        $this->assertEquals($errors, $this->session->getJsMessages());
    }

    /**
     * @covers ::saveScreenshot
     */
    public function testSaveScreenshot()
    {
        $file = 'file.jpg';

        $this->browser
            ->expects($this->once())
            ->method('saveScreenshot')
            ->with($file);

        $this->session->saveScreenshot($file);
    }

    /**
     * @covers ::hoverNode
     */
    public function testHoverNode()
    {
        $node = new Node($this->browser, '10');

        $this->browser
            ->expects($this->once())
            ->method('moveMouseTo')
            ->with($node->getId());

        $this->session->hoverNode($node);
    }

    /**
     * @covers ::hover
     */
    public function testHover()
    {
        $id = '5';

        $this->browser
            ->expects($this->once())
            ->method('queryIds')
            ->with($this->isInstanceOf('SP\Spiderling\Query\Css'))
            ->willReturn([$id]);

        $this->browser
            ->expects($this->once())
            ->method('moveMouseTo')
            ->with($id);

        $this->session->hover('test');
    }

    /**
     * @covers ::hoverField
     */
    public function testHoverField()
    {
        $id = '5';

        $this->browser
            ->expects($this->once())
            ->method('queryIds')
            ->with($this->isInstanceOf('SP\Spiderling\Query\Field'))
            ->willReturn([$id]);

        $this->browser
            ->expects($this->once())
            ->method('moveMouseTo')
            ->with($id);

        $this->session->hoverField('test');
    }

    /**
     * @covers ::hoverButton
     */
    public function testHoverButton()
    {
        $id = '5';

        $this->browser
            ->expects($this->once())
            ->method('queryIds')
            ->with($this->isInstanceOf('SP\Spiderling\Query\Button'))
            ->willReturn([$id]);

        $this->browser
            ->expects($this->once())
            ->method('moveMouseTo')
            ->with($id);

        $this->session->hoverButton('test');
    }
}
