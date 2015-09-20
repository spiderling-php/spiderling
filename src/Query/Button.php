<?php

namespace SP\Spiderling\Query;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Button extends AbstractXPath
{
    const TYPE = '(self::input and @type = \'submit\') or self::button';

    /**
     * @return string
     */
    public function getType()
    {
        return Button::TYPE;
    }

    /**
     * @return array
     */
    public function getMatchers()
    {
        return [
            AbstractXPath::ID,
            AbstractXPath::NAME,
            AbstractXPath::TEXT,
            AbstractXPath::TITLE,
            AbstractXPath::VALUE,
            AbstractXPath::IMG_ALT,
        ];
    }
}
