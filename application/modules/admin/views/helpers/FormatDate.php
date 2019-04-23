<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/24/15
 * Time: 2:11 PM
 */
class Admin_View_Helper_FormatDate extends Zend_View_Helper_Abstract
{
    public function formatDate($date)
    {
        $result = '';
        $date = trim($date);

        if ($date && $date != Application_Constant_Global::DEFAULT_MYSQL_DATE) {
            $result = date('d-m-Y', strtotime($date));
        }
        return $result;
    }
}