<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/24/15
 * Time: 2:11 PM
 */
class Admin_View_Helper_FormatDateTime extends Zend_View_Helper_Abstract
{
    public function formatDateTime($date, $format = 'd-m-Y H:i:s')
    {
        $result = '';
        $date = trim($date);

        if ($date && $date != Application_Constant_Global::DEFAULT_MYSQL_DATE) {
            $result = date($format, strtotime($date));
        }
        return $result;
    }
}