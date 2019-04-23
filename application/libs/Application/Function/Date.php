<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 6/15/15
 * Time: 4:03 PM
 */
class Application_Function_Date
{
    /**
     * Retrieve days of week with week number
     * @param int $weekNumber
     * @param string $pattern
     * @param int $qty
     * @return array
     */
    static public function dayOfWeek($weekNumber, $pattern = 'Y-m-d', $qty = 7)
    {
        $result = array();
        $year = date('Y');
        for ($day=1; $day<=$qty; $day++) {
            array_push(
                $result,
                date($pattern, strtotime($year."W".$weekNumber.$day))
            );
        }
        return $result;
    }

    /**
     * Format date to d-m-Y
     * @param string $date
     * @return bool|string
     */
    static public function formatDateDMY($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    /**
     * Format date to Y-m-d
     * @param string $date
     * @return bool|string
     */
    static public function formatDateYMD($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}