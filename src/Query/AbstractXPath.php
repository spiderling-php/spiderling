<?php

namespace SP\Spiderling\Query;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractXPath extends AbstractQuery
{
    /**
     * Match by id
     */
    const ID = "@id = '%s'";

    /**
     * Match by name
     */
    const NAME = "@name = '%s'";

    /**
     * Match by placeholder
     */
    const PLACEHOLDER = "@placeholder = '%s'";

    /**
     * Match by label pointing to element
     */
    const LABEL_FOR = "@id = //label[normalize-space() = '%s']/@for";

    /**
     * Match by text of an option tag inside the select
     */
    const OPTION_TEXT = "(self::select and ./option[(@value = \"\" or not(@value)) and contains(normalize-space(), \"%s\")])";

    /**
     * Match by title
     */
    const TITLE = "contains(@title, '%s')";

    /**
     * Match by plain text content
     */
    const TEXT = "contains(normalize-space(), '%s')";

    /**
     * Match by alt of an img tag
     */
    const IMG_ALT = "descendant::img[contains(@alt, '%s')]";

    /**
     * Match by value of element
     */
    const VALUE = "contains(@value, '%s')";

    /**
     * @return string
     */
    public function getXPath()
    {
        $type = $this->getType();
        $combined = join(' or ', $this->getMatchers());
        $filled = str_replace('%s', $this->getSelector(), $combined);

        return "//*[($type) and ($filled)]";
    }

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * @return array
     */
    abstract public function getMatchers();
}
