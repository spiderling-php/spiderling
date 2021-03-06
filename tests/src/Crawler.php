<?php

namespace SP\Spiderling\Test;

use DOMDocument;
use DOMXPath;
use SP\Spiderling\CrawlerInterface;
use SP\Spiderling\Query\AbstractQuery;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class Crawler implements CrawlerInterface
{
    /**
     * @var DOMDocument
     */
    private $document;

    /**
     * @var DOMXPath
     */
    private $xpath;

    public function __construct($file)
    {
        $file = __DIR__.'/../html/'.$file;

        $this->document = new DOMDocument('1.0', 'utf-8');
        $this->document->loadHTMLFile($file);
        $this->preserveWhiteSpace = false;
        $this->formatOutput = true;
        $this->xpath = new DOMXPath($this->document);
    }

    public function query($xpath)
    {
        return $this->xpath->query($xpath);
    }

    public function getElement($xpath)
    {
        return $this->query($xpath)->item(0);
    }

    public function open(UriInterface $url)
    {
        return null;
    }

    public function getUri()
    {
        return new Uri('');
    }

    public function getText($id)
    {
        $text = $this->getElement($id)->textContent;

        return preg_replace('/[ \s\f\n\r\t\v ]+/u', ' ', $text);
    }

    public function getTagName($id)
    {
        return $this->getElement($id)->tagName;
    }

    public function getAttribute($id, $name)
    {
        return $this->getElement($id)->getAttribute($name);
    }

    public function getHtml($id)
    {
        $node = $this->getElement($id);

        return $this->document->saveXml($node);
    }

    public function getFullHtml()
    {
        return $this->document->saveHtml();
    }

    public function getValue($id)
    {
        return $this->getElement($id)->getAttribute('value');
    }

    public function isVisible($id)
    {
        return true;
    }

    public function isSelected($id)
    {
        return false;
    }

    public function isChecked($id)
    {
        return false;
    }

    public function setValue($id, $value)
    {
        return $this->getElement($id)->setAttribute('value', $value);
    }

    public function setFile($id, $file)
    {
        return $this->getElement($id)->setAttribute('value', $file);
    }

    public function click($id)
    {
        return null;
    }

    public function select($id)
    {
        return null;
    }

    public function queryIds(AbstractQuery $query, $parent = null)
    {
        $xpath = $parent.$query->getXPath();

        $ids = [];

        foreach ($this->query($xpath) as $index => $element) {
            $ids []= "($xpath)[".($index+1)."]";
        }

        return $query->getFilters()->matchAll($this, $ids);
    }
}
