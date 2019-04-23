<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_ServiceCategoryNameById extends Zend_View_Helper_Abstract
{
    public function serviceCategoryNameById($id)
    {
        return Admin_Model_ServiceCategory::getInstance()->getNameById($id);
    }
}