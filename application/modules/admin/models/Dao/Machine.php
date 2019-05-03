<?php

class Admin_Model_Dao_Machine extends DbTable_Machine
{
    /**
     * @param $name
     * @param $active
     * @return Zend_Db_Table_Select
     */
    public function getAll($name, $active)
    {
        $select = $this->select()
            ->from(
                DbTable_Machine::_tableName,
                array(
                    DbTable_Machine::COL_MACHINE_ID,
                    DbTable_Machine::COL_MACHINE_NAME,
                    DbTable_Machine::COL_MACHINE_PRIORITY,
                    DbTable_Machine::COL_MACHINE_ACTIVE
                )
            )
        ;
        if($name){
            $select->where(DbTable_Machine::COL_MACHINE_NAME." LIKE '%$name%'");
        }
        if($active>-1){
            $select->where(DbTable_Machine::COL_MACHINE_ACTIVE.'=?', $active);
        }
        $select->order(DbTable_Machine::COL_MACHINE_ID.' DESC');
        return $select;
    }

    public function getById($id)
    {
        $select = $this->select()
            ->from(
                DbTable_Machine::_tableName,
                array(
                    DbTable_Machine::COL_MACHINE_ID,
                    DbTable_Machine::COL_MACHINE_NAME,
                    DbTable_Machine::COL_MACHINE_PRIORITY,
                    DbTable_Machine::COL_MACHINE_ACTIVE
                )
            )
           ->where(DbTable_Machine::COL_MACHINE_ID.'=?', $id)
        ;

        return $this->fetchRow($select);
    }
}