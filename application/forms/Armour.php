<?php

class Application_Form_Armour extends Zend_Form
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
        $mainform->addElement('text', 'arm_name', 
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
                
        $mainform->addElement('select', 'arm_type', 
            array(
                'order'      => 2,                
                'label'        => 'Type:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('types'),
                'decorators'   => $decoratorStack
            )
        );
        
        $mainform->addElement('text', 'arm_progression_level', 
            array(
                'order'      => 3,
                'label'      => 'Progress Level:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );   

        $mainform->addElement('select', 'arm_usetype', 
            array(
                'order'      => 4,
                'label'      => 'Type of Use:',
                'required'     => false,
                'multiOptions' => array('' => ' -- select --',
                                        'Impromptu' => 'Impromptu',
                                        'Concealable' => 'Concealable',
                                        'Tactical' => 'Tactical'
                    ),
                'decorators'   => $decoratorStack
            )
        );        
        
        $mainform->addElement('text', 'arm_price', 
            array(
                'order'      => 5,
                'label'      => 'Price:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );
                       
        $mainform->addElement('text', 'arm_bonus', 
            array(
                'order'      => 6,
                'label'      => 'Armour Bonus:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );            
        
        $mainform->addElement('text', 'arm_maxdex', 
            array(
                'order'      => 7,
                'label'      => 'Maximum Dex Bonus:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );              

        $mainform->addElement('text', 'arm_armorcheckpenalty', 
            array(
                'order'      => 9,
                'label'      => 'Armour Check Penalty:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );             

        $mainform->addElement('text', 'arm_arcanespellfailure', 
            array(
                'order'      => 11,
                'label'      => 'Arcane Spell Failure Chance:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );               

        $mainform->addElement('text', 'arm_speed30ft', 
            array(
                'order'      => 13,
                'label'      => 'Speed 30\':',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        ); 
        
        $mainform->addElement('text', 'arm_speed20ft', 
            array(
                'order'      => 15,
                'label'      => 'Speed 20\':',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        ); 

        $mainform->addElement('text', 'arm_weight', 
            array(
                'order'      => 17,
                'label'      => 'Weight:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );         
        
        $mainform->addElement('text', 'arm_img', 
            array(
                'order'      => 19,
                'label'      => 'Image:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );  
        
        $mainform->addElement('textarea', 'arm_description', 
            array(
                'order'      => 21,                
                'label'      => 'Description:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );                    
               
        
        $this->addElement('hidden', 'numberofsourceforms', 
            array(
                'order'      => 98,                
                'ignore'   => true,
                'decorators' =>  array( 
                    'ViewHelper'
                ),
                'value' => '1'
                
        ));        
        
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

    public function addSourceforms($nr)
    {
        for ($i=1; $i <= $nr; $i++) {
        
            $subForm = new Zend_Form_SubForm('sourceform' . $i);
            $subForm->setOrder(40 + $i);
            
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

            $subForm->addElement('text', 'arso_page', 
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
                                                'plusclass' => 'addsourcerow', 
                                                'minclass' => 'delsourcerow'
                                               ) ),
                        array(array('data'=>'HtmlTag'), array('tag' => 'td', 'closeOnly'=>true)),                    
                        array(array('row'=>'HtmlTag'), array('tag'=>'tr', 'closeOnly'=>true))
                        )   
                )
            );           

            $subForm->setDecorators(array(
                   'FormElements'
            ));        
        
            $this->addSubForm($subForm, 'sourceform' . $i);
        }        
    }     

    
    public function handleSubforms($post) 
    {
            $aSourceforms = array();
            
            // renumber to compensate for delete
            foreach($post as $key=>$value) {
                if (substr($key, 0, 10) == 'sourceform') {
                    if ((int)$value['src_id'] > 0) {
                        $aSourceforms[] = $value;
                    }
                    unset($post[$key]);
                }              
            }
            
            $i = 1;
            foreach((array)$aSourceforms as $form) {
                $post['sourceform' . $i] = $form;
                $i++;
            }
                        
            (int)$post['numberofsourceforms'] = (count($aSourceforms) > 0 ? count($aSourceforms) : 1);
            $this->addSourceforms((int)$post['numberofsourceforms']);        
            
        return $post;
    }    
    
}

