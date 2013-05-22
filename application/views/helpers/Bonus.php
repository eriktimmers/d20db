<?php

class Zend_View_Helper_Bonus extends Zend_View_Helper_Abstract {

    public function Bonus($value)
    {
        return ((int)$value > 0 ? '+' : '') . $value;
    }
    
}