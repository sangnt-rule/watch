<?php
/**
 * Created by PhpStorm.
 * User: tranquockiet
 * Date: 29/03/2016
 * Time: 2:41 CH
 */
class Controller_Helper_CalculatePriceCarOrder extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($tripType, $routeModelInfo, $numDay, $numWeekend, $tripRouteAllow)
    {
        if ($numDay < 0) {
            return 0;
        }
        $numDayToGo = $routeModelInfo->{DbTable_Car_Route_Model::COL_CAR_ROUTE_MODEL_TRIP_ROUND} == Application_Constant_Db_Car_Route_Model::ALLOW_TRIP_ROUND_DAY
            ? 0 : 1;
        if ($tripType == Application_Constant_Db_Car_Order::TRIP_ONE_WAY) {
            if ($tripRouteAllow == Application_Constant_Db_Car_Route::ONLY_TRIP_ROUND) {
                return 0;
            }
            $totalPrice = $routeModelInfo->{DbTable_Car_Route_Model::COL_CAR_ROUTE_MODEL_PRICE};
        } elseif ($tripType == Application_Constant_Db_Car_Order::TRIP_ROUND) {
            if ($tripType == Application_Constant_Db_Car_Route::ONLY_ONE_WAY) {
                return 0;
            }
            $numDay = $numDay - $numDayToGo;
            if ($numDay < 0) return 0;
            $totalPrice = $routeModelInfo->{DbTable_Car_Route_Model::COL_CAR_ROUTE_MODEL_ROUND_TRIP_PRICE};
            $totalPrice += round($numDay) * Application_Constant_Db_Car_Order::PRICE_DAY_BONUS;
        } else {
            return 0;
        }

        if ($numWeekend != 0) {
            $totalPrice += Application_Constant_Db_Car_Order::PRICE_WEEKEND_BONUS * $numWeekend;
        }

        return $totalPrice;
    }
}