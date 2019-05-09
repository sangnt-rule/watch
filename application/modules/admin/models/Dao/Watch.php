<?php
class Admin_Model_Dao_Watch extends DbTable_Watch
{
    public function getAll($name, $machineId, $cordId, $active)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Watch::_tableName
            )
            ->join(
                DbTable_Category::_tableName,
                sprintf(
                    '%s.%s=%s.%s',
                    DbTable_Category::_tableName,
                    DbTable_Category::COL_CATEGORY_ID,
                    DbTable_Watch::_tableName,
                    DbTable_Watch::COL_FK_CATEGORY
                ),
                [
                    DbTable_Category::COL_CATEGORY_NAME,
                ]
            )
            ->join(
                DbTable_Machine::_tableName,
                sprintf(
                    '%s.%s=%s.%s',
                    DbTable_Machine::_tableName,
                    DbTable_Machine::COL_MACHINE_ID,
                    DbTable_Watch::_tableName,
                    DbTable_Watch::COL_FK_MACHINE
                ),
                [
                    DbTable_Machine::COL_MACHINE_NAME
                ]
            )
            ->join(
                    DbTable_Cord::_tableName,
                sprintf(
                    '%s.%s=%s.%s',
                    DbTable_Cord::_tableName,
                    DbTable_Cord::COL_CORD_ID,
                    DbTable_Watch::_tableName,
                    DbTable_Watch::COL_FK_CORD
                ),
                [
                    DbTable_Cord::COL_CORD_NAME,
                ]
            )
            ->order(DbTable_Watch::COL_WATCH_PRIORITY . ' DESC');
        ;
        if($name){
            $select->where(DbTable_Watch::NAME." LIKE '%$name%'");
        }
        if($machineId){
            $select->where(DbTable_Machine::COL_MACHINE_ID.'=?', $machineId);
        }
        if($cordId){
            $select->where(DbTable_Cord::COL_CORD_ID.'=?', $cordId);
        }
        if($active > -1){
            $select->where(DbTable_Watch::COL_WATCH_ACTIVE.'=?', $active);
        }

        return $select;
    }

    public function getById($id)
    {
        $select = $this->select()
            ->from(
                DbTable_Watch::_tableName,
                array(
                    DbTable_Watch::COL_WATCH_ID,
                    DbTable_Watch::COL_WATCH_NAME,
                    DbTable_Watch::COL_WATCH_FACE,
                    DbTable_Watch::COL_WATCH_DESCRIPTION,
                    DbTable_Watch::COL_WATCH_GLASSES,
                    DbTable_Watch::COL_WATCH_FACE,
                    DbTable_Watch::COL_WATCH_SIZE,
                    DbTable_Watch::COL_WATCH_PRICE,
                    DbTable_Watch::COL_WATCH_PRIORITY,
                    DbTable_Watch::COL_FK_CORD,
                    DbTable_Watch::COL_FK_MACHINE,
                    DbTable_Watch::COL_FK_CATEGORY,
                    DbTable_Watch::COL_WATCH_IMAGE,
                    DbTable_Watch::COL_WATCH_WATERPROOF,
                )
            )
            ->where(DbTable_Watch::COL_WATCH_ID.'=?', $id)
        ;

        return $this->fetchRow($select);
    }

}