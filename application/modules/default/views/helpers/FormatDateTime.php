<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/11/16
 * Time: 11:30 AM
 */
class View_Helper_FormatDateTime extends Zend_View_Helper_Abstract
{
    public function formatDateTime($date)
    {
        $result = '';
        $date = trim($date);

        if ($date && $date != Application_Constant_Global::DEFAULT_MYSQL_DATE) {
            $result = date('d-m-Y H:i:s', strtotime($date));
        }
        return $result;
    }
}