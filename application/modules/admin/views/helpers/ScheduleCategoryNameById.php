<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_ScheduleCategoryNameById extends Zend_View_Helper_Abstract
{
    public function scheduleCategoryNameById($id)
    {
        return Admin_Model_ScheduleCategory::getInstance()->getNameById($id);
    }
}