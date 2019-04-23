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
    private $_menuIntroCategory = array();

    /**
     * @var array
     */
    private $_menuValueCategory = array();
    /**
     * @var array
     */
    private $_menuAboutUsCategory = array();

    /**
     * @var array
     */
    private $_menuFeatureCategory = array();

    /**
     * @var array
     */
    private $_menuNewsCategory = array();

    /**
     * @var array
     */
    private $_menuTourCategory = array();

    /*
     *  var string
     * */
    private $_locale = 'vi';

    public function init()
    {
        parent::init();

//        #menu AboutUs
//        $this->_menuAboutUsCategory = Model_AboutUsCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());
//        #menu AboutUs
//        $this->_menuFeatureCategory = Model_FeatureCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());
//
//        #$this->_menuProjectCategory = Model_ProjectCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());
//        $this->_menuNewsCategory = Model_NewsCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());
//        $this->_menuIntroCategory = Model_IntroCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());
//        $this->_menuValueCategory = Model_ValueCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());
//        $this->_menuFeatureCategory = Model_FeatureCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());
//        $this->_locale = $this->getCurrentLocale();
//        $this->_menuTourCategory = Model_TourCategory::getInstance()->searchByLocaleId($this->getCurrentLocaleId());

    }

    public function postDispatch()
    {
//        parent::postDispatch();
//        $this->autoLoadResource(array(), 'css');
//        $this->autoLoadResource(array(), 'js');
//        $this->view->assign('moduleName', $this->getRequest()->getControllerName());
//        $this->view->assign('actionName', $this->getRequest()->getActionName());
//        $this->view->assign('config', $this->getConfig());
//        $this->view->assign('currentLocale', $this->getCurrentLocale());
//
//        $this->view->assign('menuAboutUsCategory', $this->getMenuAboutUsCategory());
//        $this->view->assign('menuFeatureCategory', $this->getMenuFeatureCategory());
//        $this->view->assign('menuNewsCategory', $this->getMenuNewsCategory());
//        $this->view->assign('menuNewsCategory', $this->getMenuNewsCategory());
//        $this->view->assign('menuIntroCategory', $this->getMenuIntroCategory());
//        $this->view->assign('menuValueCategory', $this->getMenuValueCategory());
//        $this->view->assign('menuTourCategory', $this->getMenuTourCategory());
//
//
//        #Footer
//
//        $this->view->assign(
//            'contactInformation',
//            $this->_helper->filterArray(
//                Model_Content::getInstance()->searchByOriginalId(Application_Constant_Db_Content::CONTACT_US),
//                DbTable_Content::COL_FK_LOCALE,
//                $this->getCurrentLocaleId()
//            )
//        );
//        $this->view->assign(
//            'socialInformation',
//            $this->_helper->filterArray(
//                Model_Content::getInstance()->searchByOriginalId(Application_Constant_Db_Content::SOCIAL_NETWORK),
//                DbTable_Content::COL_FK_LOCALE,
//                $this->getCurrentLocaleId()
//            )
//        );
//        $this->view->assign(
//            'hotline',
//            $this->_helper->filterArray(
//                Model_Content::getInstance()->searchByOriginalId(Application_Constant_Db_Content::HOTLINE),
//                DbTable_Content::COL_FK_LOCALE,
//                $this->getCurrentLocaleId()
//            )
//        );
    }

//    protected function getMenuTourCategory(){
//        return $this->_menuTourCategory;
//
//    }
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