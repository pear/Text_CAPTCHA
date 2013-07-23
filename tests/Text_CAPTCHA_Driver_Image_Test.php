<?php
/**
 * Tests for the Text_CAPTCHA Image driver class
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
 * Class Text_CAPTCHA_Driver_Image_Test
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
class Text_CAPTCHA_Driver_Image_Test extends PHPUnit_Framework_TestCase
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
        $this->_captcha = Text_CAPTCHA::factory("Image");
    }

    /**
     * Simple test.
     *
     * @return void
     */
    public function testSimple()
    {
        $imageOptions = array(
            'font_size' => 24,
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
            'text_color' => '#DDFF99',
            'lines_color' => '#CCEEDD',
            'background_color' => '#555555'
        );
        $options = array(
            'width' => 200,
            'height' => 80,
            'output' => 'png',
            'imageOptions' => $imageOptions
        );

        $this->_captcha->init($options);

        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * test resizing of text
     *
     * @return void
     */
    public function testTooLong()
    {
        $imageOptions = array(
            'font_size' => 24,
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
            'text_color' => '#DDFF99',
            'lines_color' => '#CCEEDD',
            'background_color' => '#555555'
        );
        $options = array(
            'width' => 200,
            'height' => 80,
            'output' => 'png',
            'imageOptions' => $imageOptions,
            'phrase' => 'tooLongForDefaultFontSizeReallyTooLong'
        );

        $this->_captcha->init($options);

        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }
}
