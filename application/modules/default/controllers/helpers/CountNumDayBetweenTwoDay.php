<?php
/**
 * Created by PhpStorm.
 * User: tranquockiet
 * Date: 25/03/2016
 * Time: 3:58 CH
 */
class Controller_Helper_CountNumDayBetweenTwoDay extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($dateFrom, $dateTo)
    {
        $today = date('Y-m-d');
        $dateFrom = date("Y-m-d", strtotime($dateFrom));
        $dateTo = date("Y-m-d", strtotime($dateTo));
        if (strtotime($today) > strtotime($dateFrom)
        || strtotime($dateFrom) > strtotime($dateTo)) {
            return -1;
        }
        $begin = new DateTime($dateFrom);
        $end = new DateTime($dateTo);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $count = 0;
        if ($period) {
            foreach ($period as $dt) {
                $count++;
            }
        }
        return $count;
    }
}