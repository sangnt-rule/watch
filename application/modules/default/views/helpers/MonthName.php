<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_MonthName extends Zend_View_Helper_Abstract
{
    public function monthName($localeId, $dateValue)
    {
        $result = null;
        $index = date('n', strtotime($dateValue))-1;
        $nameData = array('Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12');
        if ($localeId == Application_Constant_Db_Locale::ENGLISH_CODE) {
            $result = date('F', strtotime($dateValue));
        } else {
            $result = isset($nameData[$index]) ? $nameData[$index] : null;
        }
        return $result;
    }
}