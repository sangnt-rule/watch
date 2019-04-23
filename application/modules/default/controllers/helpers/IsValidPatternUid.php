<?php
/**
 * Created by PhpStorm.
 * User: khoabui
 * Date: 6/22/16
 * Time: 11:36 PM
 */
class Controller_Helper_IsValidPatternUid extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var int
     */
    const UID_CODE = 1;
    const UID_LENGTH = 13;
    const UID_TAIL_LENGTH = 11;

    /**
     * @param string $uid
     *
     * @return bool|int
     */
    public function direct($uid)
    {
        $uid = trim($uid);

        if (strlen($uid) != self::UID_LENGTH) {
            return false;
        }

        $pattern = sprintf(
            '/^%d%d[0-9]{%d}$/',
            self::UID_CODE,
            substr(date('Y'), -1),
            self::UID_TAIL_LENGTH
        );

        return (boolean) preg_match($pattern, $uid);
    }
}