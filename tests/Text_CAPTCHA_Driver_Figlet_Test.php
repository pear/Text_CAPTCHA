<?php
/**
 * Tests for the Text_CAPTCHA Figlet driver class
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
 * Class Text_CAPTCHA_Driver_Figlet_Test
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
class Text_CAPTCHA_Driver_Figlet_Test extends PHPUnit_Framework_TestCase
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
        $this->_captcha = Text_CAPTCHA::factory("Figlet");
    }

    /**
     * Simple test.
     *
     * @return void
     */
    public function testSimple()
    {
        $textOptions = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'style' => array(
                'border' => '1px dashed red',
                'color' => 'yellow',
                'background' => 'black'
            ),
        );
        $options = array(
            'width' => 200,
            'output' => 'html',
            'length' => 8,
            'options' => $textOptions
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }
}
