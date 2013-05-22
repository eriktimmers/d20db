<?php

class Application_Form_DeityFilter extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $decoratorStack = array( 
            'ViewHelper',
            array('Label'),
            array('HtmlTag', array('tag'=>'div', 'class'=>'filterline'))
        );
        
        // Add an name element
        $this->addElement('text', 'filter', 
            array(
                'label'      => 'Name:',
                'required'   => false,
                'attribs'    => array('maxlength' => 32),
                'filters'    => array('StringTrim', 'StripTags'),
                'decorators' => $decoratorStack,
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => array(
                    array('ViewScript', array(
                        'viewScript' => 'partials/_elementSearch.phtml'
                        )
                    ),
                    array('Label'),
                    array('HtmlTag', array('tag'=>'div', 'class'=>'filterline'))
                )
            )
        );

        $this->addElement('text', 'filter_domain', 
            array(
                'label'      => 'Domain:',
                'required'   => false,
                'attribs'    => array('maxlength' => 32),
                'filters'    => array('StringTrim', 'StripTags'),
                'decorators' => $decoratorStack,
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => array(
                    array('ViewScript', array(
                        'viewScript' => 'partials/_elementSearch.phtml'
                        )
                    ),
                    array('Label'),
                    array('HtmlTag', array('tag'=>'div', 'class'=>'filterline'))
                )
            )
        );        
        
        $this->addElement('select', 'filter_pantheon', 
            array(
                'label'      => 'Pantheon:',
                'required'   => false,
                'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('pantheons'),
                'decorators' => $decoratorStack
            )
        );          
        
        $this->addElement('select', 'filter_source', 
            array(
                'label'      => 'Source:',
                'required'   => false,
                'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('sources'),
                'decorators' => $decoratorStack
            )
        );  
        
       
        // Add the submit button
        $this->addElement('submit', 'submit', 
            array(
                'ignore'   => true,
                'label'    => 'Search',
                'decorators' => array( 
                    'ViewHelper',                    
                    array('HtmlTag', array('tag'=>'div', 'class'=>'filterline'))
           )
        ));            
    }


}

