<?php

class Zend_View_Helper_SystemRow extends Zend_View_Helper_Abstract {

    public function SystemRow($item, $type, $prefix, $linkPrefix='')
    {
        $sHtml = '<li class="list_systemname">';
        $sHtml .= $item[$prefix . "name"]; 
        $sHtml .= $this->view->Icons()->editIcon(
                    $linkPrefix . 'edit/' . $item[$prefix . "id"], 
                    array("id" => $item[$prefix . "id"],
                          "type" => $type
                    ));
        
        $sHtml .= $this->view->Icons()->deleteIcon(
                    null, 
                    array("id" => $item[$prefix . "id"],
                          "type" => $type
                    ));
          
        $sHtml .= '</li>';
        return $sHtml;
    }
    
}
