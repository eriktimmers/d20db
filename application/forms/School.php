<?php

class Application_Form_School extends Zend_Form
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
        $this->addElement('text', 'sch_name', 
            array(
                'label'      => 'Name:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(1, 25)),
                ),
                'decorators' => $decoratorStack
            )
        ); 
        
        // Add an name element
        $this->addElement('text', 'sch_abbreviation', 
            array(
                'label'      => 'Abbreviation:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(1, 4)),
                ),
                'decorators' => $decoratorStack
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

