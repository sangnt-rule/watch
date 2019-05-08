<?php

/**
 * Class Model_Product
 */
class Model_Watch extends Application_Singleton
{
    /**
     * @var Model_Dao_Watch
     */
    private $_dao;

    /**
     * Model_Watch constructor.
     */
    protected function __construct()
    {
        $this->_dao = new Model_Dao_Watch();
    }

    public function getByNew()
    {
        $data = $this->_dao->getByNew();
        return $data ? $data->toArray() : null;

    }
    public function getByHot()
    {
        $data = $this->_dao->getByHot();
        return $data ? $data->toArray() : null;
    }
    public function getByUncoming()
    {
        $data = $this->_dao->getByUncoming();
        return $data ? $data->toArray() : null;
    }

    public function getByFkMachineFkCord($idMachine, $idCord)
    {
        $idMachine = intval($idMachine);
        $idCord = intval($idCord);
        $data = $this->_dao->getByFkMachineFkCord($idMachine, $idCord);
        return $data ? $data->toArray() : null;
    }

}