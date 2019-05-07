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
        $this->view->assign('name',$name);
        $this->view->assign('machineId',$machineId);
        $this->view->assign('cordId',$cordId);
        $this->view->assign('active',$active);
    }

    public function editAction()
    {
        /*$bannerId = $this->getRequest()->getParam('id');
        $banner = Admin_Model_Banner::getInstance()->getById($bannerId);
        $this->view->assign('id',$bannerId);
        $this->view->assign('banner',$banner);*/
    }

    public function submitEditAction()
    {
        /*$message = '';
        $url = 'banner';
        $id = $this->getRequest()->getParam('id');
        $title = $this->getRequest()->getParam('title');
        $content = $this->getRequest()->getParam('content');
        $priority = $this->getRequest()->getParam('priority');
        $oldBanner = $this->getRequest()->getParam('oldBanner');

        $image = $oldBanner;
        $elementName = 'banner';
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
        if(!$message){
            if(!$id){
                $message = Admin_Model_Banner::getInstance()->insert($title,$content,$image,$priority);
            }else{
                $message = Admin_Model_Banner::getInstance()->update($id,$title,$content,$image,$priority);
            }
            if(!$message){
                $message = 'Thêm thành công';
            }else{
                $message = 'Thêm thất bại';
                $url = 'banner/edit/id='.$id;
            }
        }else{
            $url = 'banner/edit/id='.$id;
        }

        echo $this->callScriptParent('BannerEdit.success', [$message, $url]);
        $this->noRender();*/
    }

    public function manualUpdateAction()
    {
        /*$manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
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
                Admin_Model_Banner::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();*/
    }
}