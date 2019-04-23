<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_ValueCategoryUrl extends Zend_View_Helper_Abstract
{
    public function valueCategoryUrl($id, $name)
    {
        return Model_ValueCategory::getInstance()->generateUrl($id, $name);
    }
}