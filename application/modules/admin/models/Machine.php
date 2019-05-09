<?php

class Admin_Model_Machine extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_Machine
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Machine();
    }

    /**
     * @param $name
     * @param $status
     * @return Zend_Db_Table_Select
     */
    public function getAll($name, $status)
    {
        $name = trim($name);
        $status = intval($status);
        return $this->_dao->getAll($name, $status);
    }

    public function searchAll()
    {
        $name = '';
        $status = Application_Constant_Db_Config_Active::ACTIVE ;
        $query = $this->getAll($name,$status);
        return $this->_dao->fetchAll($query)->toArray();
    }

    /**
     * @param $name
     * @param $priority
     * @return string|null
     */
    public function insert($name, $priority)
    {
        $name = trim($name);
        $priority = intval($priority);
        $result = null;
        try {
            $params = array(
                DbTable_Machine::COL_MACHINE_NAME => $name,
                DbTable_Machine::COL_MACHINE_PRIORITY => $priority,
                DbTable_Machine::COL_MACHINE_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE,
            );
            $this->_dao->insert($params);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * @param $id
     * @param $name
     * @param $priority
     * @return string|null
     */
    public function update($id, $name, $priority)
    {
        $id = intval($id);
        $name = trim($name);
        $priority = intval($priority);
        $result = null;
        try {
            $params = array(
                DbTable_Machine::COL_MACHINE_NAME => $name,
                DbTable_Machine::COL_MACHINE_PRIORITY => $priority,
                DbTable_Machine::COL_MACHINE_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE,
            );
            $where = sprintf(
                '%s IN (%s)',
                DbTable_Machine::COL_MACHINE_ID,
                $this->_dao->getAdapter()->quote($id)
            );
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function getById($id)
    {
        $id = intval($id);
        $data = $this->_dao->getById($id);
        return $data ? $data->toArray() : '';
    }

    public function manualUpdateActive($value, $id)
    {
        $where = sprintf(
            '%s IN (%s)',
            DbTable_Machine::COL_MACHINE_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Machine::COL_MACHINE_ACTIVE => intval($value));
        return $this->_dao->update($params, $where);
    }
}