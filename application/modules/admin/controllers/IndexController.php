<?php
class Admin_IndexController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $this->_redirect('watch');
        //$this->_helper->redirector->gotoUrl($url);
    }
}