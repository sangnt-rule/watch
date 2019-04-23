<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/22/15
 * Time: 12:32 AM
 */
class Controller_Helper_CalculateArrayByKeyWithCondition extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $keyName, $keyCondition, $condition)
    {
        $result = 0;
        if ($array) {
            foreach ($array as $item) {
                if (isset($item[$keyName]) && isset($item[$keyCondition]) ) {
                    $check = true;
                    if (is_array($condition)) {
                        $check = in_array($item[$keyCondition], $condition);
                    } else {
                        $check = $item[$keyCondition]==$condition;
                    }
                    if ($check) {
                        $value = $item[$keyName];
                        if ($value) {
                            $result += $value;
                        }
                    }
                }
            }
        }
        return $result;
    }
}