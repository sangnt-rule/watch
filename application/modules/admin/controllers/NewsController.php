<?php
class Admin_NewsController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $locale = $this->getRequest()->getParam('locale', Application_Constant_Db_Locale::VIETNAMESE);
        $categoryId = $this->getRequest()->getParam('c');
        $title = $this->getRequest()->getParam('t');
        $activeId = $this->getRequest()->getParam('a', Application_Constant_Db_Config_Active::ACTIVE);
        $sponsor = $this->getRequest()->getParam('ih', -1);
        $this->loadGird(
            Admin_Model_News::getInstance()->searchQuery($locale, $categoryId, $title, $activeId, $sponsor)
        );
        $this->view->assign('sponsor', $sponsor);
        $this->view->assign('locale', $locale);
        $this->view->assign('categoryId', $categoryId);
        $this->view->assign('title', $title);
        $this->view->assign('activeId', $activeId);
        $this->view->assign(
            'localeData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_Locale::getInstance()->getAll(),
                DbTable_Locale::COL_LOCALE_ID,
                DbTable_Locale::COL_LOCALE_NAME
            )
        );
        $this->view->assign(
            'activeData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_ConfigActive::getInstance()->getAll(),
                DbTable_Config_Active::COL_CONFIG_ACTIVE_ID,
                DbTable_Config_Active::COL_CONFIG_ACTIVE_NAME
            )
        );
        $this->view->assign('newsCategoryData', Admin_Model_NewsCategory::getInstance()->searchAll());
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        $result = array();
        $data = null;
        if ($id) {
            $data = Admin_Model_News::getInstance()->getByOriginalId($id);
            $categoryInfo = Admin_Model_NewsCategory::getInstance()->getById($data[0][DbTable_News::COL_FK_NEWS_CATEGORY]);
            $this->view->assign('categoryId', $categoryInfo[DbTable_News_Category::COL_NEWS_CATEGORY_ORIGINAL]);
        } else {
            $this->view->assign(
                'categoryData',
                $this->_helper->buildArrayInKeyAttribute(
                    Admin_Model_NewsCategory::getInstance()->searchByLocaleCode($this->getCurrentLocale()),
                    DbTable_News_Category::COL_NEWS_CATEGORY_ORIGINAL,
                    DbTable_News_Category::COL_NEWS_CATEGORY_NAME
                )
            );
        }
        foreach ($localeData as $localeId => $record) {
            $record[Application_Constant_Module_Admin::DATA] = array();
            if ($data) {
                $record[Application_Constant_Module_Admin::DATA] = $this->_helper->filterArray(
                    $data,
                    DbTable_News::COL_FK_LOCALE,
                    $localeId
                );
            }
            array_push($result, $record);
        }
        $this->view->assign('data', $data);
        $this->view->assign('result', $result);
        $this->view->assign(
            'localeData',
            $this->_helper->buildArrayInKeyAttribute(
                $localeData,
                DbTable_Locale::COL_LOCALE_ID,
                DbTable_Locale::COL_LOCALE_NAME
            )
        );
    }

    public function submitEditAction()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeIdData = array_keys($localeData);
            $originalId = null;
            $idInsertedData = array();

            $categoryId = $this->getRequest()->getParam('categoryId');
            $categoryData = Admin_Model_NewsCategory::getInstance()->getByOriginalId($categoryId);

            foreach ($localeIdData as $localeId) {
                $id = $this->getRequest()->getParam('id_' . $localeId);
                $title = $this->getRequest()->getParam('title_' . $localeId);
                $subContent = $this->getRequest()->getParam('subContent_' . $localeId);
                $content = $this->getRequest()->getParam('content_' . $localeId);
                $image = $this->getRequest()->getParam('image_' . $localeId);

                $validation = true;
                if ($validation) {
                    $imageUpload = $this->uploadImage('news', 'file_'.$localeId, true);
                    if ($imageUpload) {
                        $image = $imageUpload;
                    }
                    if ($id) {
                        Admin_Model_News::getInstance()->update($id, $title, $subContent, $content, $image);
                    } else {
                        $categoryInfo = $this->_helper->filterArray(
                            $categoryData,
                            DbTable_News_Category::COL_FK_LOCALE,
                            $localeId
                        );
                        $id = Admin_Model_News::getInstance()->insert(
                            $title,
                            $subContent,
                            $content,
                            $image,
                            $localeId,
                            $categoryInfo[DbTable_News_Category::COL_NEWS_CATEGORY_ID]
                        );

                    }
                    if (!$originalId) {
                        $originalId = $id;
                    }
                    array_push($idInsertedData, $id);
                }
            }
            if ($originalId && $idInsertedData) {
                Admin_Model_News::getInstance()->updateOriginalId($idInsertedData, $originalId);
            }
            echo $this->callScriptParent('AdminCommon.goTo', array('/news'));
        }
        $this->noRender();
    }

    public function categoryListingAction()
    {
        $locale = $this->getRequest()->getParam('locale', Application_Constant_Db_Locale::VIETNAMESE);
        $active = $this->getRequest()->getParam('a', Application_Constant_Db_Config_Active::ACTIVE);
        $this->loadGird(
            Admin_Model_NewsCategory::getInstance()->searchQuery($locale, $active)
        );
        $this->view->assign('locale', $locale);
        $this->view->assign('activeId', $active);
        $this->view->assign(
            'localeData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_Locale::getInstance()->getAll(),
                DbTable_Locale::COL_LOCALE_ID,
                DbTable_Locale::COL_LOCALE_NAME
            )
        );
        $this->view->assign(
            'activeData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_ConfigActive::getInstance()->getAll(),
                DbTable_Config_Active::COL_CONFIG_ACTIVE_ID,
                DbTable_Config_Active::COL_CONFIG_ACTIVE_NAME
            )
        );
    }

    public function categoryEditAction()
    {
        $id = $this->getRequest()->getParam('i');
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        $result = array();
        $data = null;
        if ($id) {
            $data = Admin_Model_NewsCategory::getInstance()->getByOriginalId($id);
        }
        foreach ($localeData as $localeId => $record) {
            $record[Application_Constant_Module_Admin::DATA] = array();
            if ($data) {
                $record[Application_Constant_Module_Admin::DATA] = $this->_helper->filterArray(
                    $data,
                    DbTable_News_Category::COL_FK_LOCALE,
                    $localeId
                );
            }
            array_push($result, $record);
        }
        $this->view->assign('data', $data);
        $this->view->assign('result', $result);
        $this->view->assign(
            'localeData',
            $this->_helper->buildArrayInKeyAttribute(
                $localeData,
                DbTable_Locale::COL_LOCALE_ID,
                DbTable_Locale::COL_LOCALE_NAME
            )
        );
    }

    public function categorySubmitEditAction()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeIdData = array_keys($localeData);
            $originalId = null;
            $idInsertedData = array();
            foreach ($localeIdData as $localeId) {
                $id = $this->getRequest()->getParam('id_' . $localeId);
                $title = $this->getRequest()->getParam('title_' . $localeId);
                $priority = $this->getRequest()->getParam('priority_' . $localeId);

                $validation = true;
                if ($validation) {
                    if ($id) {
                        Admin_Model_NewsCategory::getInstance()->update($id, $title, $priority);
                    } else {
                        $id = Admin_Model_NewsCategory::getInstance()->insert($title, $priority, $localeId);

                    }
                    if (!$originalId) {
                        $originalId = $id;
                    }
                    array_push($idInsertedData, $id);
                }
            }
            if ($originalId && $idInsertedData) {
                Admin_Model_NewsCategory::getInstance()->updateOriginalId($idInsertedData, $originalId);
            }
            echo $this->callScriptParent('AdminCommon.goTo', array('/news/category-listing'));
        }
        $this->noRender();
    }

    public function manualUpdateAction()
    {
        $manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
        $manualUpdateAction = $this->getRequest()->getParam('manualUpdateAction');
        $manualUpdateUrl = $this->getRequest()->getParam('manualUpdateUrl');

        $manualUpdateAction = strtolower(trim($manualUpdateAction));

        $idValue = explode(',', $manualUpdateId);
        if ($idValue) {
            $actionDisplayHomepage = array(
                Application_Constant_Module_Admin::MANUAL_ACTION_DISPLAY_HOMEPAGE,
                Application_Constant_Module_Admin::MANUAL_ACTION_UN_DISPLAY_HOMEPAGE,
            );

            $actionActive = array(
                Application_Constant_Module_Admin::ACTIVE_VALUE,
                Application_Constant_Module_Admin::INACTIVE_VALUE,
            );

            $actionNewsSponsor = array(
                Application_Constant_Module_Admin::NEWS_SPONSOR,
                Application_Constant_Module_Admin::NEWS_NO_SPONSOR,
            );

            $actionCategoryActive = array(
                Application_Constant_Module_Admin::MANUAL_ACTION_CATEGORY_ACTIVE,
                Application_Constant_Module_Admin::MANUAL_ACTION_CATEGORY_INACTIVE,
            );

            if (in_array($manualUpdateAction, $actionDisplayHomepage)) {
                $valueActive = $manualUpdateAction == Application_Constant_Module_Admin::MANUAL_ACTION_DISPLAY_HOMEPAGE ? 1 : 0;
                Admin_Model_NewsCategory::getInstance()->manualUpdateDisplayHomepage($idValue, $valueActive);
            } elseif (in_array($manualUpdateAction, $actionActive)) {
                $valueActive = $manualUpdateAction == Application_Constant_Module_Admin::ACTIVE_VALUE ? 1 : 0;
                Admin_Model_News::getInstance()->manualUpdateActive($idValue, $valueActive);
            } elseif (in_array($manualUpdateAction, $actionNewsSponsor)) {
                $valueActive = $manualUpdateAction == Application_Constant_Module_Admin::NEWS_SPONSOR ? 1 : 0;
                Admin_Model_News::getInstance()->manualUpdateSponsor($idValue, $valueActive);
            } elseif (in_array($manualUpdateAction, $actionCategoryActive)) {
                $valueActive = $manualUpdateAction == Application_Constant_Module_Admin::MANUAL_ACTION_CATEGORY_ACTIVE ? 1 : 0;
                Admin_Model_NewsCategory::getInstance()->manualUpdateActive($idValue, $valueActive);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}