<?php
require_once 'Text/CAPTCHA.php';

class Text_CAPTCHA_Driver_Equation_Test extends PHPUnit_Framework_TestCase
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
                'min' => 1,
                'max' => 4,
                'numbersToText' => true,
                'severity' => 2
            )
        );
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }
}
