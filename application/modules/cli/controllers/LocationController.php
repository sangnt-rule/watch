<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/15
 * Time: 9:59 AM
 */
class Cli_LocationController extends Application_Controller_Cli
{
    public function updateWarehouseLocationAction()
    {
        $locationData = Cli_Model_Location::getInstance()->getAllLocation();
        if ($locationData) {
            foreach ($locationData as $location) {
                if ($location[DbTable_Location::COL_FK_LOCATION_TYPE] != Application_Constant_Db_Location_Type::STARTING_POINT) {
                    $locationId = $location[DbTable_Location::COL_LOCATION_ID];
                    $warehouseData = Cli_Model_Location::getInstance()->getFirstParent($locationId);
                    if ($warehouseData) {
                        Cli_Model_Location::getInstance()->updateWarehouse($locationId, $warehouseData[DbTable_Location::COL_LOCATION_ID]);
                    }
                }
            }
        }
    }
}