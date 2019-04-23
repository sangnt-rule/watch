<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_FeatureCategoryNameById extends Zend_View_Helper_Abstract
{
    public function featureCategoryNameById($id)
    {
        return Admin_Model_FeatureCategory::getInstance()->getNameById($id);
    }
}