<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/22/15
 * Time: 2:03 PM
 */
class Application_Controller_FrontEnd extends Application_Controller
{
    /**
     * @var array
     */
    private $_machine = array();

    /**
     * @var array
     */
    private $_cord = array();

    public function init()
    {
        parent::init();

        $this->_machine = Model_Machine::getInstance()->getAll();
        $this->_cord = Model_Cord::getInstance()->getAll();

    }

    public function postDispatch()
    {
        $this->view->assign('machine', $this->_machine);
        $this->view->assign('cord', $this->_cord);
    }
    protected function renderCaptcha($position=-1, $onlyUpperCase=false)
    {
        $config = Zend_Registry::get('config');
        $captchaCode = strtolower($this->_helper->randomString(4));
        $value = $position == -1 ? $captchaCode : $captchaCode[$position] ;
        if ($onlyUpperCase) {
            $value = strtoupper($value);
            $captchaCode = strtoupper($captchaCode);
        }
        $this->saveSessionCaptcha($value);
        Application_Function_Image::renderCaptcha($captchaCode, $config->data->font, $position, 190, 40);
    }

    /**
     * Redirect to 404 page
     */
    protected function goto404()
    {
        $this->gotoUrl('404.html');
    }

    protected function assignMeta($metaTitle, $metaImage, $metaDescription=null)
    {
        if ($metaImage) {
            $this->view->assign('metaImage', $metaImage);
        }
        if ($metaTitle) {
            $this->view->assign('metaTitle', $metaTitle);
        }
        if ($metaTitle) {
            $this->view->assign('metaDescription', $metaDescription);
        }
    }

}