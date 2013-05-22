<?php

class ArmourController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_ArmourService();      
            
        $this->view->headTitle('Armour');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all nonmagical RPG-protective gear available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/armour.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Armour');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $sourceModel = new Application_Model_Source();
        $typeModel = new Application_Model_ArmourType();
                
        $formConfig = array('sources' => $sourceModel->getListHavingArmour(),
                            'types' => $typeModel->getList()
            );
        $form = new Application_Form_Armourfilter($formConfig);
        
        if ($request->isPost()) {
            $form->isValid($request->getParams());
            $this->session->filter = $form->getValues();
        } else {
            $form->populate((array)$this->session->filter);
        }
        
        $this->view->form = $form; 
        
        $this->view->formvalues = $form->getValues();
        
        $this->view->list = $this->table->all($form->getValues());
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');

        $sourceModel = new Application_Model_Source();
        $typeModel = new Application_Model_ArmourType();
        
        $formConfig = array('types'       => $typeModel->getList(),
                            'sources'     => $sourceModel->getList()
                );
        
        $form = new Application_Form_Armour($formConfig);          
        
        if ($request->isPost()) {
        
            $post = $form->handleSubforms($request->getPost());
            
            if ($form->isValid($post)) {
                $id = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'armour',
                                                  'action' => 'view',
                                                  'id' => $id
                                                ),
                                            'controller-action-id'
                                            );
            }

        }
        
        
        if ($id) {
            $data = $this->table->find($id);
            
            $form->addSourceforms(count($data['arm_sources']) > 0 ? count($data['arm_sources']) : 1);

            $form->populate($data);
            
        } else {
            $form->addSourceforms(1);
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

    public function copyAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->copy($id); 
    }

}









