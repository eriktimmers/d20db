<?php

class Zend_View_Helper_Icon extends Zend_View_Helper_Abstract {

    public function Icon($icon, $name, $link='', $data=array())
    {
        $sHtml = '<span class="icon_' . $name . '_wrapper">';
        $sHtml .= ($link ? '<a href="' . $link . '" class="icon_' . $name . '_link">' : '');
        $sHtml .= '<img src="/img/icon/' . $icon . '" class="icon_' . $name . '" data-xtype="' . $name . '"';
        foreach($data as $key=>$value) {
            $sHtml .= ' data-' . $key . '="' . $value . '"';            
        }
        $sHtml .= '>';
        $sHtml .= ($link ? '</a>' : '');
        $sHtml .= '</span>';
        return $sHtml;
    }
    
}
