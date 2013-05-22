<?php

class SpellController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_SpellService();      
            
        $this->view->headTitle('Spells');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-spells available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/spells.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Spell');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $sourceModel = new Application_Model_Source();
        $classModel  = new Application_Model_Class();
        $descriptorModel  = new Application_Model_SimpleTable('spelldescriptors');
        
        $formConfig = array('sources' => $sourceModel->getListHavingSpells(),
                            'classes' => $classModel->getListSpellLists(),
                            'descriptors' => $descriptorModel->getList()
            );
        $form = new Application_Form_Spellfilter($formConfig);
        
        if ($request->isPost()) {
            $form->isValid($request->getParams());
            $this->session->filter = $form->getValues();
        } else {
            $form->populate((array)$this->session->filter);
        }
        
        
        $this->view->form = $form; 
                
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

        $gameSystemModel = new Application_Model_Gamesystem();
        $worldModel = new Application_Model_SimpleTable('worlds');
        $sourceModel = new Application_Model_Source();
        $classModel  = new Application_Model_Class();
        $domainModel = new Application_Model_SimpleTable('domains');
        $schoolModel  = new Application_Model_SchoolService();
        $descriptorModel  = new Application_Model_SimpleTable('spelldescriptors');
        
        $formConfig = array('gamesystems' => $gameSystemModel->getList(),
                            'worlds'      => $worldModel->getList(),
                            'sources'     => $sourceModel->getList(),
                            'classes'     => $classModel->evenMoreSpellcastingClasses(),
                            'domains'     => $domainModel->getList(),
                            'schools'     => $schoolModel->getList(),
                            'descriptors' => $descriptorModel->getList()

                );
        
        $form = new Application_Form_Spell($formConfig);          
        
        if ($request->isPost()) {
        
            $post = $form->handleSubforms($request->getPost());
            
            if ($form->isValid($post)) {
                $id = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'spell',
                                                  'action' => 'view',
                                                  'id' => $id
                                                ),
                                            'controller-action-id'
                                            );
            }

        }
        
        
        if ($id) {
            $data = $this->table->find($id);
            
            $form->addSourceforms(count($data['spl_sources']) > 0 ? count($data['spl_sources']) : 1);
            $form->addClassforms(count($data['spl_classes']) > 0 ? count($data['spl_classes']) : 1);
            $form->addDomainforms(count($data['spl_domains']) > 0 ? count($data['spl_domains']) : 1);
            $form->addSchoolforms(1);
            $form->addDescriptorforms(count($data['spl_descriptors']) > 0 ? count($data['spl_descriptors']) : 1);
            $form->populate($data);
            
        } else {
            $form->addSourceforms(1);
            $form->addClassforms(1);
            $form->addDomainforms(1);
            $form->addSchoolforms(1);
            $form->addDescriptorforms(1);
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







