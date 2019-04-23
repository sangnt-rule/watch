<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_CurrentFullUrl extends Zend_View_Helper_Abstract
{
    public function currentFullUrl($optionsUrl=array())
    {
        return Application_Function_Common::buildUrl($optionsUrl);
    }
}