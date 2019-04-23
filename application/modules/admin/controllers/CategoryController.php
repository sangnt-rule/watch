<?php
class Admin_CategoryController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {

    }
    public function editAction()
    {

    }
    public function submitEditAction()
    {
        $url = '/category';
        $message = 'thanh cong';
        echo $this->callScriptParent('CategoryEdit.success', [$message, $url]);
        $this->noRender();
    }
}