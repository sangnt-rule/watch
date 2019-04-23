<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/25/16
 * Time: 11:25 PM
 */
class IntroController extends Application_Controller_FrontEnd
{
    public function postDispatch()
    {
        parent::postDispatch();
        $this->view->assign(
            'banner',
            Model_Banner::getInstance()->getByOriginalAndLocale(
                Application_Constant_Db_Banner::INTRO,
                $this->getCurrentLocaleId()
            )
        );
    }

    public function indexAction()
    {
        $param = $this->getRequest()->getParam('param');
        $idCategory = 0;
        if ($param) {
            $paramInfo = explode('-', $param);
            $idCategory = intval($paramInfo[0]);
        }
        $menuData = $this->getMenuIntroCategory();
        if (!$idCategory && $menuData) {
            $idCategory = $menuData[0][DbTable_Intro_Category::COL_INTRO_CATEGORY_ID];
        }
        $info = Model_IntroCategory::getInstance()->getInfo($idCategory);

        $content = $info[DbTable_Intro_Category::COL_INTRO_CATEGORY_CONTENT];
        $title = $info[DbTable_Intro_Category::COL_INTRO_CATEGORY_NAME];

        $this->view->assign('activatedId', $idCategory);
        $this->view->assign('info', $info);
        $this->view->assign('title', $title);
        $this->view->assign('content', $content);
        #SEO

        $imageData = Application_Function_Common::collectImageFromFckString($content);
        $image = $imageData ? $imageData[0] : null;
        $this->assignMeta(
            $title,
            $image,
            $this->_helper->retrieveMetaDescription($content)
        );
    }
}