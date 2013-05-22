<?php

class Application_Form_Spell extends Zend_Form
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
        $mainform->addElement('text', 'spl_name', 
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
        
        $mainform->addElement('text', 'spl_components', 
            array(
                'order'      => 5,
                'label'      => 'Components:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(1, 32)),
                ),
                'decorators' => $decoratorStack
            )
        ); 
        
        $mainform->addElement('text', 'spl_material', 
            array(
                'order'      => 7,
                'label'      => 'Material Components:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 100)),
                ),
                'decorators' => $decoratorStack
            )
        );         
        
        $mainform->addElement('text', 'spl_castingtime', 
            array(
                'order'      => 9,
                'label'      => 'Casting Time:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );              
        
        $mainform->addElement('text', 'spl_range', 
            array(
                'order'      => 11,
                'label'      => 'Range:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );              

        $mainform->addElement('text', 'spl_effecttype', 
            array(
                'order'      => 13,
                'label'      => 'Effect Type:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );            

        $mainform->addElement('text', 'spl_effect', 
            array(
                'order'      => 14,
                'label'      => 'Effect:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 128)),
                ),
                'decorators' => $decoratorStack
            )
        );               

        $mainform->addElement('text', 'spl_duration', 
            array(
                'order'      => 15,
                'label'      => 'Duration:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );

        $mainform->addElement('text', 'spl_savingthrow', 
            array(
                'order'      => 17,
                'label'      => 'Saving Throw:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );
        
        $mainform->addElement('text', 'spl_spellresistance', 
            array(
                'order'      => 19,
                'label'      => 'Spell Resistance:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );        
        
        $mainform->addElement('textarea', 'spl_shortdescription', 
            array(
                'order'      => 21,                
                'label'      => 'Short Description:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '3',
                'decorators' => $decoratorStack
            )
        ); 
        
        $mainform->addElement('textarea', 'spl_mediumdescription', 
            array(
                'order'      => 22,                
                'label'      => 'Medium Description:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        ); 
        
        $mainform->addElement('textarea', 'spl_longdescription', 
            array(
                'order'      => 23,                
                'label'      => 'Long Description:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '6',
                'decorators' => $decoratorStack
            )
        ); 
        
        $mainform->addElement('text', 'spl_img', 
            array(
                'order'      => 25,
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

        $mainform->addElement('select', 'spl_systeem', 
            array(
                'order'      => 27,                
                'label'        => 'Game System:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('gamesystems'),
                'decorators'   => $decoratorStack
            )
        );             

        $mainform->addElement('select', 'spl_world', 
            array(
                'order'      => 29,                
                'label'        => 'World:',
                'required'     => true,
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
        
        

        $this->addElement('hidden', 'numberofsourceforms', 
            array(
                'order'      => 98,                
                'ignore'   => true,
                'decorators' =>  array( 
                    'ViewHelper'
                ),
                'value' => '1'
                
        ));            

        $this->addElement('hidden', 'numberofclassforms', 
            array(
                'order'      => 97,                
                'ignore'   => true,
                'decorators' =>  array( 
                    'ViewHelper'
                ),
                'value' => '1'
                
        )); 
        
        $this->addElement('hidden', 'numberofdomainforms', 
            array(
                'order'      => 96,                
                'ignore'   => true,
                'decorators' =>  array( 
                    'ViewHelper'
                ),
                'value' => '1'
                
        )); 
        
        $this->addElement('hidden', 'numberofdescriptorforms', 
            array(
                'order'      => 95,                
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

            $subForm->addElement('text', 'spc_page', 
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
    
    public function addClassforms($nr)
    {
        for ($i=1; $i <= $nr; $i++) {
        
            $subForm = new Zend_Form_SubForm('classform' . $i);
            $subForm->setOrder(50 + $i);
            
            $subForm->addElement('select', 'cls_id', 
                array(                    
                    //'isArray'    => true,
                    'label'      => 'Class:',
                    'class'      => 'cls_id',
                    'required'   => false,
                    'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('classes'),
                    'decorators' => array( 
                        'ViewHelper',
                        array(array('data'=>'HtmlTag'), array('tag' => 'td', 'openOnly'=>true)),
                        array('Label', array('tag' => 'td')),
                        array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'openOnly'=>true))
                        )   
                )
            );  

            $subForm->addElement('text', 'spcl_level', 
                array(
                    //'isArray'    => true,
                    'label'      => 'Level:',
                    'class'      => 'cls_level',
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
                                                'plusclass' => 'addclassrow', 
                                                'minclass' => 'delclassrow'
                                               ) ),
                        array(array('data'=>'HtmlTag'), array('tag' => 'td', 'closeOnly'=>true)),                    
                        array(array('row'=>'HtmlTag'), array('tag'=>'tr', 'closeOnly'=>true))
                        )   
                )
            );           

            $subForm->setDecorators(array(
                   'FormElements'
            ));        
        
            $this->addSubForm($subForm, 'classform' . $i);
        }        
    }     
    
    public function addDomainforms($nr)
    {
        for ($i=1; $i <= $nr; $i++) {
        
            $subForm = new Zend_Form_SubForm('domainform' . $i);
            $subForm->setOrder(60 + $i);
            
            $subForm->addElement('select', 'dom_id', 
                array(                    
                    //'isArray'    => true,
                    'label'      => 'Domain:',
                    'class'      => 'dom_id',
                    'required'   => false,
                    'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('domains'),
                    'decorators' => array( 
                        'ViewHelper',
                        array(array('data'=>'HtmlTag'), array('tag' => 'td', 'openOnly'=>true)),
                        array('Label', array('tag' => 'td')),
                        array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'openOnly'=>true))
                        )   
                )
            );  

            $subForm->addElement('text', 'spdm_level', 
                array(
                    //'isArray'    => true,
                    'label'      => 'Level:',
                    'class'      => 'dom_level',
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
                                                'plusclass' => 'adddomainrow', 
                                                'minclass' => 'deldomainrow'
                                               ) ),
                        array(array('data'=>'HtmlTag'), array('tag' => 'td', 'closeOnly'=>true)),                    
                        array(array('row'=>'HtmlTag'), array('tag'=>'tr', 'closeOnly'=>true))
                        )   
                )
            );           

            $subForm->setDecorators(array(
                   'FormElements'
            ));        
        
            $this->addSubForm($subForm, 'domainform' . $i);
        }        
    }       
        
    public function addSchoolforms($nr)
    {
        for ($i=1; $i <= $nr; $i++) {
        
            $subForm = new Zend_Form_SubForm('schoolform' . $i);
            $subForm->setOrder(70 + $i);
            
            $subForm->addElement('select', 'subs_id', 
                array(                    
                    //'isArray'    => true,
                    'label'      => 'School:',
                    'class'      => 'sch_id',
                    'required'   => false,
                    'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('schools'),
                    'decorators' => array( 
                               'ViewHelper',
                               //array('Callback', array('callback' => array('Application_Model_Util', 'PlusMin'),
                               //                 'plusclass' => 'addtyperow', 
                               //                 'minclass' => 'deltyperow'
                               //                )),
                               array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                               array('Label', array('tag' => 'td')),
                               array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
                        )    
                )
            );  

          

            $subForm->setDecorators(array(
                   'FormElements'
            ));        
        
            $this->addSubForm($subForm, 'schoolform' . $i);
        }        
    }     
    
    public function addDescriptorforms($nr)
    {
        for ($i=1; $i <= $nr; $i++) {
        
            $subForm = new Zend_Form_SubForm('descriptorform' . $i);
            $subForm->setOrder(80 + $i);
            
            $subForm->addElement('select', 'dcp_id', 
                array(                    
                    //'isArray'    => true,
                    'label'      => 'Descriptors:',
                    'class'      => 'dcp_id',
                    'required'   => false,
                    'multiOptions' =>  array('0' => ' -- select --') + $this->getAttrib('descriptors'),
                    'decorators' => array( 
                               'ViewHelper',
                               array('Callback', array('callback' => array('Application_Model_Util', 'PlusMin'),
                                                'plusclass' => 'adddescriptorrow', 
                                                'minclass' => 'deldescriptorrow'
                                               )),
                               array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                               array('Label', array('tag' => 'td')),
                               array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
                        )    
                )
            );  

          

            $subForm->setDecorators(array(
                   'FormElements'
            ));        
        
            $this->addSubForm($subForm, 'descriptorform' . $i);
        }        
    }     
        
    
    public function handleSubforms($post) 
    {
            $aSourceforms = array();
            $aClassforms = array();
            $aDomainforms = array();            
            // renumber to compensate for delete
            foreach($post as $key=>$value) {
                if (substr($key, 0, 10) == 'sourceform') {
                    if ((int)$value['src_id'] > 0) {
                        $aSourceforms[] = $value;
                    }
                    unset($post[$key]);
                }
                if (substr($key, 0, 9) == 'classform') {
                    if ((int)$value['cls_id'] > 0) {
                        $aClassforms[] = $value;
                    }
                    unset($post[$key]);
                }                
                if (substr($key, 0, 10) == 'domainform') {
                    if ((int)$value['dom_id'] > 0) {
                        $aDomainforms[] = $value;
                    }
                    unset($post[$key]);
                }                
                if (substr($key, 0, 14) == 'descriptorform') {
                    if ((int)$value['dcp_id'] > 0) {
                        $aDescriptorforms[] = $value;
                    }
                    unset($post[$key]);
                }                     
            }
            
            $i = 1;
            foreach((array)$aSourceforms as $form) {
                $post['sourceform' . $i] = $form;
                $i++;
            }
            $i = 1;
            foreach((array)$aClassforms as $form) {
                $post['classform' . $i] = $form;
                $i++;
            }
            $i = 1;
            foreach((array)$aDomainforms as $form) {
                $post['domainform' . $i] = $form;
                $i++;
            }
            $i = 1;
            foreach((array)$aDescriptorforms as $form) {
                $post['descriptorform' . $i] = $form;
                $i++;
            }             
                        
            (int)$post['numberofsourceforms'] = (count($aSourceforms) > 0 ? count($aSourceforms) : 1);
            $this->addSourceforms((int)$post['numberofsourceforms']);        
            (int)$post['numberofclassforms'] = (count($aClassforms) > 0 ? count($aClassforms) : 1);
            $this->addClassforms((int)$post['numberofclassforms']);          
            (int)$post['numberofdomainforms'] = (count($aDomainforms) > 0 ? count($aDomainforms) : 1);
            $this->addDomainforms((int)$post['numberofdomainforms']);
            $this->addSchoolforms(1);
            (int)$post['numberofdescriptorforms'] = (count($aDescriptorforms) > 0 ? count($aDescriptorforms) : 1);
            $this->addDescriptorforms((int)$post['numberofdescriptorforms']);            
            
        return $post;
    }

}

