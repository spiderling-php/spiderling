<?php

namespace SP\Spiderling;

use Psr\Http\Message\UriInterface;
use GuzzleHttp\Psr7\Uri;
use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class CrawlerSession
{
    use TraverseTrait;

    /**
     * CrawlerInterface
     */
    private $crawler;

    /**
     * @param CrawlerInterface $crawler
     */
    public function __construct(CrawlerInterface $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param  Query\AbstractQuery $query
     * @return array
     */
    public function queryIds(Query\AbstractQuery $query)
    {
        return $this->crawler->queryIds($query);
    }

    /**
     * @return CrawlerInterface
     */
    public function getCrawler()
    {
        return $this->crawler;
    }

    /**
     * @param  string $uri
     * @return self
     */
    public function open($uri)
    {
        $uri = \GuzzleHttp\Psr7\uri_for($uri);

        $this->crawler->open($uri);

        return $this;
    }

    /**
     * @return UriInterface
     */
    public function getUri()
    {
        return $this->crawler->getUri();
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->crawler->getFullHtml();
    }

    /**
     * Save the HTML of the session into a file
     * Optionally resolve all the links with a base uri
     *
     * @param  string              $filename
     * @throws InvalidArgumentException if directory doesnt exist or is not writable
     * @param  UriInterface|string $base
     */
    public function saveHtml($filename, $base = null)
    {
        $this->ensureWritableDirectory(dirname($filename));

        $html = new Html($this->getHtml());

        if (null !== $base) {
            $html->resolveLinks(\GuzzleHttp\Psr7\uri_for($base));
        }

        file_put_contents($filename, $html->get());

        return $this;
    }

    /**
     * @param  string  $directory
     * @return boolean
     */
    public function isWritableDirectory($directory)
    {
        return is_dir($directory) && is_writable($directory);
    }

    /**
     * @param  string $directory
     * @throws InvalidArgumentException if directory doesnt exist or is not writable
     */
    public function ensureWritableDirectory($directory)
    {
        if (false === $this->isWritableDirectory($directory)) {
            throw new InvalidArgumentException(sprintf(
                'Make sure directory %s exists and is writable',
                $directory
            ));
        }
    }
}
