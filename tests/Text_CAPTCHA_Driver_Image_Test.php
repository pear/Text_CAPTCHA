<?php
class Text_CAPTCHA_Driver_Image_Test extends PHPUnit_Framework_TestCase
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
            'font_path' => __DIR__ . '/data/',
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
            'font_path' => __DIR__ . '/data/',
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
