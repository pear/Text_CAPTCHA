<?php
require_once 'Text/CAPTCHA.php';

class Text_CAPTCHA_Driver_Word_Test extends PHPUnit_Framework_TestCase
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
        $this->_captcha = Text_CAPTCHA::factory("Word");
        $this->_captcha->init(array('length' => 8, 'locale' => 'de'));
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
