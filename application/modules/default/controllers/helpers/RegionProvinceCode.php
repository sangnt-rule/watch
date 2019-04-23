<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/13/15
 * Time: 11:39 AM
 */
class Controller_Helper_RegionProvinceCode extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($string)
    {
        $info = explode('-', $string);
        $result = array();
        foreach ($info as $word) {
            array_push($result, strtoupper($word[0]));
            if (count($result) >= 3) {
                break;
            }
        }
        if (count($result) < 3) {
            array_push($result, strtoupper($word[strlen($word)-1]));
        }
        return implode('', $result);
    }
}