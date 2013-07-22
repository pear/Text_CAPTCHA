<?php
/**
 * Text_CAPTCHA - creates a CAPTCHA for Turing tests.
 *
 * Base class file for using Text_CAPTCHA.
 *
 * PHP version 5
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Christian Wenz <wenz@php.net>
 * @license  BSD License
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

/*
    // This is a simple example script

    <?php
    if (!function_exists('file_put_contents')) {
        function file_put_contents($filename, $content) {
            if (!($file = fopen($filename, 'w'))) {
                return false;
            }
            $n = fwrite($file, $content);
            fclose($file);
            return $n ? $n : false;
        }
    }

    // Start PHP session support
    session_start();

    $ok = false;

    $msg = 'Please enter the text in the image in the field below!';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['phrase']) && is_string($_SESSION['phrase'])
            && isset($_SESSION['phrase'])
            && strlen($_POST['phrase']) > 0 && strlen($_SESSION['phrase']) > 0
            && $_POST['phrase'] == $_SESSION['phrase']) {
            $msg = 'OK!';
            $ok = true;
            unset($_SESSION['phrase']);
        } else {
            $msg = 'Please try again!';
        }

        unlink(sha1(session_id()) . '.png');   

    }

    print "<p>$msg</p>";

    if (!$ok) {
    
        require_once 'Text/CAPTCHA.php';
                   
        // Set CAPTCHA image options (font must exist!)
        $imageOptions = array(
            'font_size'        => 24,
            'font_path'        => './',
            'font_file'        => 'COUR.TTF',
            'text_color'       => '#DDFF99',
            'lines_color'      => '#CCEEDD',
            'background_color' => '#555555'
        );

        // Set CAPTCHA options
        $options = array(
            'width' => 200,
            'height' => 80,
            'output' => 'png',
            'imageOptions' => $imageOptions
        );

        // Generate a new Text_CAPTCHA object, Image driver
        $c = Text_CAPTCHA::factory('Image');
        $retval = $c->init($options);
        if (PEAR::isError($retval)) {
            printf('Error initializing CAPTCHA: %s!',
                $retval->getMessage());
            exit;
        }
    
        // Get CAPTCHA secret passphrase
        $_SESSION['phrase'] = $c->getPhrase();
    
        // Get CAPTCHA image (as PNG)
        $png = $c->getCAPTCHA();
        if (PEAR::isError($png)) {
            printf('Error generating CAPTCHA: %s!',
                $png->getMessage());
            exit;
        }
        file_put_contents(sha1(session_id()) . '.png', $png);
    
        echo '<form method="post">' . 
             '<img src="' . sha1(session_id()) . '.png?' . time() . '" />' . 
             '<input type="text" name="phrase" />' .
             '<input type="submit" /></form>';
    }
    ?>
*/
/**
 * Text_CAPTCHA - creates a CAPTCHA for Turing tests.
 *
 * Class to create a Turing test for websites by creating an image, ASCII art or
 * something else with some (obfuscated) characters.
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Christian Wenz <wenz@php.net>
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  BSD License
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
     *
     * @throws Text_CAPTCHA_Exception when invalid driver is specified
     */
    public static function factory($driver)
    {
        if ($driver == '') {
            throw new Text_CAPTCHA_Exception(
                'No CAPTCHA type specified ... aborting. ' .
                'You must call ::factory() with one parameter, the CAPTCHA type.'
            );
        }
        $driver = basename($driver);
        $driverFile = dirname(__FILE__) . "/CAPTCHA/Driver/$driver.php";
        if (file_exists($driverFile) && is_readable($driverFile)) {
            include_once $driverFile;

            $classname = "Text_CAPTCHA_Driver_$driver";
            return new $classname;
        } else {
            throw new Text_CAPTCHA_Exception(
                'Invalid CAPTCHA type specified ... aborting.'
            );
        }
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
     *
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
     *
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
     * Place holder for the real init() method used by extended classes to
     * initialize CAPTCHA.
     *
     * @param array $options Options to pass in.
     *
     * @return void
     */
    public function init($options = array())
    {
        $this->generate();
    }

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