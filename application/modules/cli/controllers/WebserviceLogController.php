<?php
/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 10/6/2015
 * Time: 10:43 AM
 */

class Cli_WebserviceLogController extends Application_Controller_Cli
{
    /**
     * Usage: php cli.php -m cli -c webservice-log -a clean-up
     */
    public function cleanUpAction()
    {
        Cli_Model_WebserviceLog::getInstance()->deleteByDate(
            date('Y-m-d H:i:s', time()-(15*3600*24))
        );
    }
}