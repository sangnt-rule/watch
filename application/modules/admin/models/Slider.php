<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/10/16
 * Time: 10:27 PM
 */
class Admin_Model_Slider extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_Slider
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Slider();
    }

    /**
     * Generate search query
     * @param int $locale
     * @param string $title
     * @param int $activeId
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($locale, $title, $activeId)
    {
        $locale = intval($locale);
        $title = trim($title);
        $activeId = intval($activeId);
        return $this->_dao->searchQuery($locale, $title, $activeId);
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
     * @param string $url
     * @param string $content
     * @param string $image
     * @param int $priority
     * @param int $locale
     * @return int
     */
    public function insert($title, $url, $content, $image, $priority, $locale)
    {
        $title = trim($title);
        $url = trim($url);
        $content = trim($content);
        $image = trim($image);
        $locale = intval($locale);
        $priority = intval($priority);

        $data = array(
            DbTable_Slider::COL_SLIDER_TITLE => $title,
            DbTable_Slider::COL_SLIDER_URL => $url,
            DbTable_Slider::COL_SLIDER_CONTENT => $content,
            DbTable_Slider::COL_SLIDER_IMAGE => $image,
            DbTable_Slider::COL_FK_LOCALE => $locale,
            DbTable_Slider::COL_SLIDER_PRIORITY => $priority,
            DbTable_Slider::COL_SLIDER_CREATED_AT => $this->_dao->mysqlSysDate(),
        );
        Application_Cache_Default::getInstance()->resetSlider();
        return $this->_dao->insertAndGetLastInsertId($data);
    }

    /**
     * Update data
     * @param int $id
     * @param string $title
     * @param string $url
     * @param string $content
     * @param string $image
     * @param int $priority
     * @return string
     */
    public function update($id, $title, $url, $content, $image, $priority)
    {
        $response = '';
        try {
            $id = intval($id);
            $title = trim($title);
            $url = trim($url);
            $content = trim($content);
            $image = trim($image);
            $priority = trim($priority);

            $data = array(
                DbTable_Slider::COL_SLIDER_TITLE => $title,
                DbTable_Slider::COL_SLIDER_URL => $url,
                DbTable_Slider::COL_SLIDER_CONTENT => $content,
                DbTable_Slider::COL_SLIDER_IMAGE => $image,
                DbTable_Slider::COL_SLIDER_PRIORITY => $priority,
            );
            $where = sprintf('%s=%d', DbTable_Slider::COL_SLIDER_ID, $id);
            $this->_dao->update($data, $where);
            Application_Cache_Default::getInstance()->resetSlider();
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
                DbTable_Slider::COL_SLIDER_ORIGINAL => $originalId,
            );
            $where = sprintf('%s in (%s)', DbTable_Slider::COL_SLIDER_ID, $this->_dao->getAdapter()->quote($id));
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
                DbTable_Slider::COL_FK_CONFIG_ACTIVE => $activeValue,
            );
            $where = sprintf('%s in (%s)', DbTable_Slider::COL_SLIDER_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($data, $where);
            Application_Cache_Default::getInstance()->resetSlider();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}