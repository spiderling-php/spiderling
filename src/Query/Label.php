<?php

namespace SP\Spiderling\Query;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Label extends AbstractXPath
{
    const TYPE = 'self::label';

    /**
     * @return string
     */
    public function getType()
    {
        return Label::TYPE;
    }

    /**
     * @return array
     */
    public function getMatchers()
    {
        return [
            AbstractXPath::TITLE,
            AbstractXPath::TEXT,
            AbstractXPath::IMG_ALT,
        ];
    }
}
