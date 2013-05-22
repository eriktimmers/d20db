<?php



class Application_Form_Class extends Zend_Form
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
        
        $mainform = new Zend_Form_SubForm('mainform');
        $mainform->setOrder(1);
        
        // Add an name element
        $mainform->addElement('text', 'cls_name', 
            array(
                'order'      => 1,
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
        
        $mainform->addElement('radio', 'cls_npc', 
            array(
                'order'      => 2,
                'label'        => 'Is NPC class:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'decorators'   => $decoratorStack
            )
        );                 

        $mainform->addElement('radio', 'cls_prestige', 
            array(
                'order'      => 3,
                'label'        => 'Is Prestige class:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'decorators'   => $decoratorStack
            )
        );   
        

        $mainform->addElement('select', 'cls_subclass', 
            array(
                'order'      => 4,                
                'label'        => 'Is subclass of:',
                'required'     => false,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('parents'),
                'decorators'   => $decoratorStack
            )
        );         
        
        $mainform->addElement('select', 'cls_world', 
            array(
                'order'      => 5,                
                'label'        => 'World:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('worlds'),
                'decorators'   => $decoratorStack
            )
        ); 
        
        $mainform->addElement('radio', 'cls_isaggregate', 
            array(
                'order'      => 6,                
                'label'        => 'Is a spell aggregate class:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'decorators'   => $decoratorStack
            )
        );                  
        
        $mainform->addElement('radio', 'cls_arcanespells', 
            array(
                'order'      => 7,
                'label'        => 'Can use arcane spells:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'decorators'   => $decoratorStack
            )
        );                  
        
        $mainform->addElement('radio', 'cls_divinespells', 
            array(
                'order'      => 8,                
                'label'        => 'Can use divine spells:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'decorators'   => $decoratorStack
            )
        );                           
        
        $mainform->addElement('radio', 'cls_psionics', 
            array(
                'order'      => 9,                
                'label'        => 'Can manifest psionic powers:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'decorators'   => $decoratorStack
            )
        );      
        
        $mainform->addElement('select', 'cls_aggregatedin', 
            array(
                'order'      => 10,                
                'label'        => 'Use spells of:',
                'required'     => false,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('spellclasses'),
                'decorators'   => $decoratorStack
            )
        );                 
        
        // Add an name element
        $mainform->addElement('text', 'cls_img', 
            array(
                'order'      => 11,                
                'label'      => 'Image:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );        

        $mainform->addElement('textarea', 'cls_short_description', 
            array(
                'order'      => 12,                
                'label'      => 'Description:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '6',
                'decorators' => $decoratorStack
            )
        );
        
        // Add the submit button
        $this->addElement('submit', 'submit', 
            array(
                'order'      => 99,                
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
        
        $this->addElement('hidden', 'numberofsubforms', 
            array(
                'order'      => 98,                
                'ignore'   => true,
                'decorators' =>  array( 
                    'ViewHelper'
                ),
                'value' => '1'
                
        ));        
        
        $mainform->setDecorators(array(
              'FormElements'
        ));        
        
        $this->addSubForm($mainform, 'mainform');        
        
        $this->setDecorators(array(
               'FormElements',
               array(array('data'=>'HtmlTag'), array('tag'=>'table', 'class'=>'formtable formtablesource')),
               'Form'
        ));          
        
    }
    
    public function addSubforms($nr)
    {
        for ($i=1; $i <= $nr; $i++) {
        
            $subForm = new Zend_Form_SubForm('subform' . $i);
            $subForm->setOrder(20 + $i);
            
            $subForm->addElement('select', 'src_id', 
                array(                    
                    //'isArray'    => true,
                    'label'      => 'Source:',
                    'class'      => 'src_id',
                    'required'   => false,
                    'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('sources'),
                    'decorators' => array( 
                        'ViewHelper',
                        array(array('data'=>'HtmlTag'), array('tag' => 'td', 'openOnly'=>true)),
                        array('Label', array('tag' => 'td')),
                        array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'openOnly'=>true))
                        )   
                )
            );  

            $subForm->addElement('text', 'clso_page', 
                array(
                    //'isArray'    => true,
                    'label'      => 'Page:',
                    'class'      => 'src_page',
                    'required'   => false,
                    'filters'    => array('StringTrim', 'StripTags'),
                    'validators' => array(
                        array('validator' => 'StringLength',
                              'options' => array(0, 5)),
                    ),
                    'decorators' => array( 
                        'ViewHelper',
                        array('Label'),
                        array('Callback', array('callback' => array('Application_Model_Util', 'PlusMin'),
                                                'plusclass' => 'addrow', 
                                                'minclass' => 'delrow'
                                               ) ),
                        array(array('data'=>'HtmlTag'), array('tag' => 'td', 'closeOnly'=>true)),                    
                        array(array('row'=>'HtmlTag'), array('tag'=>'tr', 'closeOnly'=>true))
                        )   
                )
            );           

            $subForm->setDecorators(array(
                   'FormElements'
            ));        
        
            $this->addSubForm($subForm, 'subform' . $i);
        }        
    }


}

