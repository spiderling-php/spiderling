<?php

namespace SP\Spiderling\Query;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Field extends AbstractXPath
{
    const TYPE = '(self::input and (not(@type) or @type != \'submit\')) or self::textarea or self::select';

    /**
     * @return string
     */
    public function getType()
    {
        return Field::TYPE;
    }

    /**
     * @return array
     */
    public function getMatchers()
    {
        return [
            AbstractXPath::NAME,
            AbstractXPath::ID,
            AbstractXPath::PLACEHOLDER,
            AbstractXPath::LABEL_FOR,
            AbstractXPath::OPTION_TEXT,
        ];
    }
}
