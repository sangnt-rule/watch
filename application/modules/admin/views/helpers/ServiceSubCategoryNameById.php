<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_ServiceSubCategoryNameById extends Zend_View_Helper_Abstract
{
    public function serviceSubCategoryNameById($id)
    {
        return Admin_Model_ServiceSubCategory::getInstance()->getNameById($id);
    }
}