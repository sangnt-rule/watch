<?php
class ContactController extends Application_Controller_FrontEnd
{
    public function indexAction()
    {
        if($this->getRequest()->isPost()){
            $name = $this->getRequest()->getParam('name');
            $phone = $this->getRequest()->getParam('phone');
            $email = $this->getRequest()->getParam('email');
            $message = $this->getRequest()->getParam('message');
            $now = date('d/m/Y');
            $this->view->assign('name',$name);
            $this->view->assign('phone',$phone);
            $this->view->assign('email',$email);
            $this->view->assign('message',$message);

            $this->doSendMail(
                $email,
                $name,
                'Liên hệ về đồng hồ vào lúc'. " ($now)",
                $this->view->render('mail-templates/contact.phtml')
            );

        }

    }
    public function sendEmailAction()
    {
    }
}