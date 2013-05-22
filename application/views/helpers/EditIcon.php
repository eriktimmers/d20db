<?php

class Zend_View_Helper_EditIcon extends Zend_View_Helper_Abstract {

    public function EditIcon($link='', $data=array())
    {        
        return $this->view->Icon('pencil.png', 'edit', $link, $data);
    }
    
}
