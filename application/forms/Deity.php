<?php

class Application_Form_Deity extends Zend_Form
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
        $mainform->addElement('text', 'dei_name', 
            array(
                'order'      => 1,
                'label'      => 'Name:',
                'required'   => true,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(1, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );             

        $mainform->addElement('select', 'dei_pantheon', 
            array(
                'order'      => 2,                
                'label'        => 'Pantheon:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('pantheons'),
                'decorators'   => $decoratorStack
            )
        );             
        
        $mainform->addElement('select', 'dei_rank', 
            array(
                'order'      => 3,                
                'label'        => 'Rank:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('ranks'),
                'decorators'   => $decoratorStack
            )
        );          
        
        $mainform->addElement('text', 'dei_symbol', 
            array(
                'order'      => 4,
                'label'      => 'Symbol:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 64)),
                ),
                'decorators' => $decoratorStack
            )
        );           
        
        $mainform->addElement('text', 'dei_homeplane', 
            array(
                'order'      => 5,
                'label'      => 'Home Plane',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 64)),
                ),
                'decorators' => $decoratorStack
            )
        );           

        $mainform->addElement('select', 'dei_alignment', 
            array(
                'order'      => 6,                
                'label'        => 'Alignment:',
                'required'     => true,
                'multiOptions' => array('0' => ' -- select --') + $this->getAttrib('alignments'),
                'decorators'   => $decoratorStack
            )
        );          
        
        $mainform->addElement('text', 'dei_titles', 
            array(
                'order'      => 7,
                'label'      => 'Titles',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 64)),
                ),
                'decorators' => $decoratorStack
            )
        );            
        
        $mainform->addElement('textarea', 'dei_portfolio', 
            array(
                'order'      => 10,                
                'label'      => 'Portfolio:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 128)),
                ),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        ); 

        $mainform->addElement('textarea', 'dei_worshippers', 
            array(
                'order'      => 11,                
                'label'      => 'Worshippers:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 128)),
                ),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );         
        
        $mainform->addElement('textarea', 'dei_domains', 
            array(
                'order'      => 12,                
                'label'      => 'Domains:',
                'required'   => false,
                'filters'    => array('StringTrim'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 128)),
                ),
                'cols'       => '80',
                'rows'       => '4',
                'decorators' => $decoratorStack
            )
        );                 
        
        $mainform->addElement('text', 'dei_weapon', 
            array(
                'order'      => 15,
                'label'      => 'Favored Weapon:',
                'required'   => false,
                'filters'    => array('StringTrim', 'StripTags'),
                'validators' => array(
                    array('validator' => 'StringLength',
                          'options' => array(0, 32)),
                ),
                'decorators' => $decoratorStack
            )
        );             

        
        $mainform->addElement('text', 'dei_img', 
            array(
                'order'      => 16,
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
        
        $mainform->addElement('textarea', 'dei_description', 
            array(
                'order'      => 19,                
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

            $subForm->addElement('text', 'deso_page', 
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

