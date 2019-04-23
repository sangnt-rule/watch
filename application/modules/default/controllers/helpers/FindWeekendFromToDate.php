<?php
/**
 * Created by PhpStorm.
 * User: tranquockiet
 * Date: 01/03/2016
 * Time: 8:59 CH
 */
class Controller_Helper_FindWeekendFromToDate extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($dateFrom, $dateTo)
    {
        $dateFrom = date("Y-m-d", strtotime($dateFrom));
        $dateTo = date("Y-m-d", strtotime($dateTo));
        $begin = new DateTime($dateFrom);
        $end = new DateTime($dateTo);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $countWeekend = 0;
        if ($period) {
            foreach ($period as $dt) {
                $tmp = strtolower(date('l', strtotime($dt->format("Y-m-d"))));
                if ($tmp == Application_Constant_Global_DayOfWeek::Saturday
                    || $tmp == Application_Constant_Global_DayOfWeek::Sunday
                ) {
                    $countWeekend += 1;
                }
            }
        }
        $tmp = strtolower(date('l', strtotime($end->format("Y-m-d"))));
        if ($tmp == Application_Constant_Global_DayOfWeek::Saturday
            || $tmp == Application_Constant_Global_DayOfWeek::Sunday
        ) {
            $countWeekend += 1;
        }
        $result = round($countWeekend/2);
        return $result;
    }
}