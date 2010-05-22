<?php

require_once 'Text/CAPTCHA.php';

// Set CAPTCHA image options
// font_file can either be an array or a string
// style is optional and specifies inline css to be used
 
$textOptions = array(
    'font_file' => glob('*.flf'),
    'style'     => array('border' => '1px dashed red', 
                         'color' => 'yellow',
                         'background' => 'black'),
    );

// Set CAPTCHA options
// There is no way to set the 'height' property
// output options are 'javascript', 'html' or 'text' default is html
// default length is 6

$options = array(
    'width' => 200,
    'output' => 'javascript',
    'length' => 8,
    'options' => $textOptions
);
                   
// Generate a new Text_CAPTCHA object, Image driver
$c = Text_CAPTCHA::factory('Figlet');
$retval = $c->init($options);
if (PEAR::isError($retval)) {
    echo 'Error initializing CAPTCHA!';
    exit;
}
    
// Get CAPTCHA secret passphrase
$phrase = strtoupper($c->getPhrase());
    
$text = $c->getCAPTCHA();
if (PEAR::isError($text)) {
	   echo $text->getMessage();
     echo 'Error generating CAPTCHA!';
     exit;
}
    
echo "<pre>$text</pre><br />";
echo "Solution: $phrase";
?>
