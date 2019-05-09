<?php

class Admin_Model_Dao_Cord extends DbTable_Cord
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
                DbTable_Cord::_tableName,
                array(
                    DbTable_Cord::COL_CORD_ID,
                    DbTable_Cord::COL_CORD_NAME,
                )
            )
        ;
        if($name){
            $select->where(DbTable_Cord::COL_CORD_NAME." LIKE '%$name%'");
        }
        if($active>-1){
            $select->where(DbTable_Cord::COL_CORD_ACTIVE.'=?', $active);
        }
        $select->order(DbTable_Cord::COL_CORD_ID.' DESC');
        return $this->fetchAll($select);
    }
}