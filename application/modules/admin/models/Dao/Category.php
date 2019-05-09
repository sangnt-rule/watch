<?php

class Admin_Model_Dao_Category extends DbTable_Category
{
    /**
     * @param $name
     * @param $active
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll($name, $active)
    {
        $select = $this->select()
            ->from(
                DbTable_Category::_tableName,
                array(
                    DbTable_Category::COL_CATEGORY_ID,
                    DbTable_Category::COL_CATEGORY_NAME,
                )
            )
        ;
        if($name){
            $select->where(DbTable_Category::COL_CATEGORY_NAME." LIKE '%$name%'");
        }
        if($active>-1){
            $select->where(DbTable_Category::COL_CATEGORY_ACTIVE.'=?', $active);
        }
        $select->order(DbTable_Category::COL_CATEGORY_ID.' DESC');
        return $this->fetchAll($select);
    }

}