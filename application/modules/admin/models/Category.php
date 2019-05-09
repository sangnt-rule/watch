<?php

class Admin_Model_Category extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_Category
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Category();
    }

    /**
     * @param $name
     * @param $status
     * @return Zend_Db_Table_Select
     */
    public function getAll($name = '', $status = 1)
    {
        $name = trim($name);
        $status = intval($status);
        $data = $this->_dao->getAll($name, $status);
        return $data->toArray();
    }

}