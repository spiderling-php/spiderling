<?php

namespace SP\Spiderling\Test\Integration;

use PHPUnit_Framework_TestCase;
use SP\Spiderling\Node;
use SP\Spiderling\CrawlerSession;
use SP\Spiderling\Test\Crawler;
use SP\PhpunitDomConstraints\DomConstraintsTrait;

/**
 * @coversNothing
 */
class TraverseTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    public function testSimple()
    {
        $index = new Crawler('index.html');
        $session = new CrawlerSession($index);

        $a = $session->get('.subnav li a:visible(true):text("Subpage 2")');

        $this->assertEquals('Subpage Title 2', $a->getAttribute('title'));

        $session->get('#form')->with(function ($form) use ($index) {
            $this->assertEquals('form', $form->getAttribute('id'));

            $form->getField('Enter Email:value("tom@example.com")')->with(function ($email) {
                $this->assertEquals('tom@example.com', $email->getValue());
            });

            $form->setField('Enter Name', 'Other thing');

            $name = $form->getField('Enter Name');

            $this->assertMatchesSelector(
                'input[value="Other thing"]',
                $index->getElement($name->getId())
            );

            $label = $form->getLabel('Gender Male');

            $this->assertMatchesSelector(
                'label[for="gender-1"]',
                $index->getElement($label->getId())
            );
        });
    }
}
