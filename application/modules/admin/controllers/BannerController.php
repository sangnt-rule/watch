<?php
class Admin_BannerController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $locale = $this->getRequest()->getParam('locale', Application_Constant_Db_Locale::VIETNAMESE);
        $activeId = $this->getRequest()->getParam('a', 1);
        $this->loadGird(
            Admin_Model_Banner::getInstance()->searchQuery($locale, $activeId)
        );
        $this->view->assign('locale', $locale);
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
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        $result = array();
        $data = null;
        if ($id) {
            $data = Admin_Model_Banner::getInstance()->getByOriginalId($id);
        }
        foreach ($localeData as $localeId => $record) {
            $record[Application_Constant_Module_Admin::DATA] = array();
            if ($data) {
                $record[Application_Constant_Module_Admin::DATA] = $this->_helper->filterArray(
                    $data,
                    DbTable_Banner::COL_FK_LOCALE,
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

            foreach ($localeIdData as $localeId) {
                $id = $this->getRequest()->getParam('id_' . $localeId);
                $image = $this->getRequest()->getParam('image_' . $localeId);
                $note = $this->getRequest()->getParam('note_' . $localeId);
                $metaKeyword = $this->getRequest()->getParam('metaKeyword_' . $localeId);
                $metaTitle = $this->getRequest()->getParam('metaTitle_' . $localeId);
                $metaDescription = $this->getRequest()->getParam('metaDescription_' . $localeId);

                $validation = true;
                if ($validation) {
                    $imageUpload = $this->uploadImage('banner', 'file_'.$localeId, true);
                    if ($imageUpload) {
                        $image = $imageUpload;
                    }
                    if ($id) {
                        Admin_Model_Banner::getInstance()->update($id, $image, $metaTitle, $metaKeyword, $metaDescription, $note);
                    }
                    if (!$originalId) {
                        $originalId = $id;
                    }
                    array_push($idInsertedData, $id);
                }
            }
            if ($originalId && $idInsertedData) {
                Admin_Model_Banner::getInstance()->updateOriginalId($idInsertedData, $originalId);
            }
            echo $this->callScriptParent('AdminCommon.goTo', array('/banner'));
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
            $actionActive = array(
                Application_Constant_Module_Admin::ACTIVE_VALUE,
                Application_Constant_Module_Admin::INACTIVE_VALUE,
            );

            if (in_array($manualUpdateAction, $actionActive)) {
                $valueActive = $manualUpdateAction == Application_Constant_Module_Admin::ACTIVE_VALUE ? 1 : 0;
                Admin_Model_Banner::getInstance()->manualUpdateActive($idValue, $valueActive);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}