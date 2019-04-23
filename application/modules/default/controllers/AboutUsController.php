<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/25/16
 * Time: 11:25 PM
 */
class AboutUsController extends Application_Controller_FrontEnd
{
    public function postDispatch()
    {
        parent::postDispatch();
        $this->view->assign(
            'banner',
            Model_Banner::getInstance()->getByOriginalAndLocale(
                Application_Constant_Db_Banner::ABOUT_US,
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
        $menuData = $this->getMenuAboutUsCategory();
        if (!$idCategory && !empty($menuData)) {
            $idCategory = $menuData[0][DbTable_About_Us_Category::COL_ABOUT_US_CATEGORY_ID];
        }
        $info = Model_AboutUsCategory::getInstance()->getInfo($idCategory);

        $menuSubData = $this->_helper->filterArrayWithCondition(
            Model_AboutUsSubCategory::getInstance()->getAll(),
            DbTable_About_Us_Sub_Category::COL_FK_ABOUT_US_CATEGORY,
            $idCategory
        );


        if ($menuSubData) {
            $subUrl = Model_AboutUsSubCategory::getInstance()->generateUrl(
                $info[DbTable_About_Us_Category::COL_ABOUT_US_CATEGORY_ID],
                $info[DbTable_About_Us_Category::COL_ABOUT_US_CATEGORY_NAME],
                $menuSubData[0][DbTable_About_Us_Sub_Category::COL_ABOUT_US_SUB_CATEGORY_ID],
                $menuSubData[0][DbTable_About_Us_Sub_Category::COL_ABOUT_US_SUB_CATEGORY_NAME]
            );
            $this->gotoUrl($subUrl);
        } else {
            $content = $info[DbTable_About_Us_Category::COL_ABOUT_US_CATEGORY_CONTENT];
            $title = $info[DbTable_About_Us_Category::COL_ABOUT_US_CATEGORY_NAME];

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

    public function indexSubAction()
    {
        $param = $this->getRequest()->getParam('param');
        $paramCategory = $this->getRequest()->getParam('param-category');
        $idSub = $idCategory = 0;
        if ($param) {
            $paramInfo = explode('-', $param);
            $idSub = intval($paramInfo[0]);
        }
        if ($paramCategory) {
            $paramCategoryInfo = explode('-', $paramCategory);
            $idCategory = intval($paramCategoryInfo[0]);
        }

        $infoSub = Model_AboutUsSubCategory::getInstance()->getInfo($idSub);
        $infoCategory = Model_AboutUsCategory::getInstance()->getInfo($idCategory);

        #SEO
        $title = $infoSub[DbTable_About_Us_Sub_Category::COL_ABOUT_US_SUB_CATEGORY_NAME];
        $content = $infoSub[DbTable_About_Us_Sub_Category::COL_ABOUT_US_SUB_CATEGORY_CONTENT];
        $imageData = Application_Function_Common::collectImageFromFckString($content);
        $image = $imageData ? $imageData[0] : null;
        $this->assignMeta(
            $title,
            $image,
            $this->_helper->retrieveMetaDescription($content)
        );
        $this->view->assign('categoryId', $idCategory);
        $this->view->assign('subCategoryId', $idSub);
        $this->view->assign('title', $title);
        $this->view->assign('content', $content);
        $this->view->assign('infoCategory', $infoCategory);
    }
}