<?php
class Admin_WatchController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $name = $this->getRequest()->getParam('name');
        $machineId = $this->getRequest()->getParam('machineId');
        $cordId = $this->getRequest()->getParam('cordId');
        $active = $this->getRequest()->getParam('active', -1);
        $this->loadGird(
            Admin_Model_Watch::getInstance()->getAll($name, $machineId, $cordId, $active)
        );
        $cordData = Admin_Model_Cord::getInstance()->getAll();
        $machineData = Admin_Model_Machine::getInstance()->searchAll();
        $this->view->assign('name',$name);
        $this->view->assign('machineId',$machineId);
        $this->view->assign('cordId',$cordId);
        $this->view->assign('active',$active);
        $this->view->assign('cordData',$cordData);
        $this->view->assign('machineData',$machineData);
    }

    public function editAction()
    {
        $watchId = $this->getRequest()->getParam('id');
        $watch = Admin_Model_Watch::getInstance()->getById($watchId);
        $cordData = Admin_Model_Cord::getInstance()->getAll();
        $machineData = Admin_Model_Machine::getInstance()->searchAll();
        $categoryData = Admin_Model_Category::getInstance()->getAll();
        $this->view->assign('id',$watchId);
        $this->view->assign('watch',$watch);
        $this->view->assign('cordData',$cordData);
        $this->view->assign('machineData',$machineData);
        $this->view->assign('categoryData',$categoryData);
    }

    public function submitEditAction()
    {
        $message = '';
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $glasses = $this->getRequest()->getParam('glasses');
        $face = $this->getRequest()->getParam('face');
        $waterproof	 = $this->getRequest()->getParam('waterproof');
        $price = $this->getRequest()->getParam('price');
        $size = $this->getRequest()->getParam('size');
        $description = $this->getRequest()->getParam('description');
        $priority = $this->getRequest()->getParam('priority');
        $machine = $this->getRequest()->getParam('machine');
        $cord = $this->getRequest()->getParam('cord');
        $category = $this->getRequest()->getParam('category');
        $oldImage = $this->getRequest()->getParam('oldImage');
        $image = $oldImage;
        $elementName = 'image';
        $valid_file_extensions = array(".jpg", ".jpeg", ".gif", ".png");
        $file_extension = strrchr($_FILES[$elementName]["name"], ".");
        $maxSizeUpload = Zend_Registry::get('config')->maxSizeImage->default ?? 10485760;
        if(isset($_FILES[$elementName]) && $_FILES[$elementName]['name']){
            if (!in_array($file_extension, $valid_file_extensions)) {
                $message = $this->getTranslateValue('error_image_invalid');
            }else if($_FILES[$elementName]['size'] > $maxSizeUpload){
                $message = $this->getTranslateValue('error_size_banner');
            }else {
                $image = $this->uploadImage('banner', $elementName);
            }
        }
        $url = 'watch/edit/id='.$id;
        if(!$message){
            if(!$id){
                $message = Admin_Model_Watch::getInstance()->insert($name,$glasses,$face,$waterproof,$price,$size,$description,$priority,$image,$cord,$machine,$category);
            }else{
                $message = Admin_Model_Watch::getInstance()->update($id,$name,$glasses,$face,$waterproof,$price,$size,$description,$priority,$image,$cord,$machine,$category);
            }
            if(!$message){
                //$url = 'watch';
                $url = 'watch/edit';
                $message = 'Thêm thành công';
            }else{
                $message = 'Thêm thất bại';
                $url = 'watch/edit/id/'.$id;
            }
        }

        echo $this->callScriptParent('WatchEdit.success', [$message, $url]);
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
                Admin_Model_Watch::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}