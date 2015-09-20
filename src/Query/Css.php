<?php

namespace SP\Spiderling\Query;

use Symfony\Component\CssSelector\CssSelector;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Css extends AbstractQuery
{
    public function getXPath()
    {
        return CssSelector::toXPath($this->getSelector(), '//');
    }
}
