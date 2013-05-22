<?php

class DeityController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_DeityService();      
            
        $this->view->headTitle('Deities');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-deities available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/deities.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Deity');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $soureModel = new Application_Model_Source();
        $pantheonModel  = new Application_Model_SimpleTable('pantheons');
                
        $formConfig = array('sources' => $soureModel->getListHavingDeities(),
                            'pantheons' => $pantheonModel->getList()
            );
        $form = new Application_Form_Deityfilter($formConfig);
        
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

    public function viewAction()
    {
        $this->view->id = (int)$this->getRequest()->getParam('id');
        $this->view->item = $this->table->find($this->view->id);
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');

        $pantheonModel  = new Application_Model_SimpleTable('pantheons');
        $alignmentModel  = new Application_Model_SimpleTable('alignments');
        $rankModel  = new Application_Model_SimpleTable('deityranks');
        $sourceModel  = new Application_Model_Source();
        
        $formConfig = array('pantheons'     => $pantheonModel->getList(),
                            'alignments'    => $alignmentModel->getList(),                            
                            'sources'       => $sourceModel->getList(),
                            'ranks'         => $rankModel->getList()
            );
        
        $form = new Application_Form_Deity($formConfig);          
        
        if ($request->isPost()) {
        
            $post = $form->handleSubforms($request->getPost());
            
            if ($form->isValid($post)) {
                $id = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'deity',
                                                  'action' => 'view',
                                                  'id' => $id
                                                ),
                                            'controller-action-id'
                                            );
            }

        }
        
        
        if ($id) {
            $this->view->title = 'Edit Deity';
            $data = $this->table->find($id);
            
            $form->addSubforms(count($data['dei_sources']) > 0 ? count($data['dei_sources']) : 1);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New Deity';           
            $form->addSubforms(1);
        } 
        
        $this->view->form = $form;
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









