<?php

class RaceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_RaceService();      
            
        $this->view->headTitle('Races');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-races available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/races.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Race');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $soureModel = new Application_Model_Source();
        $formConfig = array('sources' => $soureModel->getListHavingRaces()
            );
        $form = new Application_Form_Racefilter($formConfig);
        
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

    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->delete($id); 
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');

        $worldModel  = new Application_Model_SimpleTable('worlds');
        $visionModel = new Application_Model_SimpleTable('visions');
        $soureModel  = new Application_Model_Source();
        $classModel  = new Application_Model_Class();
        
        $formConfig = array('worlds'        => $worldModel->getList(),
                            'sources'       => $soureModel->getList(),
                            'vision'        => $visionModel->getList(),
                            'favouredclass' => $classModel->allParents()
            );
        
        $form = new Application_Form_Race($formConfig);          
        
        if ($request->isPost()) {
        
            $post = $form->handleSubforms($request->getPost());
            
            if ($form->isValid($post)) {
                $id = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'race',
                                                  'action' => 'view',
                                                  'id' => $id
                                                ),
                                            'controller-action-id'
                                            );
            }

        }
        
        
        if ($id) {
            $this->view->title = 'Edit Race';
            $data = $this->table->find($id);
            
            $form->addSubforms(count($data['rce_sources']) > 0 ? count($data['rce_sources']) : 1);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New Race';           
            $form->addSubforms(1);
        } 
        
        $this->view->form = $form;          
    }
    
    public function copyAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->copy($id); 
    }


}









