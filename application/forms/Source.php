<?php

class Application_Form_Source extends Zend_Form
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
        $this->addElement('text', 'src_name', 
            array(
                'label'      => 'Name:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(1, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );

        $this->addElement('text', 'src_abbriviation', 
            array(
                'label'      => 'Abbreviation:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(1, 15)),
                ),
                'decorators' => $decoratorStack
            )
        );

        $this->addElement('text', 'src_publisher', 
            array(
                'label'      => 'Publisher:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );        

        $this->addElement('text', 'src_author', 
            array(
                'label'      => 'Author:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );        

        $this->addElement('text', 'src_url', 
            array(
                'label'      => 'Url:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 128)),
                ),
                'decorators' => $decoratorStack
            )
        ); 
        
        $this->addElement('select', 'src_type', 
            array(
                'label'      => 'Type:',
                'required'   => true,
                'multiOptions' => array('0' => ' -- select --') +  $this->getAttrib('types'),
                'decorators' => $decoratorStack
            )
        );     

        
        $this->addElement('select', 'src_system', 
            array(
                'label'      => 'Game System:',
                'required'   => true,
                'multiOptions' => array('0' => ' -- select --') +  $this->getAttrib('gamesystems'),
                'decorators' => $decoratorStack
            )
        );     
        
        $this->addElement('select', 'src_world', 
            array(
                'label'      => 'World:',
                'required'   => true,
                'multiOptions' => array('0' => ' -- select --') +  $this->getAttrib('worlds'),
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

