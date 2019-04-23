<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/3/16
 * Time: 9:16 PM
 */
class Cli_Model_Location extends Application_Singleton
{
    /**
     * @var Cli_Model_Dao_Location
     */
    private $_dao;

    protected function __construct(){
        $this->_dao = new Cli_Model_Dao_Location();
    }

    /**
     * Update location warehouse
     * @param int $id
     * @param int $warehouseId
     * @return string
     */
    public function updateWarehouse($id, $warehouseId)
    {
        return Admin_Model_Location::getInstance()->updateWarehouse($id, $warehouseId);
    }

    /**
     * Get first parent location
     * @param int $currentLocationId
     * @return array
     */
    public function getFirstParent($currentLocationId)
    {
        return Admin_Model_Location::getInstance()->getFirstParent($currentLocationId);
    }

    /**
     * Get all location
     * @return array
     */
    public function getAllLocation()
    {
        $data = $this->_dao->fetchAll();
        $data = $data ? $data->toArray() : array();
        return $data;
    }
}