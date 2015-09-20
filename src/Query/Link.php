<?php

namespace SP\Spiderling\Query;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Link extends AbstractXPath
{
    const TYPE = 'self::a';

    /**
     * @return string
     */
    public function getType()
    {
        return Link::TYPE;
    }

    /**
     * @return array
     */
    public function getMatchers()
    {
        return [
            AbstractXPath::ID,
            AbstractXPath::TITLE,
            AbstractXPath::TEXT,
            AbstractXPath::IMG_ALT,
        ];
    }
}
