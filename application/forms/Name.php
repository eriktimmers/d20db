<?php

/**
 * A simple name-only form
 */
class Application_Form_Name extends Zend_Form
{

    public function init()
    {
        
        $prefix = $this->getAttrib('fieldprefix');
                
        $this->setMethod('post');
        
        // Add an name element
        $this->addElement('text', $prefix . 'name', 
            array(
                'label'      => 'Naam:',
                'required'   => true,
                'attribs'    => array('maxlength' => 32),
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(3, 32)),
                ),
                'decorators' =>  array( 
                    'ViewHelper',
                    'Description',
                    'Errors',
                    array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                    array('Label', array('tag' => 'td')),
                    array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
                )
            )
        );
        
        // Add the submit button
        $this->addElement('submit', 'submit', 
            array(
                'ignore'     => true,
                'label'      => 'Opslaan',
                'class'      => 'submitbutton',
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
               array(array('data'=>'HtmlTag'), array('tag'=>'table', 'class'=>'formtable formtablename')),
               'Form'
        ));
        
        // And finally add some CSRF protection
        //$this->addElement('hash', 'csrf', 
        //    array(
        //        'ignore' => true,
        //));        
        
    }


}

