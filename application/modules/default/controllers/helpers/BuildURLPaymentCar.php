<?php
/**
 * Created by PhpStorm.
 * User: tranquockiet
 * Date: 08/04/2016
 * Time: 10:27 SA
 */
class Controller_Helper_BuildURLPaymentCar extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Build URL for page payment car order
     * @param string $routeFromIdentify
     * @param string $routeToIdentify
     * @param string $carModelIdentify
     * @param string $tripType
     * @param string $dateFrom
     * @param string $dateTo
     * @return string
     */
    public function direct($routeFromIdentify, $routeToIdentify, $carModelIdentify, $tripType, $dateFrom, $dateTo)
    {
        $url = sprintf(
            '/thue-xe/tu-%s-di-%s-xe-%s.html?chuyen=%s&ngay-di=%s&ngay-ve=%s',
            $routeFromIdentify,
            $routeToIdentify,
            $carModelIdentify,
            $tripType,
            date('d-m-Y', strtotime($dateFrom)),
            date('d-m-Y', strtotime($dateTo))
        );
        return $url;
    }
}