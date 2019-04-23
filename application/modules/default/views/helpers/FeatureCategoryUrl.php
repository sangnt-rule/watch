<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_FeatureCategoryUrl extends Zend_View_Helper_Abstract
{
    public function featureCategoryUrl($id, $name)
    {
        return Model_FeatureCategory::getInstance()->generateUrl($id, $name);
    }
}