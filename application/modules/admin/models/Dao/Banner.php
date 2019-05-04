<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/10/16
 * Time: 10:23 PM
 */
class Admin_Model_Dao_Banner extends DbTable_Banner
{
    public function getAll($title,$content,$active)
    {
        $select = $this->select()
            ->from(
                DbTable_Banner::_tableName,
                array(
                    DbTable_Banner::COL_BANNER_ID,
                    DbTable_Banner::COL_BANNER_IMAGE,
                    DbTable_Banner::COL_BANNER_TITLE,
                    DbTable_Banner::COL_BANNER_CONTENT,
                    DbTable_Banner::COL_BANNER_ACTIVE
                )
            )
        ;
        if($title){
            $select->where(DbTable_Banner::COL_BANNER_TITLE." LIKE '%$title%'");
        }
        if($content){
            $select->where(DbTable_Banner::COL_BANNER_CONTENT." LIKE '%$content%'");
        }
        if($active>-1){
            $select->where(DbTable_Banner::COL_BANNER_ACTIVE.'=?', $active);
        }
        $select->order(DbTable_Banner::COL_BANNER_ID.' DESC');
        return $select;
    }

    public function getById($bannerId)
    {
        $select = $this->select()
            ->from(
                DbTable_Banner::_tableName,
                array(
                    DbTable_Banner::COL_BANNER_ID,
                    DbTable_Banner::COL_BANNER_IMAGE,
                    DbTable_Banner::COL_BANNER_TITLE,
                    DbTable_Banner::COL_BANNER_CONTENT,
                    DbTable_Banner::COL_BANNER_PRIORITY,
                )
            )
            ->where(DbTable_Banner::COL_BANNER_ID.'=?', $bannerId)
        ;

        return $this->fetchRow($select);
    }
}