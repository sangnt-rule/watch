<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_ValueCategoryNameById extends Zend_View_Helper_Abstract
{
    public function valueCategoryNameById($id)
    {
        return Admin_Model_ValueCategory::getInstance()->getNameById($id);
    }
}