<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/10/16
 * Time: 10:27 PM
 */
class Admin_Model_Banner extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_Banner
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Banner();
    }

    /**
     * Generate search query
     * @param int $locale
     * @param int $activeId
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($locale, $activeId)
    {
        $locale = intval($locale);
        $activeId = intval($activeId);
        return $this->_dao->searchQuery($locale, $activeId);
    }

    /**
     * Get by ID
     * @param int $id
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getById($id)
    {
        $id = intval($id);
        $data = $this->_dao->find($id);
        return $data ? $data->current() : null;
    }

    /**
     * Get by original ID
     * @param int $originalId
     * @return array
     */
    public function getByOriginalId($originalId)
    {
        $originalId = intval($originalId);
        $data =  $this->_dao->getByOriginalId($originalId);
        return $data ? $data->toArray() : null;
    }

    /**
     * Update data
     * @param int $id
     * @param string $image
     * @param string $metaTitle
     * @param string $metaKeyword
     * @param string $metaDescription
     * @param string $note
     * @return string
     */
    public function update($id, $image, $metaTitle, $metaKeyword, $metaDescription, $note)
    {
        $response = '';
        try {
            $id = intval($id);
            $image = trim($image);
            $metaTitle = trim($metaTitle);
            $metaKeyword = trim($metaKeyword);
            $metaDescription = trim($metaDescription);
            $note = trim($note);

            $data = array(
                DbTable_Banner::COL_BANNER_IMAGE => $image,
                DbTable_Banner::COL_BANNER_META_TITLE => $metaTitle,
                DbTable_Banner::COL_BANNER_META_KEYWORD => $metaKeyword,
                DbTable_Banner::COL_BANNER_META_DESCRIPTION => $metaDescription,
                DbTable_Banner::COL_BANNER_NOTE => $note,
            );
            $where = sprintf('%s=%d', DbTable_Banner::COL_BANNER_ID, $id);
            $this->_dao->update($data, $where);
            Application_Cache_Default::getInstance()->resetBanner();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Update original ID
     * @param int|array $id
     * @param int $originalId
     * @return string
     */
    public function updateOriginalId($id, $originalId)
    {
        $response = '';
        try {
            $id = is_array($id) ? $id : intval($id);
            $originalId = intval($originalId);

            $data = array(
                DbTable_Banner::COL_BANNER_ORIGINAL => $originalId,
            );
            $where = sprintf('%s in (%s)', DbTable_Banner::COL_BANNER_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($data, $where);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Update display homepage
     * @param int|array $id
     * @param int $activeValue
     * @return string
     */
    public function manualUpdateActive($id, $activeValue)
    {
        $response = '';
        try {
            $id = is_array($id) ? $id : intval($id);
            $activeValue = intval($activeValue);

            $data = array(
                DbTable_Banner::COL_FK_CONFIG_ACTIVE => $activeValue,
            );
            $where = sprintf('%s in (%s)', DbTable_Banner::COL_BANNER_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($data, $where);
            Application_Cache_Default::getInstance()->resetBanner();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}