<?php

class Admin_Model_Cord extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_Cord
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Cord();
    }

    /**
     * @param $name
     * @param $status
     * @return array
     */
    public function getAll($name = '', $status = 1)
    {
        $name = trim($name);
        $status = intval($status);
        $data = $this->_dao->getAll($name, $status);
        return $data->toArray();
    }


}