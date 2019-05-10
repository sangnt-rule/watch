<?php

/**
 * Class Model_Dao_Cord
 */
class Model_Dao_Cord extends DbTable_Cord
{
    /**
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Cord::_tableName)
            ->where(DbTable_Cord::COL_CORD_ACTIVE.'=?', Application_Constant_Db_ConfigActive::ACTIVE);
        return $this->fetchAll($select);
    }
}