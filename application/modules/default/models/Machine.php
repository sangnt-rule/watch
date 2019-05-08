<?php

class Model_Machine extends Application_Singleton
{
    /**
     * @var Model_Dao_Watch
     */
    private $_dao;

    /**
     * Model_Machine constructor.
     */
    protected function __construct()
    {
        $this->_dao = new Model_Dao_Machine();
    }

    /**
     * @return |null
     */
    public function getAll()
    {
        $data = $this->_dao->getAll();
        return $data ? $data->toArray() : null;
    }
}