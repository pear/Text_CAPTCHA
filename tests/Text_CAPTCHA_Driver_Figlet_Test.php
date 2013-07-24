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
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf')
        );

        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * test reinitialization
     *
     * @return void
     */
    public function testReInit()
    {
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf')
        );
        $this->_captcha->init($options);
        $phrase1 = $this->_captcha->getPhrase();
        $this->_captcha->init($options);
        $phrase2 = $this->_captcha->getPhrase();
        $this->assertNotEquals($phrase1, $phrase2);
    }

    /**
     * test font_file
     *
     * @return void
     */
    public function testFontFile()
    {
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf')
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());

        $options = array(
            'font_file' => dirname(__FILE__) . '/data/makisupa.flf'
        );
        $this->_captcha->init($options);
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
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'phrase' => 'Text_CAPTCHA'
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertEquals('Text_CAPTCHA', $this->_captcha->getPhrase());
    }

    /**
     * test phrase length
     *
     * @return void
     */
    public function testPhraseLength()
    {
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'length' => 10
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertEquals(10, strlen($this->_captcha->getPhrase()));
    }

    /**
     * test text and javascript output
     *
     * @return void
     */
    public function testDifferentOutput()
    {
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'output' => 'text'
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());

        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'output' => 'javascript'
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * test invalid output type
     *
     * @return void
     */
    public function testInvalidOutputType()
    {
        $this->setExpectedException('Text_CAPTCHA_Exception');
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'output' => 'image'
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
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'phraseOptions' => array('unpronounceable', 'ABCDEFG')
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());

        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'phraseOptions' => array('unpronounceable')
        );
        $this->_captcha->init($options);
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * test width option
     *
     * @return void
     */
    public function testWidth()
    {
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'width' => 123,
            'output' => 'html'
        );
        $this->_captcha->init($options);
        $captcha = $this->_captcha->getCAPTCHA();
        $this->assertNotNull($captcha);
        $this->assertContains('width:123px;', $captcha);
        $this->assertNotNull($this->_captcha->getPhrase());
    }

    /**
     * test style options
     *
     * @return void
     */
    public function testStyleOptions()
    {
        $options = array(
            'font_file' => glob(dirname(__FILE__) . '/data/*.flf'),
            'style' => array(
                'border' => '1px dashed red',
                'color' => 'yellow',
                'background' => 'black'
            ),
            'output' => 'html'
        );
        $this->_captcha->init($options);
        $captcha = $this->_captcha->getCAPTCHA();
        $this->assertNotNull($captcha);
        $this->assertContains('border: 1px dashed red;', $captcha);
        $this->assertContains('color: yellow;', $captcha);
        $this->assertContains('background: black;', $captcha);
        $this->assertNotNull($this->_captcha->getPhrase());
    }
}
