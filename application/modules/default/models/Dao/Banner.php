<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/4/16
 * Time: 2:13 PM
 */
class Model_Dao_Banner extends DbTable_Banner
{
    /**
     * Get all banner
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        $select = $this->select()
            ->from(
                DbTable_Banner::_tableName,
                array(
                    DbTable_Banner::COL_BANNER_IMAGE,
                    DbTable_Banner::COL_BANNER_TITLE,
                    DbTable_Banner::COL_BANNER_CONTENT
                )
            )
            ->where(DbTable_Banner::COL_BANNER_ACTIVE.'=?', Application_Constant_Db_ConfigActive::ACTIVE)
        ;
        return $this->fetchAll($select);
    }
}