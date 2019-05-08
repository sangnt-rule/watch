<?php

/**
 * Class Model_Dao_Machine
 */
class Model_Dao_Machine extends DbTable_Machine
{
    /**
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Machine::_tableName)
            ->where(DbTable_Machine::COL_MACHINE_ACTIVE.'=?', Application_Constant_Db_ConfigActive::ACTIVE);
        return $this->fetchAll($select);
    }
}