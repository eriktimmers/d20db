<?php

class Application_Form_Subschool extends Zend_Form
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
        
        // Add an name element
        $this->addElement('text', 'subs_name', 
            array(
                'label'      => 'Name:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(1, 64)),
                ),
                'decorators' => $decoratorStack
            )
        );
        
        $this->addElement('select', 'subs_school', 
            array(           
                'label'        => 'School:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('schools'),
                'decorators'   => $decoratorStack
            )
        );          
        
        
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

