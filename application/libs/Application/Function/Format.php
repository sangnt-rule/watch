<?php
/**
 * Created by PhpStorm.
 * User: kiet
 * Date: 13/03/2018
 * Time: 21:49
 */

class Application_Function_Format
{
    public static function datetime($datetime)
    {
        return date('Y-m-d H:i:s', strtotime($datetime));
    }

    public static function int($value)
    {
        return number_format($value, 0);
    }

    public static function float($value)
    {
        return number_format($value, 2);
    }

    public static function price($price)
    {
        return self::int($price);
    }

    public static function formatShortenNumber($val, $isInteger = true)
    {
        if (abs($val) >= 1000000000) {
            $result = number_format($val/ 1000000000, 2);
            $result .= 'B';
        } else if (abs($val) >= 1000000) {
            $result = number_format($val/ 1000000, 2);
            $result .= 'M';
        } else {
            if (abs($val) >= 1000) {
                $result = number_format($val/ 1000, 2);
                $result .= 'K';
            } else {
                $result = number_format($val, $isInteger ? 0 : 2);
            }
        }

        return $result;
    }

    public static function onlyDate($datetime)
    {
        return date('Y-m-d', strtotime($datetime));
    }

    public static function onlyTime($datetime)
    {
        return date('H:i:s', strtotime($datetime));
    }
}