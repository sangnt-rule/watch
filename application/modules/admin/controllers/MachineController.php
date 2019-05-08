<?php
class Admin_MachineController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $name = $this->getRequest()->getParam('name');
        $active = $this->getRequest()->getParam('active', -1);
        $this->loadGird(
            Admin_Model_Machine::getInstance()->getAll($name, $active)
        );
        $this->view->assign('name',$name);
        $this->view->assign('active',$active);
    }
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $machine = Admin_Model_Machine::getInstance()->getById($id);
        $this->view->assign('id',$id);
        $this->view->assign('machine',$machine);
    }
    public function submitEditAction()
    {
        $url = 'machine';
        $message = '';
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $priority = $this->getRequest()->getParam('priority');
        if(!$id){
            $message = Admin_Model_Machine::getInstance()->insert($name,$priority);
        }else{
            $message = Admin_Model_Machine::getInstance()->update($id,$name,$priority);
        }
        if(!$message){
            $message = 'Thêm thành công';
        }else{
            $message = 'Thêm thất bại';
            $url = 'machine/edit/id='.$id;
        }
        echo $this->callScriptParent('MachineEdit.success', [$message, $url]);
        $this->noRender();
    }

    public function manualUpdateAction()
    {
        $manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
        $manualUpdateAction = $this->getRequest()->getParam('manualUpdateAction');
        $manualUpdateUrl = $this->getRequest()->getParam('manualUpdateUrl');
        $manualUpdateAction = strtolower(trim($manualUpdateAction));
        $idValue = explode(',', $manualUpdateId);
        if ($idValue) {
            $activeData = array(
                'activate' => Application_Constant_Db_Config_Active::ACTIVE,
                'inactivate' => Application_Constant_Db_Config_Active::INACTIVE,
            );
            if (in_array($manualUpdateAction, array_keys($activeData))) {
                $valueActive = $activeData[$manualUpdateAction];
                Admin_Model_Machine::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}