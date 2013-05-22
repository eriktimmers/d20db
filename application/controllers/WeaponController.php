<?php

class WeaponController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_WeaponService();      
            
        $this->view->headTitle('Weapon');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-weapons available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/weapon.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Weapon');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $sourceModel = new Application_Model_Source();
        $formConfig = array('sources' => $sourceModel->getListHavingWeapons(),
                            'trainings'    => $this->table->getListTrainingCategory(),
                            'reaches'      => $this->table->getListReachCategory(),
                            'reachsubs'    => $this->table->getListReachSubcategory(),
                            'encumbrances' => $this->table->getListEncumbrancecategory()
            );
        $form = new Application_Form_Weaponfilter($formConfig);
        
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
        $damageModel  = new Application_Model_SimpleTable('damagetype');
        
        $formConfig = array('sources'      => $sourceModel->getList(),
                            'trainings'    => $this->table->getListTrainingCategory(),
                            'reaches'      => $this->table->getListReachCategory(),
                            'reachsubs'    => $this->table->getListReachSubcategory(),
                            'encumbrances' => $this->table->getListEncumbrancecategory(),
                            'damagetypes'  => $damageModel->getList(),
                            'rof'          => $this->table->getListRateOfFire()
            
                );
        
        $form = new Application_Form_Weapon($formConfig);          
        
        if ($request->isPost()) {
        
            $post = $form->handleSubforms($request->getPost());
            
            if ($form->isValid($post)) {
                $newid = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'weapon',
                                                  'action' => 'view',
                                                  'id' => $newid
                                                ),
                                            'controller-action-id'
                                            );
            }

        } else {
        
        
            if ($id) {
                $data = $this->table->find($id);

                $form->addSourceforms(count($data['wea_sources']) > 0 ? count($data['wea_sources']) : 1);

                $form->populate($data);

            } else {
                $form->addSourceforms(1);
            } 
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









