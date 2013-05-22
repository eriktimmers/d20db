<?php

class FeatController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_FeatService();         
            
        $this->view->headTitle('Feats');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-feats available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/feats.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Feat');
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $sourceModel = new Application_Model_Source();
        $descriptorModel = new Application_Model_SimpleTable('featdescriptors');
        $formConfig = array('sources' => $sourceModel->getListHavingFeats(),
                            'descriptors' => $descriptorModel->getList()
            );        
        $form = new Application_Form_FeatFilter($formConfig);
        
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
        
        $soureModel = new Application_Model_Source();
        $descriptorModel = new Application_Model_SimpleTable('featdescriptors');

        $formConfig = array('sources'      => $soureModel->getList(),
                            'types'        => $descriptorModel->getList()
            );
        
        $form = new Application_Form_Feat($formConfig);
        
        if ($request->isPost()) {
            $post = $request->getPost();
            
            
            $aSubforms = array();
            $aTypeforms = array();
            // renumber to compensate for delete
            foreach($post as $key=>$value) {
                if (substr($key, 0, 7) == 'subform') {
                    if ((int)$value['src_id'] > 0) {
                        $aSubforms[] = $value;
                    }
                    unset($post[$key]);
                }
                if (substr($key, 0, 8) == 'typeform') {
                    if ((int)$value['fty_id'] > 0) {
                        $aTypeforms[] = $value;
                    }
                    unset($post[$key]);
                }                
            }
            
            $i = 1;
            foreach((array)$aSubforms as $subform) {
                $post['subform' . $i] = $subform;
                $i++;
            }

            $i = 1;
            foreach((array)$aTypeforms as $subform) {
                $post['typeform' . $i] = $subform;
                $i++;
            }
            
            (int)$post['numberofsubforms'] = (count($aSubforms) > 0 ? count($aSubforms) : 1);
            $form->addSubforms((int)$post['numberofsubforms']);

            (int)$post['numberoftypes'] = (count($aTypeforms) > 0 ? count($aTypeforms) : 1);
            $form->addTypeforms((int)$post['numberoftypes']);            
            
            if ($form->isValid($post)) {
                
                $id = $this->table->save($id, $form);
                
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('controller' => 'feat',
                                                  'action' => 'view',
                                                  'id' => $id
                                                ),
                                            'controller-action-id'
                                            );    
            }

        } else {
        
        if ($id) {
            $this->view->title = 'Edit Feat';
            $data = $this->table->find($id);
            
            $form->addSubforms(count($data['fea_sources']) > 0 ? count($data['fea_sources']) : 1);
            $form->addTypeforms(count($data['fea_descriptor']) > 0 ? count($data['fea_descriptor']) : 1);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New Feat';           
            $form->addSubforms(1);
            $form->addTypeforms(1);
        }                
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


}







