<?php
/**
 * Tests for the Text_CAPTCHA Equation driver class
 *
 * PHP version 5
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
require_once 'Text/CAPTCHA.php';
/**
 * Class Text_CAPTCHA_Driver_Equation_Test
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
class Text_CAPTCHA_Driver_Equation_Test extends PHPUnit_Framework_TestCase
{
    /**
     * Test instance
     *
     * @var Text_CAPTCHA instance
     */
    private $_captcha;

    /**
     * Create the test instance.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->_captcha = Text_CAPTCHA::factory("Equation");
    }

    /**
     * Simple test.
     *
     * @return void
     */
    public function testSimple()
    {
        $this->_captcha->init();
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * Advanced Test
     *
     * @return void
     */
    public function testAdvanced()
    {
        $this->_captcha->init(
            array(
                'severity' => 2
            )
        );
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * invalid complexity
     *
     * @return void
     */
    public function testInvalidComplexity()
    {
        $this->setExpectedException("Text_CAPTCHA_Exception");
        $this->_captcha->init(
            array(
                'severity' => 99
            )
        );
    }

    /**
     * test NumbersToText
     *
     * @return void
     */
    public function testNumbersToText()
    {
        $this->_captcha->init(
            array(
                'min' => 1,
                'max' => 4,
                'locale' => 'de',
                'numbersToText' => true,
                'severity' => 2
            )
        );
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }
}
