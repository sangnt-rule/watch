<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_FeatureSubCategoryUrl extends Zend_View_Helper_Abstract
{
    public function featureSubCategoryUrl($idCategory, $nameCategory, $id, $name)
    {
        return Model_FeatureSubCategory::getInstance()->generateUrl($idCategory, $nameCategory, $id, $name);
    }
}