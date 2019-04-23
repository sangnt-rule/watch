<?php
/**
 * Created by PhpStorm.
 * User: mjphong
 * Date: 27/01/2015
 * Time: 11:32
 */
class Controller_Helper_TranslateArrayInKeyAttribute extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $translate)
    {
        $result = array();
        if ($array) {
            foreach ($array as $key => $value) {
                $result[$key] = $translate->_($value);
            }
        }
        return $result;
    }
}