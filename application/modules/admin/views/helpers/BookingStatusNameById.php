<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_BookingStatusNameById extends Zend_View_Helper_Abstract
{
    public function bookingStatusNameById($id, $translate)
    {
        $name = Admin_Model_BookingStatus::getInstance()->getNameById($id);
        return $translate->_($name);
    }
}