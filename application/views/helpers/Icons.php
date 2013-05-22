<?php

class Zend_View_Helper_Icons extends Zend_View_Helper_Abstract {

    public function Icons()
    {
        return $this;
    }
    
    public function Icon($icon, $name, $link='', $data=array())
    {
        $sHtml = '<span class="icon_' . $name . '_wrapper">';
        $sHtml .= ($link ? '<a href="' . $link . '" class="icon_' . $name . '_link" >' : '');
        $sHtml .= '<img src="/img/icon/' . $icon . '" class="icon_' . $name . '" data-xtype="' . $name . '"';
        foreach($data as $key=>$value) {
            $sHtml .= ' data-' . $key . '="' . $value . '"';            
        }
        $sHtml .= ' title="' . ucfirst($name) . '">';
        $sHtml .= ($link ? '</a>' : '');
        $sHtml .= '</span>';
        return $sHtml;
    }
    
    public function EditIcon($link='', $data=array())
    {        
        return $this->Icon('pencil.png', 'edit', $link, $data);
    }    

    public function DeleteIcon($link='', $data=array())
    {        
        return $this->Icon('cross-button.png', 'delete', $link, $data);
    }       

    public function ViewIcon($link='', $data=array())
    {        
        return $this->Icon('eye.png', 'view', $link, $data);
    }       

    public function CopyIcon($link='', $data=array())
    {        
        return $this->Icon('document-copy.png', 'copy', $link, $data);
    }       
    
}