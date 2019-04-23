<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/20/15
 * Time: 10:39 PM
 */
class Controller_Helper_RetrieveMetaDescription extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($content)
    {
        $content = strip_tags($content);
        $content = trim($content);
        $content = substr($content, 0, 120);
        return $content;
    }
}