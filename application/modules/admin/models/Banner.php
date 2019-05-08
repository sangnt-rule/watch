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

    public function getAll($title,$content, $active)
    {
        $title = trim($title);
        $content = trim($content);
        $active = intval($active);
        return $this->_dao->getAll($title,$content, $active);
    }

    public function insert($title,$content,$image,$priority)
    {
        $title = trim($title);
        $content = trim($content);
        $image = trim($image);
        $priority = intval($priority);
        $result = null;
        try {
            $params = array(
                DbTable_Banner::COL_BANNER_TITLE => $title,
                DbTable_Banner::COL_BANNER_CONTENT => $content,
                DbTable_Banner::COL_BANNER_IMAGE => $image,
                DbTable_Banner::COL_BANNER_PRIORITY => $priority,
                DbTable_Banner::COL_BANNER_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE,
            );
            $this->_dao->insert($params);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function update($id,$title,$content,$image,$priority)
    {
        $title = trim($title);
        $content = trim($content);
        $image = trim($image);
        $priority = intval($priority);
        $result = null;
        try {
            $params = array(
                DbTable_Banner::COL_BANNER_TITLE => $title,
                DbTable_Banner::COL_BANNER_CONTENT => $content,
                DbTable_Banner::COL_BANNER_IMAGE => $image,
                DbTable_Banner::COL_BANNER_PRIORITY => $priority,
                DbTable_Banner::COL_BANNER_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE,
            );
            $where = sprintf(
                '%s IN (%s)',
                DbTable_Banner::COL_BANNER_ID,
                $this->_dao->getAdapter()->quote($id)
            );
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function manualUpdateActive($value, $id)
    {
        $where = sprintf(
            '%s IN (%s)',
            DbTable_Banner::COL_BANNER_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Banner::COL_BANNER_ACTIVE => intval($value));
        return $this->_dao->update($params, $where);
    }

    public function getById($bannerId)
    {
        $bannerId = intval($bannerId);
        $data = $this->_dao->getById($bannerId);
        return $data ? $data->toArray(): '';
    }
}