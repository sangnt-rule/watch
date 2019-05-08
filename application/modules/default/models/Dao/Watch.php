<?php
class Model_Dao_Watch extends DbTable_Watch
{
    /**
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByNew()
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Watch::_tableName)
            ->where(DbTable_Watch::COL_FK_CATEGORY.'=?', Application_Constant_Db_Category::CATEGORY_NEW)
            ->where(DbTable_Watch::COL_WATCH_ACTIVE.'=?', Application_Constant_Db_ConfigActive::ACTIVE);

        return $this->fetchAll($select);
    }

    /**
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByHot()
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Watch::_tableName)
            ->where(DbTable_Watch::COL_FK_CATEGORY.'=?', Application_Constant_Db_Category::CATEGORY_HOT)
            ->where(DbTable_Watch::COL_WATCH_ACTIVE.'=?', Application_Constant_Db_ConfigActive::ACTIVE);

        return $this->fetchAll($select);
    }

    /**
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByUncoming()
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Watch::_tableName)
            ->where(DbTable_Watch::COL_FK_CATEGORY.'=?', Application_Constant_Db_Category::CATEGORY_UNCOMING)
            ->where(DbTable_Watch::COL_WATCH_ACTIVE.'=?', Application_Constant_Db_ConfigActive::ACTIVE);

        return $this->fetchAll($select);
    }

    /**
     * @param int $idMachine
     * @param int $idCord
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByFkMachineFkCord($idMachine, $idCord)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Watch::_tableName)
            ->where(DbTable_Watch::COL_FK_MACHINE.'=?', $idMachine)
            ->where(DbTable_Watch::COL_FK_CORD.'=?', $idCord);
        return $this->fetchAll($select);
    }

}