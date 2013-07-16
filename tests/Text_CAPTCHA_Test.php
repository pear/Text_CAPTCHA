<?php
class Text_CAPTCHA_Test extends PHPUnit_Framework_TestCase
{
    /**
     * test invalid driver name.
     *
     * @return void
     */
    public function testInvalidDriverName()
    {
        $this->setExpectedException("Text_CAPTCHA_Exception");
        Text_CAPTCHA::factory('invalidDriver');
    }
}
