<?php
/**
 * Tests for the Text_CAPTCHA Numeral driver class
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
 * Class Text_CAPTCHA_Driver_Numeral_Test
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
class Text_CAPTCHA_Driver_Numeral_Test extends PHPUnit_Framework_TestCase
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
        $this->_captcha = Text_CAPTCHA::factory("Numeral");
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
     * test min/maxValue
     *
     * @return void
     */
    public function testMinMaxValue()
    {
        $this->_captcha->init(
            array(
                'minValue' => 52,
                'maxValue' => 52,
                'operator' => '-'
            )
        );
        $this->assertNotNull($this->_captcha->getCAPTCHA());
        $this->assertEquals(0, $this->_captcha->getPhrase());
    }

    /**
     * test operator
     *
     * @return void
     */
    public function testOperator()
    {
        $this->_captcha->init(array('operator' => '-'));
        $captcha = $this->_captcha->getCAPTCHA();
        $function = create_function('', 'return ' . $captcha . ';');
        $this->assertNotNull($captcha);
        $this->assertEquals($function(), $this->_captcha->getPhrase());

        $this->_captcha->init(array('operator' => '+'));
        $captcha = $this->_captcha->getCAPTCHA();
        $function = create_function('', 'return ' . $captcha . ';');
        $this->assertNotNull($captcha);
        $this->assertEquals($function(), $this->_captcha->getPhrase());

        $this->_captcha->init(array('operator' => '**'));
        $captcha = $this->_captcha->getCAPTCHA();
        $function = create_function('', 'return ' . $captcha . ';');
        $this->assertNotNull($captcha);
        $this->assertEquals($function(), $this->_captcha->getPhrase());
    }
}
