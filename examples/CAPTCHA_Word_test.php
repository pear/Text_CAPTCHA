<?php
     require_once 'Text/CAPTCHA.php';

     $c = Text_CAPTCHA::factory("Word");
     $c->init(array('length' => 4, 'locale' => 'de'));
     echo $c->getCAPTCHA();
?>
