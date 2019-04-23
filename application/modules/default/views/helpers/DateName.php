<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_DateName extends Zend_View_Helper_Abstract
{
    public function dateName($localeId, $dateValue)
    {
        $nameData = array('Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật');
        if ($localeId == Application_Constant_Db_Locale::ENGLISH_CODE) {
            $nameData = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        }
        $index = date('N', strtotime($dateValue)) - 1;
        return isset($nameData[$index]) ? $nameData[$index] : null;
    }
}