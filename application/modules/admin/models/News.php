<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/10/16
 * Time: 10:27 PM
 */
class Admin_Model_News extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_News
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_News();
    }

    /**
     * Generate search query
     * @param int $locale
     * @param int $categoryId
     * @param string $title
     * @param int $activeId
     * @param int $sponsor
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($locale, $categoryId, $title, $activeId, $sponsor)
    {
        $sponsor = intval($sponsor);
        $locale = intval($locale);
        $categoryId = intval($categoryId);
        $title = trim($title);
        $activeId = intval($activeId);
        return $this->_dao->searchQuery($locale, $categoryId, $title, $activeId, $sponsor);
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
     * Insert new data
     * @param string $title
     * @param string $subContent
     * @param string $content
     * @param string $image
     * @param int $locale
     * @param int $categoryId
     * @return int
     */
    public function insert($title, $subContent, $content, $image, $locale, $categoryId)
    {
        $title = trim($title);
        $subContent = trim($subContent);
        $content = trim($content);
        $image = trim($image);
        $locale = intval($locale);
        $categoryId = intval($categoryId);
        $data = array(
            DbTable_News::COL_NEWS_TITLE => $title,
            DbTable_News::COL_NEWS_SUB_CONTENT => $subContent,
            DbTable_News::COL_NEWS_CONTENT => $content,
            DbTable_News::COL_NEWS_IMAGE => $image,
            DbTable_News::COL_FK_LOCALE => $locale,
            DbTable_News::COL_FK_NEWS_CATEGORY => $categoryId,
            DbTable_News::COL_NEWS_SPONSOR => 0,
            DbTable_News::COL_NEWS_CREATED_AT => $this->_dao->mysqlSysDate(),
        );
        Application_Cache_Default::getInstance()->resetNewestCategory();
        Application_Cache_Default::getInstance()->resetNewest();
        return $this->_dao->insertAndGetLastInsertId($data);
    }

    /**
     * Update data
     * @param int $id
     * @param string $title
     * @param string $subContent
     * @param string $content
     * @param string $image
     * @return string
     */
    public function update($id, $title, $subContent, $content, $image)
    {
        $response = '';
        try {
            $id = intval($id);
            $title = trim($title);
            $subContent = trim($subContent);
            $content = trim($content);
            $image = trim($image);
            $data = array(
                DbTable_News::COL_NEWS_TITLE => $title,
                DbTable_News::COL_NEWS_SUB_CONTENT => $subContent,
                DbTable_News::COL_NEWS_CONTENT => $content,
                DbTable_News::COL_NEWS_IMAGE => $image,
            );
            $where = sprintf('%s=%d', DbTable_News::COL_NEWS_ID, $id);
            $this->_dao->update($data, $where);
            Application_Cache_Default::getInstance()->resetNewsInfo($id);
            Application_Cache_Default::getInstance()->resetNewsSponsor();
            Application_Cache_Default::getInstance()->resetNewestCategory();
            Application_Cache_Default::getInstance()->resetNewest();
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
                DbTable_News::COL_NEWS_ORIGINAL => $originalId,
            );
            $where = sprintf('%s in (%s)', DbTable_News::COL_NEWS_ID, $this->_dao->getAdapter()->quote($id));
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
                DbTable_News::COL_FK_CONFIG_ACTIVE => $activeValue,
            );
            $where = sprintf('%s in (%s)', DbTable_News::COL_NEWS_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($data, $where);
            if (is_array($id)) {
                foreach ($id as $itemId) {
                    Application_Cache_Default::getInstance()->resetNewsInfo($itemId);
                }
            } else {
                Application_Cache_Default::getInstance()->resetNewsInfo($id);
            }
            Application_Cache_Default::getInstance()->resetNewsSponsor();
            Application_Cache_Default::getInstance()->resetNewestCategory();
            Application_Cache_Default::getInstance()->resetNewest();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Update display homepage
     * @param int|array $id
     * @param int $sponsorValue
     * @return string
     */
    public function manualUpdateSponsor($id, $sponsorValue)
    {
        $response = '';
        try {
            $id = is_array($id) ? $id : intval($id);
            $sponsorValue = intval($sponsorValue);

            $data = array(
                DbTable_News::COL_NEWS_SPONSOR => $sponsorValue,
            );
            $where = sprintf('%s in (%s)', DbTable_News::COL_NEWS_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($data, $where);
            Application_Cache_Default::getInstance()->resetNewsSponsor();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Generate Url
     * @param int $id
     * @param string $title
     * @return string
     */
    public function generateUrl($id, $title)
    {
        return Model_News::getInstance()->generateUrl($id, $title);
    }
}