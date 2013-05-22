<?php

class Application_Form_Skill extends Zend_Form
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
        $mainform->addElement('text', 'skil_name', 
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

        $mainform->addElement('select', 'skil_keyability', 
            array(
                'order'        => 2,                
                'label'        => 'Key Ability:',
                'required'     => false,
                'multiOptions' => array('STR' => 'Strength',
                                        'CON' => 'Constitution',
                                        'DEX' => 'Dexterity',
                                        'INT' => 'Intelligence',
                                        'WIS' => 'Wisdom',
                                        'CHA' => 'Charisma'
                    ),
                'decorators'   => $decoratorStack
            )
        );            
        
        $mainform->addElement('radio', 'skil_trainedonly', 
            array(
                'order'      => 3,                
                'label'        => 'Trained Only:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'value'        => 'Y',
                'decorators'   => $decoratorStack
            )
        );              

        $mainform->addElement('radio', 'skil_armor', 
            array(
                'order'      => 4,                
                'label'        => 'Armour check penalty:',
                'disableLoadDefaultDecorators'=> true, // Bug in Zend_Element_Radio http://framework.zend.com/issues/browse/ZF-10065
                'required'     => true,
                'multiOptions' => array('N'=>'No', 'Y'=>'Yes'),
                'value'        => 'Y',
                'decorators'   => $decoratorStack
            )
        );             
        
        $mainform->addElement('textarea', 'skil_description', 
            array(
                'order'      => 5,                
                'label'      => 'Description:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );            

        $mainform->addElement('textarea', 'skil_check', 
            array(
                'order'      => 6,                
                'label'      => 'Check:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );        
        
        $mainform->addElement('textarea', 'skil_action', 
            array(
                'order'      => 7,                
                'label'      => 'Action:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );        
        
        $mainform->addElement('textarea', 'skil_tryagain', 
            array(
                'order'      => 8,                
                'label'      => 'Try Again:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );   
        
        $mainform->addElement('textarea', 'skil_special', 
            array(
                'order'      => 9,                
                'label'      => 'Special:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );   
        
        $mainform->addElement('textarea', 'skil_synergy', 
            array(
                'order'      => 10,                
                'label'      => 'Synergy:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );   
        
        $mainform->addElement('textarea', 'skil_restriction', 
            array(
                'order'      => 11,                
                'label'      => 'Restriction:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );   

        $mainform->addElement('textarea', 'skil_untrained', 
            array(
                'order'      => 12,                
                'label'      => 'Untrained:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );   

        $mainform->addElement('textarea', 'skil_epic', 
            array(
                'order'      => 14,                
                'label'      => 'Epic:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );           
                
        
        $mainform->addElement('select', 'skil_world', 
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

            $subForm->addElement('text', 'skso_page', 
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

