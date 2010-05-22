<?php

require_once 'Text/CAPTCHA.php';

$c = Text_CAPTCHA::factory("Numeral");
$c->init(); 

print 'Operation: ' . $c->getCAPTCHA();
print '<br />Solution: ' . $c->getPhrase();

?>