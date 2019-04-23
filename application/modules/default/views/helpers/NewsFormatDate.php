<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/11/16
 * Time: 11:30 AM
 */
class View_Helper_NewsFormatDate extends Zend_View_Helper_Abstract
{
    public function newsFormatDate($date)
    {
        $result = '';
        $date = trim($date);

        if ($date && $date != Application_Constant_Global::DEFAULT_MYSQL_DATE) {
            $result = date('d/m/Y', strtotime($date));
        }
        return $result;
    }
}