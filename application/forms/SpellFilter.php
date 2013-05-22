<?php

class Application_Form_SpellFilter extends Zend_Form
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
        
        $this->addElement('select', 'filter_source', 
            array(
                'label'      => 'Source:',
                'required'   => false,
                'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('sources'),
                'decorators' => $decoratorStack
            )
        );  

        $this->addElement('select', 'filter_class', 
            array(
                'label'      => 'Class:',
                'required'   => false,
                'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('classes'),
                'decorators' => $decoratorStack
            )
        );          

        $this->addElement('select', 'filter_level', 
            array(
                'label'      => 'Level:',
                'required'   => false,
                'multiOptions' =>  array('' => '-- select --', 
                                         'zero' => 'Level 0',
                                         '1' => 'Level 1',
                                         '2' => 'Level 2',
                                         '3' => 'Level 3',
                                         '4' => 'Level 4',
                                         '5' => 'Level 5',
                                         '6' => 'Level 6',
                                         '7' => 'Level 7',
                                         '8' => 'Level 8',
                                         '9' => 'Level 9'
                                        ),
                'decorators' => $decoratorStack
            )
        );    
        
        $this->addElement('select', 'filter_descriptors', 
            array(
                'label'      => 'Descriptors:',
                'required'   => false,
                'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('descriptors'),
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

