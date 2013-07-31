<?php
/**
 * Simple example
 *
 * @category Text
 * @package  Text_CAPTCHA
 * @author   Christian Wenz <wenz@php.net>
 * @author   Michael Cramer <michael@bigmichi1.de>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link     http://pear.php.net/package/Text_CAPTCHA
 */

// Start PHP session support
session_start();

$ok = false;

$msg = 'Please enter the text in the image in the field below!';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['phrase']) && is_string($_SESSION['phrase'])
        && isset($_SESSION['phrase'])
        && strlen($_POST['phrase']) > 0 && strlen($_SESSION['phrase']) > 0
        && $_POST['phrase'] == $_SESSION['phrase']
    ) {
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
        'font_size' => 24,
        'font_path' => './',
        'font_file' => 'COUR.TTF',
        'text_color' => '#DDFF99',
        'lines_color' => '#CCEEDD',
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
    $c->init($options);

    // Get CAPTCHA secret passphrase
    $_SESSION['phrase'] = $c->getPhrase();

    // Get CAPTCHA image (as PNG)
    $png = $c->getCAPTCHA();

    file_put_contents(sha1(session_id()) . '.png', $png);

    echo '<form method="post">' .
        '<img src="' . sha1(session_id()) . '.png?' . time() . '" />' .
        '<input type="text" name="phrase" />' .
        '<input type="submit" /></form>';
}