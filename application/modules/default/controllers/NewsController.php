<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/25/16
 * Time: 11:25 PM
 */
class NewsController extends Application_Controller_FrontEnd
{
    public function postDispatch()
    {
        parent::postDispatch();
        $this->view->assign(
            'banner',
            Model_Banner::getInstance()->getByOriginalAndLocale(
                Application_Constant_Db_Banner::NEWS,
                $this->getCurrentLocaleId()
            )
        );
    }

    public function indexAction()
    {
        $param = $this->getRequest()->getParam('param');
        $categoryId = 0;
        if ($param) {
            $paramInfo = explode('-', $param);
            $categoryId = intval($paramInfo[0]);
        }
        if (!$categoryId) {
            $menuData = $this->getMenuNewsCategory();
            $categoryId = $menuData ? $menuData[0][DbTable_News_Category::COL_NEWS_CATEGORY_ID] : null;
        }
        $this->view->assign('currentID', $categoryId);
        $this->view->assign('activatedId', $categoryId);
        $this->view->assign('info', Model_NewsCategory::getInstance()->getById($categoryId));
        $this->loadGird(Model_News::getInstance()->searchQuery($this->getCurrentLocaleId(), $categoryId, null), 9);

        $sponsorData = Model_News::getInstance()->searchSponsorCategory($this->getCurrentLocaleId(), $categoryId);
        $sponsorInfo = array();
        if ($sponsorData) {
            shuffle($sponsorData);
            $sponsorInfo = current($sponsorData);
        }
        $this->view->assign('sponsorInfo', $sponsorInfo);
    }

    public function detailAction()
    {
        $param = $this->getRequest()->getParam('param');
        $id = 0;
        if ($param) {
            $paramInfo = explode('-', $param);
            $id = intval($paramInfo[0]);
        }
        $info = Model_News::getInstance()->getInfo($id);

        if ($info && $info[DbTable_News::COL_FK_CONFIG_ACTIVE] == Application_Constant_Db_Config_Active::ACTIVE) {
            $categoryId = $info[DbTable_News::COL_FK_NEWS_CATEGORY];
            $this->view->assign('infoCategory', Model_NewsCategory::getInstance()->getById($categoryId));
            $this->view->assign('info', $info);

            $this->view->assign(
                'suggestionData',
                Model_News::getInstance()->searchSuggestion(
                    $id,
                    $info[DbTable_News::COL_FK_NEWS_CATEGORY]
                )
            );

            #SEO
            $content = $info[DbTable_News::COL_NEWS_CONTENT];
            $imageData = Application_Function_Common::collectImageFromFckString($content);
            $image = $imageData ? $imageData[0] : null;
            $title = $info[DbTable_News::COL_NEWS_TITLE];
            $this->assignMeta(
                $title,
                $image,
                $this->_helper->retrieveMetaDescription($content)
            );
        } else {
            $this->goto404();
        }
    }

    public function searchAction()
    {
        $keyword = $this->getRequest()->getParam('k');

        $this->loadGird(Model_News::getInstance()->searchQuery($this->getCurrentLocaleId(), null, $keyword), 9);
        $this->view->assign('keyword', $keyword);
    }
}