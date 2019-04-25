<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/25/16
 * Time: 11:25 PM
 */
class AboutUsController extends Application_Controller_FrontEnd
{

    public function indexAction()
    {
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