<?php
class Cli_MailController extends Application_Controller_Cli
{
    public function sendMailPriceQuoteAction()
    {
        $service = $this->getRequest()->getParam('s');
        $name = $this->getRequest()->getParam('n');
        $phone = $this->getRequest()->getParam('p');
        $email = $this->getRequest()->getParam('f');
        $description = $this->getRequest()->getParam('d');
        $this->view->assign('service', $service);
        $this->view->assign('name', $name);
        $this->view->assign('phone', $phone);
        $this->view->assign('email', trim($email));
        $this->view->assign('description', $description);
        $now = date('d/m/Y');
        $emailSend = 'digitaltravelvn@gmail.com';
        $this->doSendMail(
            $emailSend,
            'vedulich',
            'HO TRO VE DU LICH' . " ($now)",
            $this->view->render('mail-templates/price-quote.phtml')
        );
    }
}