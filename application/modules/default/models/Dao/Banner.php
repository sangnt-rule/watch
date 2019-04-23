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
                    DbTable_Banner::COL_FK_LOCALE,
                    DbTable_Banner::COL_BANNER_ORIGINAL,
                    DbTable_Banner::COL_BANNER_META_TITLE,
                    DbTable_Banner::COL_BANNER_META_KEYWORD,
                    DbTable_Banner::COL_BANNER_META_DESCRIPTION,
                )
            )
        ;
        return $this->fetchAll($select);
    }
}