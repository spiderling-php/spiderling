<?php

namespace SP\Spiderling\Query;

use SP\Spiderling\CrawlerInterface;

class Filters
{
    /**
     * @var array
     */
    private $filters;

    /**
     * Matches :text(value), where value is a double or single quoted string
     * Supports single or double quotes escaping inside
     *
     * http://regexr.com/3bqg1
     * http://stackoverflow.com/questions/249791/regex-for-quoted-string-with-escaping-quotes
     */
    const TEXT = '/:text\((["\'])((?:[^\1\\\\]|\\\\.)*?)\1\)/';

    /**
     * Matches :value(value), where value is a double or single quoted string
     * Supports single or double quotes escaping inside
     *
     * http://regexr.com/3bqg1
     * http://stackoverflow.com/questions/249791/regex-for-quoted-string-with-escaping-quotes
     */
    const VALUE = '/:value\((["\'])((?:[^\1\\\\]|\\\\.)*?)\1\)/';

    /**
     * Matches :visible(value), where value is a positive or negative string
     * Supports true/false, on/off, yes/no, 1/0
     *
     * http://stackoverflow.com/questions/7336861/how-to-convert-string-to-boolean-php
     */
    const VISIBLE = '/:visible\((([\w]+))\)/';

    private static $patterns = [
        'text' => Filters::TEXT,
        'value' => Filters::VALUE,
        'visible' => Filters::VISIBLE,
    ];

    /**
     * @return array
     */
    public static function getPatterns()
    {
        return self::$patterns;
    }

    /**
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->filters;
    }

    /**
     * @param  string $name
     * @param  string $pattern
     * @param  string $selector
     * @return string
     */
    public function extractPattern($name, $pattern, $selector)
    {
        if (preg_match($pattern, $selector, $matches)) {
            $this->filters[$name] = $matches[2];
            return preg_replace($pattern, '', $selector);
        }

        return $selector;
    }

    /**
     * @param  string $selector
     * @return string
     */
    public function extractAllPatterns($selector)
    {
        foreach (self::$patterns as $name => $pattern) {
            $selector = $this->extractPattern($name, $pattern, $selector);
        }

        return $selector;
    }

    /**
     * @param  CrawlerInterface $crawler
     * @param  string           $id
     * @return boolean
     */
    public function match(CrawlerInterface $crawler, $id)
    {
        foreach ($this->filters as $name => $value) {
            if (false === $this->$name($crawler, $id, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->filters);
    }

    /**
     * @param  CrawlerInterface $crawler
     * @param  array            $ids
     * @return array
     */
    public function matchAll(CrawlerInterface $crawler, array $ids)
    {
        if ($this->isEmpty()) {
            return $ids;
        } else {
            return array_values(
                array_filter(
                    $ids,
                    function ($id) use ($crawler) {
                        return $this->match($crawler, $id);
                    }
                )
            );
        }
    }

    /**
     * @param  CrawlerInterface $crawler
     * @param  string           $id
     * @param  string           $value
     * @return boolean
     */
    public function value(CrawlerInterface $crawler, $id, $value)
    {
        return $crawler->getValue($id) === (string) $value;
    }

    /**
     * @param  CrawlerInterface $crawler
     * @param  string           $id
     * @param  boolean          $isVisible
     * @return boolean
     */
    public function visible(CrawlerInterface $crawler, $id, $isVisible = true)
    {
        return $crawler->isVisible($id) === filter_var($isVisible, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param  CrawlerInterface $crawler
     * @param  string           $id
     * @param  string           $text
     * @return string
     */
    public function text(CrawlerInterface $crawler, $id, $text)
    {
        return false !== mb_stripos($crawler->getText($id), (string) $text);
    }
}
