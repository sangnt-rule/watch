<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_NewsCategoryUrl extends Zend_View_Helper_Abstract
{
    public function newsCategoryUrl($id, $name)
    {
        return Model_NewsCategory::getInstance()->generateUrl($id, $name);
    }
}