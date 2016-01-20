<?php

namespace SP\Spiderling;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use DOMDocument;
use DOMXPath;
use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Html
{
    /**
     * @var DOMDocument
     */
    private $document;

    /**
     * @var DOMXPath
     */
    private $xpath;

    /**
     * @param string $html
     */
    public function __construct($html)
    {
        $this->document = new DOMDocument();
        $this->document->loadHtml($html);
        $this->xpath = new DOMXPath($this->document);
    }

    /**
     * @param  string       $attribute
     * @param  UriInterface $base
     */
    private function resolveLinkAttribute($attribute, UriInterface $base)
    {
        $elements = $this->xpath->query(
            "//*[@$attribute and not(contains(@$attribute, \"://\"))]"
        );

        foreach ($elements as $element) {
            try {
                $resolved = Uri::resolve($base, $element->getAttribute($attribute));
                $element->setAttribute($attribute, $resolved->__toString());
            } catch (InvalidArgumentException $e) {
                // Tolerate invalid urls
            }
        }
    }

    /**
     * Add a prefix to all relative links (src, href and action)
     *
     * @param  UriInterface $base
     */
    public function resolveLinks(UriInterface $base)
    {
        $this->resolveLinkAttribute('href', $base);
        $this->resolveLinkAttribute('src', $base);
        $this->resolveLinkAttribute('action', $base);

        return $this;
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->document->saveHtml();
    }
}
