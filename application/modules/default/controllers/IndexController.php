<?php
class IndexController extends Application_Controller_FrontEnd
{
//    public function preDispatch()
//    {
//        parent::preDispatch();
//        $this->autoLoadResource();
//    }
    public function indexAction()
    {
        $this->view->assign(
            'new',
            Model_Watch::getInstance()->getByNew()
        );
        $this->view->assign(
            'hot',
            Model_Watch::getInstance()->getByHot()
        );
        $this->view->assign(
            'upcoming',
            Model_Watch::getInstance()->getByUncoming()
        );
        $this->view->assign(
            'banner',
            Model_Banner::getInstance()->getAll()
        );

    }
    public function submitIndexAction()
    {
        $where    = $this->getRequest()->getParam('where');
        $how_long = $this->getRequest()->getParam('how_long');
        $where    = trim($where);
        $how_long =trim($how_long);
        if(empty($where) && empty($how_long)){
            return $this->redirect('/price-quote.html');
        }
        Model_InfomationTourist::getInstance()->insertData($where, $how_long);
        $this->redirect('/price-quote.html');
        $this->noRender();
    }
    public function changeLocaleAction()
    {
        $locale = $this->getRequest()->getParam('locale');
        $this->setCurrentLocale($locale);
        $url = $_SERVER['HTTP_REFERER'];
        $this->gotoUrl($url);
        $this->noRender();
    }

    public function captchaAction()
    {
        $this->renderCaptcha();
        $this->noRender();
    }

    public function pageNotFoundAction()
    {

    }
    public function priceQuoteAction()
    {
    }
    public function submitPriceQuoteAction()
    {
        $service = $this->getRequest()->getParam('s');
        $service = implode(', ',$service);
        $name = $this->getRequest()->getParam('n');
        $phone = $this->getRequest()->getParam('p');
        $email = $this->getRequest()->getParam('m');
        $description = $this->getRequest()->getParam('d');
        $command = sprintf(
            'php '.SYS_PATH.'/public/cli.php -c mail -a send-mail-price-quote -s %s -n %s -p %s -f %s -d %s',
            "'".$service."'",
            "'".$name."'",
            "'".$phone."'",
            $email,
            "'".$description."'"
        );
        exec(Application_Function_Common::buildCommandScriptInBackground($command));
        $message = $this->translate->_('common_send_request_successfully');
        echo $this->callScriptParent('priceQuote.success', array($message));
        $this->noRender();
    }
}