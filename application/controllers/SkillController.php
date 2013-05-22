<?php

class SkillController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_SkillService();      
            
        $this->view->headTitle('Skills');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-skills available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/skills.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Skill');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $soureModel = new Application_Model_Source();
        $formConfig = array('sources' => $soureModel->getListHavingSkills()
            );
        $form = new Application_Form_Skillfilter($formConfig);
        
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

        $worldModel  = new Application_Model_SimpleTable('worlds');
        $sourceModel = new Application_Model_Source();
        
        $formConfig = array('worlds'        => $worldModel->getList(),
                            'sources'       => $sourceModel->getList()
            );
        
        $form = new Application_Form_Skill($formConfig);          
        
        if ($request->isPost()) {
        
            $post = $form->handleSubforms($request->getPost());
            
            if ($form->isValid($post)) {
                $id = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'skill',
                                                  'action' => 'view',
                                                  'id' => $id
                                                ),
                                            'controller-action-id'
                                            );
            }

        }        
        
        
        if ($id) {
            $this->view->title = 'Edit Skill';
            $data = $this->table->find($id);
            
            $form->addSubforms(count($data['skil_sources']) > 0 ? count($data['skil_sources']) : 1);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New Skill';           
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









