<?php
require_once 'Text/CAPTCHA.php';
$c = Text_CAPTCHA::factory('Equation');

$ret = $c->init();
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit(1);
}
echo 'Equation: ' . $c->getCAPTCHA() . "<br />";
echo 'Solution: ' . $c->getPhrase() . "<br />";

$options = array(
    'min' => 1,
    'max' => 4,
    'numbersToText' => true,
    'severity' => 2
);
$ret = $c->init($options);
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit(1);
}
echo 'Equation: ' . $c->getCAPTCHA() . "<br />";
echo 'Solution: ' . $c->getPhrase() . "<br />";

?>