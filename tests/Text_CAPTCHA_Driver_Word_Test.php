<?php
/**
 * Tests for the Text_CAPTCHA Word driver class
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
 * Class Text_CAPTCHA_Driver_Word_Test
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
class Text_CAPTCHA_Driver_Word_Test extends PHPUnit_Framework_TestCase
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
        $this->_captcha = Text_CAPTCHA::factory("Word");
    }

    /**
     * Simple test.
     *
     * @return void
     */
    public function testSimple()
    {
        $this->_captcha->init(array('length' => 8, 'locale' => 'de'));
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * test with given phrase
     *
     * @return void
     */
    public function testGivenPhrase()
    {
        $options = array(
            'phrase' => 'Text_CAPTCHA'
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertEquals('Text_CAPTCHA', $this->_captcha->getPhrase());
    }

    /**
     * test with given phrase
     *
     * @return void
     */
    public function testMode()
    {
        $options = array(
            'mode' => 'together'
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }
}
