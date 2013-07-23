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
}
