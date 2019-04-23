<?php
/**
 * Created by PhpStorm.
 * User: mjphong
 * Date: 27/01/2015
 * Time: 11:32
 */
class Controller_Helper_ConvertArrayNoKey extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array)
    {
        $result = array();
        if ($array) {
            foreach ($array as $item) {
                array_push($result, $item);
            }
        }
        return $result;
    }
}