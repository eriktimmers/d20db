<?php

class Application_Form_Weapon extends Zend_Form
{

    public function init()
    {
        $oSystemFilter = new Zend_Session_Namespace('SystemFilter');
        $systemFilter = $oSystemFilter->filter;
        
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
        $mainform->addElement('text', 'wea_name', 
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
        
        $mainform->addElement('select', 'wea_trainingcategory', 
            array(
                'order'      => 3,                
                'label'        => 'Training category:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('trainings'),
                'decorators'   => $decoratorStack
            )
        );

        $mainform->addElement('select', 'wea_reachcategory', 
            array(
                'order'      => 5,                
                'label'        => 'Reach category:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('reaches'),
                'decorators'   => $decoratorStack
            )
        );

        $mainform->addElement('select', 'wea_reachsubcategory', 
            array(
                'order'      => 7,                
                'label'        => 'Reach subcategory:',
                'required'     => false,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('reachsubs'),
                'decorators'   => $decoratorStack
            )
        );        
        
        $mainform->addElement('select', 'wea_encumbrance', 
            array(
                'order'      => 9,                
                'label'        => 'Encumbrance:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('encumbrances'),
                'decorators'   => $decoratorStack
            )
        );
        
        $mainform->addElement('text', 'wea_cost', 
            array(
                'order'      => 11,
                'label'      => 'Cost:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );        
        
        $mainform->addElement('text', 'wea_dmg_s', 
            array(
                'order'      => 13,
                'label'      => 'Damage to Small:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );           
        
        $mainform->addElement('text', 'wea_dmg_m', 
            array(
                'order'      => 15,
                'label'      => 'Damage to Medium/Large:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );   
        
        $mainform->addElement('text', 'wea_critical_range', 
            array(
                'order'      => 17,
                'label'      => 'Lower limit Critical range:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'value'      => 20,
                'decorators' => $decoratorStack
            )
        );           

        $mainform->addElement('text', 'wea_critical_multiplier', 
            array(
                'order'      => 19,
                'label'      => 'Critical multiplier:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'value'      => 2,
                'decorators' => $decoratorStack
            )
        );            

        $mainform->addElement('text', 'wea_range_increment', 
            array(
                'order'      => 21,
                'label'      => 'Range increment:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );          

        $mainform->addElement('text', 'wea_weight', 
            array(
                'order'      => 23,
                'label'      => 'Weight:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'int'),
                ),
                'decorators' => $decoratorStack
            )
        );          

        $mainform->addElement('select', 'wea_damagetype', 
            array(
                'order'      => 25,                
                'label'        => 'Damagetype:',
                'required'     => true,
                'multiOptions' => array('' => ' -- select --') + $this->getAttrib('damagetypes'),
                'decorators'   => $decoratorStack
            )
        );           
        
        if ($systemFilter->isIncluded($systemFilter->MODERN)) {
        
            $mainform->addElement('select', 'wea_size', 
                array(
                    'order'      => 27,                
                    'label'        => 'Size:',
                    'required'     => false,
                    'multiOptions' => array('' => ' -- select --',
                                            'T' => 'Tiny',
                                            'S' => 'Small',
                                            'M' => 'Medium',
                                            'L' => 'Large',
                                            'H' => 'Huge'
                        ),
                    'decorators'   => $decoratorStack
                )
            );         



            $mainform->addElement('select', 'wea_rateoffire', 
                array(
                    'order'      => 29,
                    'label'      => 'Rate of Fire:',
                    'required'   => false,
                    'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('rof'),
                    'decorators'   => $decoratorStack
                )
            );         

            $mainform->addElement('text', 'wea_magazine', 
                array(
                    'order'      => 31,
                    'label'      => 'Magazine:',
                    'required'   => false,
                    'filters'    => array('StringTrim', 'StripTags'),
                    'validators' => array(
                        array('validator' => 'StringLength',
                              'options' => array(0, 100)),
                    ),
                    'decorators' => $decoratorStack
                )
            );          

        }
            
        $mainform->addElement('text', 'wea_specialtype', 
            array(
                'order'      => 32,
                'label'      => 'Special Label:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );              
        
        $mainform->addElement('text', 'wea_special', 
            array(
                'order'      => 33,
                'label'      => 'Special Content:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );            
        
        if ($systemFilter->isIncluded($systemFilter->MODERN)) {
            $mainform->addElement('text', 'wea_progresslevel', 
                array(
                    'order'      => 35,
                    'label'      => 'Progresslevel:',
                    'required'   => false,
                    'filters'    => array('StringTrim', 'StripTags'),
                    'validators' => array(
                        array('validator' => 'int'),
                    ),
                    'decorators' => $decoratorStack
                )
            );        
        } else {
            $mainform->addElement('hidden', 'wea_progresslevel', 
                array(
                    'order'      => 35,
                    'label'      => 'Progresslevel:',
                    'required'   => false,
                    'filters'    => array('StringTrim', 'StripTags'),
                    'validators' => array(
                        array('validator' => 'int'),
                    ),
                    'value'      => 2,
                    'decorators' =>  array( 
                        'ViewHelper'
                    ),
                )
            );            
            
        }
        
        $mainform->addElement('text', 'wea_img', 
            array(
                'order'      => 37,
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
        
        $mainform->addElement('textarea', 'wea_description', 
            array(
                'order'      => 38,                
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
            $subForm->setOrder(50 + $i);
            
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

            $subForm->addElement('text', 'weso_page', 
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

