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

    public static function getPatterns()
    {
        return self::$patterns;
    }

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function all()
    {
        return $this->filters;
    }

    public function extractPattern($name, $pattern, $selector)
    {
        if (preg_match($pattern, $selector, $matches)) {
            $this->filters[$name] = $matches[2];
            return preg_replace($pattern, '', $selector);
        }

        return $selector;
    }

    public function extractAllPatterns($selector)
    {
        foreach (self::$patterns as $name => $pattern) {
            $selector = $this->extractPattern($name, $pattern, $selector);
        }

        return $selector;
    }

    public function match(CrawlerInterface $crawler, $id)
    {
        foreach ($this->filters as $name => $value) {
            if (false === $this->$name($crawler, $id, $value)) {
                return false;
            }
        }

        return true;
    }

    public function value(CrawlerInterface $crawler, $id, $value)
    {
        return $crawler->getValue($id) === (string) $value;
    }

    public function visible(CrawlerInterface $crawler, $id, $isVisible = true)
    {
        return $crawler->isVisible($id) === filter_var($isVisible, FILTER_VALIDATE_BOOLEAN);
    }

    public function text(CrawlerInterface $crawler, $id, $text)
    {
        return false !== mb_stripos($crawler->getText($id), (string) $text);
    }
}
