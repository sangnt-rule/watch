<?php

/**
 * Class Model_Cord
 */
class Model_Cord extends Application_Singleton
{
    /**
     * @var Model_Dao_Cord
     */
    private $_dao;

    /**
     * Model_Cord constructor.
     */
    protected function __construct()
    {
        $this->_dao = new Model_Dao_Cord();
    }

    /**
     * @return array|null
     */
    public function getAll()
    {
        $data = $this->_dao->getAll();
        return $data ? $data->toArray() : null;
    }
}