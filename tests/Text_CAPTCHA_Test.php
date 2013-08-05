<?php
/**
 * Tests for the main Text_CAPTCHA class
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
 * Class Text_CAPTCHA_Test
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
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

    /**
     * test invalid driver name.
     *
     * @return void
     */
    public function testNoDriverName()
    {
        $this->setExpectedException("Text_CAPTCHA_Exception");
        Text_CAPTCHA::factory('');
    }

    /**
     * test generate function
     *
     * @return void
     */
    public function testGenerate()
    {
        $captcha = Text_CAPTCHA::factory('Word');
        $captcha->init();
        $phraseAfterInit = $captcha->getPhrase();
        $captcha->generate(true);
        $phraseAfterGenerate = $captcha->getPhrase();
        $this->assertNotEquals($phraseAfterInit, $phraseAfterGenerate);
        $captcha->generate("Testphrase");
        $phraseAfterSet = $captcha->getPhrase();
        $this->assertNotEquals($phraseAfterGenerate, $phraseAfterSet);
        $this->assertEquals('Testphrase', $phraseAfterSet);
    }

    /**
     * test driver init.
     *
     * @return void
     */
    public function testInit()
    {
        $this->setExpectedException("Text_CAPTCHA_Exception");
        $captcha = Text_CAPTCHA::factory('Word');
        $captcha->generate();
    }

    /**
     * test null driver in constructor.
     *
     * @return void
     */
    public function testNullDriver()
    {
        $this->setExpectedException("Text_CAPTCHA_Exception");
        new Text_CAPTCHA(null);
    }
}
