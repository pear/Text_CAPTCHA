<?php
/**
 * Text_CAPTCHA - creates a CAPTCHA for Turing tests.
 * Base class file for using Text_CAPTCHA.
 *
 * PHP version 5
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Christian Wenz <wenz@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */

/**
 * Require PEAR class for error handling.
 */
require_once 'PEAR.php';
/**
 * Require Exception class for error handling.
 */
require_once 'Text/CAPTCHA/Exception.php';
/**
 * Require Text_Password class for generating the phrase.
 */
require_once 'Text/Password.php';

/**
 * Text_CAPTCHA - creates a CAPTCHA for Turing tests.
 * Class to create a Turing test for websites by creating an image, ASCII art or
 * something else with some (obfuscated) characters.
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Christian Wenz <wenz@php.net>
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */
abstract class Text_CAPTCHA
{
    /**
     * Captcha
     *
     * @var object|string
     */
    private $_captcha;

    /**
     * Phrase
     *
     * @var string
     */
    private $_phrase;

    /**
     * Create a new Text_CAPTCHA object.
     *
     * @param string $driver name of driver class to initialize
     *
     * @return Text_CAPTCHA a newly created Text_CAPTCHA object
     * @throws Text_CAPTCHA_Exception when driver could not be loaded
     *
     */
    public static function factory($driver)
    {
        $driver = basename($driver);
        $class = 'Text_CAPTCHA_Driver_' . $driver;
        $file = str_replace('_', '/', $class) . '.php';
        //check if it exists and can be loaded
        if (!@fclose(@fopen($file, 'r', true))) {
            throw new Text_CAPTCHA_Exception(
                'Driver ' . $driver . ' cannot be loaded.'
            );
        }
        //continue with including the driver
        include_once $file;

        return new $class;
    }

    /**
     * Create random CAPTCHA phrase
     *
     * @param boolean|string $newPhrase new Phrase to use or true to generate a new
     *                                  one
     *
     * @return void
     */
    public final function generate($newPhrase = false)
    {
        if ($newPhrase === true || empty($this->_phrase)) {
            $this->createPhrase();
        } else if (strlen($newPhrase) > 0) {
            $this->setPhrase($newPhrase);
        }
        $this->createCAPTCHA();
    }

    /**
     * Sets secret CAPTCHA phrase.
     * This method sets the CAPTCHA phrase (use null for a random phrase)
     *
     * @param string $phrase The (new) phrase
     *
     * @return void
     */
    protected final function setPhrase($phrase)
    {
        $this->_phrase = $phrase;
    }

    /**
     * Return secret CAPTCHA phrase
     * This method returns the CAPTCHA phrase
     *
     * @return  string   secret phrase
     */
    public final function getPhrase()
    {
        return $this->_phrase;
    }

    /**
     * Sets the generated captcha.
     *
     * @param object|string $captcha the generated captcha
     *
     * @return void
     */
    protected final function setCaptcha($captcha)
    {
        $this->_captcha = $captcha;
    }

    /**
     * Place holder for the real getCAPTCHA() method
     * used by extended classes to return the generated CAPTCHA
     * (as an image resource, as an ASCII text, ...)
     *
     * @return string|object
     */
    public final function getCAPTCHA()
    {
        return $this->_captcha;
    }

    /**
     * Reinitialize the entire Text_CAPTCHA object.
     *
     * @param array $options Options to pass in.
     *
     * @return void
     */
    public final function init($options = array())
    {
        $this->_captcha = null;
        $this->_phrase = null;
        $this->initDriver($options);
        $this->generate();
    }

    /**
     * Place holder for the real init() method used by extended classes to initialize
     * the CAPTCHA driver.
     *
     * @param array $options Options to pass in.
     *
     * @return void
     */
    protected abstract function initDriver($options = array());

    /**
     * Place holder for the real _createCAPTCHA() method
     * used by extended classes to generate CAPTCHA from phrase
     *
     * @return void
     */
    protected abstract function createCAPTCHA();

    /**
     * Create the passphrase.
     *
     * @return void
     */
    protected abstract function createPhrase();
}