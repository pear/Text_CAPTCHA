<?php
require_once 'Text/CAPTCHA.php';

class Text_CAPTCHA_Driver_Numeral_Test extends PHPUnit_Framework_TestCase
{
    /**
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
        $this->_captcha = Text_CAPTCHA::factory("Numeral");
        $this->_captcha->init();
    }

    /**
     * Simple test.
     *
     * @return void
     */
    public function testSimple()
    {
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }
}
