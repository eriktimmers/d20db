<?php

class Application_Form_SystemFilter extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $decoratorStack = array( 
            'ViewHelper',
            'Description',
            'Errors',
            array(array('data'=>'HtmlTag'), array('tag' => 'td')),
            array('Label', array('tag' => 'td')),
            array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
        );      
        
        foreach($this->getAttrib('Systems') as $key=>$value) {
        
            $this->addElement('checkbox', 'doShow_' . $key, 
                array(
                    'label'      => $value,
                    'decorators' => $decoratorStack
                     )
            );             
            
        }
        
        
        
        // Add the submit button
        $this->addElement('submit', 'submit', 
            array(
                'ignore'   => true,
                'label'    => 'Save',
                'decorators' =>  array( 
                    'ViewHelper',
                    'Description',
                    'Errors',
                    array(array('data'=>'HtmlTag'), array('tag' => 'td', 'colspan'=>'2')),
                    array(array('row'=>'HtmlTag'), array('tag'=>'tr'))
                )
        ));
        
        $this->setDecorators(array(
               'FormElements',
               array(array('data'=>'HtmlTag'), array('tag'=>'table', 'class'=>'formtable formtablesource')),
               'Form'
        ));           
    }


}

