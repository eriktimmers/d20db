<?php

class ClassController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_Class();         
            
        $this->view->headTitle('Classes');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-classes available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/classes.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Class');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $soureModel = new Application_Model_Source();
        $formConfig = array('sources' => $soureModel->getListHavingClasses()
            );        
        $form = new Application_Form_Classfilter($formConfig);
        
        if ($request->isPost()) {
            $form->isValid($request->getParams());
            $this->session->filter = $form->getValues();
        } else {
            $form->populate((array)$this->session->filter);
        }
        
        $this->view->form = $form; 
        
        $this->view->list = $this->table->all($form->getValues());
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');
        
        $worldModel = new Application_Model_SimpleTable('worlds');
        $soureModel = new Application_Model_Source();

        $formConfig = array('worlds'       => $worldModel->getList(),
                            'parents'      => $this->table->allParents(),
                            'spellclasses' => $this->table->allSpellcastingClasses(),
                            'sources'      => $soureModel->getList()
            );
        
        $form = new Application_Form_Class($formConfig);        
        
        if ($request->isPost()) {
            $post = $request->getPost();
            
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
            $form->addSubforms((int)$post['numberofsubforms']);
                       
            if ($form->isValid($post)) {
                $id = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'class',
                                                  'action' => 'view',
                                                  'id' => $id
                                                ),
                                            'controller-action-id'
                                            );     
            }

        }
        
        if ($id) {
            $this->view->title = 'Edit Source';
            $data = $this->table->find($id);
            
            $form->addSubforms(count($data['cls_sources']) > 0 ? count($data['cls_sources']) : 1);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New Source';           
            $form->addSubforms(1);
        }                
        
        $this->view->form = $form;    
    }

    public function viewAction()
    {
        $this->view->id = (int)$this->getRequest()->getParam('id');
        $this->view->item = $this->table->find($this->view->id);
    }

    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->delete($id);  
    }


}







