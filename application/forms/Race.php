<?php

class Application_Form_Race extends Zend_Form
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
        $mainform->addElement('text', 'rce_name', 
            array(
                'order'      => 1,
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
        
        $mainform->addElement('text', 'rce_subrace', 
            array(
                'order'      => 2,
                'label'      => 'Subrace:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 64)),
                ),
                'decorators' => $decoratorStack
            )
        );   
        
        $mainform->addElement('radio', 'rce_ismainrace', 
            array(
                'order'      => 3,                
                'label'        => 'Is main of:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'value'        => 'Y',
                'decorators'   => $decoratorStack
            )
        );        
        
        $mainform->addElement('text', 'rce_group', 
            array(
                'order'      => 4,
                'label'      => 'Type:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(3, 64)),
                ),
                'value'        => 'Humanoid ()',                
                'decorators' => $decoratorStack
            )
        ); 
        
        $mainform->addElement('radio', 'rce_size', 
            array(
                'order'      => 5,                
                'label'        => 'Size:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('S'=>'Small', 'M'=>'Medium', 'L'=>'Large'),
                'value'        => 'M',
                'decorators'   => $decoratorStack
            )
        );         
        
        $mainform->addElement('text', 'rce_speed', 
            array(
                'order'      => 6,
                'label'      => 'Speed:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(3, 64)),
                ),
                'value'      => "30'",
                'decorators' => $decoratorStack
            )
        );   
        
        $mainform->addElement('select', 'rce_vision', 
            array(
                'order'        => 7,                
                'label'        => 'Vision:',
                'required'     => false,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('vision'),
                'value'        => 1,
                'decorators'   => $decoratorStack
            )
        );           

        $mainform->addElement('text', 'rcs_attr_str', 
            array(
                'order'      => 11,
                'label'      => 'Strength modifier:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );           
        
        $mainform->addElement('text', 'rcs_attr_con', 
            array(
                'order'      => 12,
                'label'      => 'Constitution modifier:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );  
        
        $mainform->addElement('text', 'rcs_attr_dex', 
            array(
                'order'      => 13,
                'label'      => 'Dexterity modifier:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );  
        
        $mainform->addElement('text', 'rcs_attr_int', 
            array(
                'order'      => 14,
                'label'      => 'Intelligence modifier:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );          
        
        $mainform->addElement('text', 'rcs_attr_wis', 
            array(
                'order'      => 15,
                'label'      => 'Wisdom modifier:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );  
        
        $mainform->addElement('text', 'rcs_attr_cha', 
            array(
                'order'      => 16,
                'label'      => 'Charisma modifier:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );  
        
        $mainform->addElement('text', 'rce_naturalarmor', 
            array(
                'order'      => 21,
                'label'      => 'Natural Armor:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );   
               
        
        $mainform->addElement('select', 'rce_favouredclass', 
            array(
                'order'        => 22,                
                'label'        => 'Favoured Class:',
                'required'     => false,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('favouredclass'),
                'decorators'   => $decoratorStack
            )
        );         

        
        $mainform->addElement('text', 'rce_ecl', 
            array(
                'order'      => 23,
                'label'      => 'Level Adjustment:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );      
        
        $mainform->addElement('text', 'rce_basehd', 
            array(
                'order'      => 24,
                'label'      => 'Base Hit Dice:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );          
        
        $mainform->addElement('textarea', 'rce_description', 
            array(
                'order'      => 30,                
                'label'      => 'Description:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );        
        
        $mainform->addElement('textarea', 'rce_detail', 
            array(
                'order'      => 31,                
                'label'      => 'Detail:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '6',
                'decorators' => $decoratorStack
            )
        );    
        
        $mainform->addElement('text', 'rce_img', 
            array(
                'order'      => 32,
                'label'      => 'Image:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 64)),
                ),
                'decorators' => $decoratorStack
            )
        );           
        
        
        $mainform->addElement('select', 'rce_world', 
            array(
                'order'      => 50,                
                'label'        => 'World:',
                'required'     => false,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('worlds'),
                'decorators'   => $decoratorStack
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

            $subForm->addElement('text', 'rcso_page', 
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

    public function handleSubforms($post)
    {
            $aSubforms = array();
            // renumber to compensate for delete
            foreach($post as $key=>$value) {
                if (substr($key, 0, 7) == 'subform') {
                    if ((int)$value['src_id'] > 0) {
                        $aSubforms[] = $value;
                    }
                    unset($post[$key]);
                }
            }
            
            $i = 1;
            foreach((array)$aSubforms as $subform) {
                $post['subform' . $i] = $subform;
                $i++;
            }
            
            (int)$post['numberofsubforms'] = (count($aSubforms) > 0 ? count($aSubforms) : 1);
            $this->addSubforms((int)$post['numberofsubforms']);
            
            return $post;
    }    
    
    
}

