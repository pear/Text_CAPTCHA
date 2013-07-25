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
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
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
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
            'imageOptions' => $imageOptions,
            'phrase' => 'tooLongForDefaultFontSizeReallyTooLong1234567890'
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
    public function testTooLong2()
    {
        $this->setExpectedException("Image_Text_Exception");
        $imageOptions = array(
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
            'width' => 10,
            'height' => 10,
            'imageOptions' => $imageOptions,
            'phrase' => 'tooLongForDefaultFontSizeReallyTooLong1234567890'
        );

        $this->_captcha->init($options);
        $this->fail("should not reach that point");
    }

    /**
     * test resizing of text
     *
     * @return void
     */
    public function testTooHeight()
    {
        $this->setExpectedException("Text_CAPTCHA_Exception");
        $imageOptions = array(
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
            'height' => 1,
            'imageOptions' => $imageOptions,
        );

        $this->_captcha->init($options);
        $this->fail("should not reach that point");
    }

    /**
     * test different outputs
     *
     * @return void
     */
    public function testDifferentOutputs()
    {
        $imageOptions = array(
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
            'imageOptions' => $imageOptions,
            'output' => 'png'
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());

        $options['output'] = 'jpg';
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());

        $options['output'] = 'jpeg';
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());

        $options['output'] = 'gif';
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());

        $options['output'] = 'resource';
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
    }

    /**
     * test invalid output type
     *
     * @return void
     */
    public function testInvalidOutput()
    {
        $this->setExpectedException("Text_CAPTCHA_Exception");
        $imageOptions = array(
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
            'imageOptions' => $imageOptions,
            'output' => 'unknown'
        );
        $this->_captcha->init($options);
    }

    /**
     * test phrase options for Text_Password
     *
     * @return void
     */
    public function testPhraseOptions()
    {
        $imageOptions = array(
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
            'imageOptions' => $imageOptions,
            'phraseOptions' => array('unpronounceable', 'ABCDEFG')
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());

        $options = array(
            'imageOptions' => $imageOptions,
            'phraseOptions' => array('unpronounceable')
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * test antialias
     *
     * @return void
     */
    public function testAntialias()
    {
        $imageOptions = array(
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
            'antialias' => true
        );
        $options = array(
            'imageOptions' => $imageOptions
        );

        $this->_captcha->init($options);
    }

    /**
     * test imagesize
     *
     * @return void
     */
    public function testImageSize()
    {
        $imageOptions = array(
            'font_path' => dirname(__FILE__) . '/data/',
            'font_file' => 'cour.ttf',
        );
        $options = array(
            'width' => 234,
            'height' => 123,
            'imageOptions' => $imageOptions
        );

        $this->_captcha->init($options);
        $captcha = $this->_captcha->getCAPTCHA();
        $this->assertNotNull($captcha);
    }
}
