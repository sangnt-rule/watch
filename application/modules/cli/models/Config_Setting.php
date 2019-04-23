<?php

/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 4/28/2016
 * Time: 8:46 AM
 */
class Cli_Model_Config_Setting extends Application_Singleton
{
    protected function __construct()
    {

    }

    /**
     * Get config setting by ID
     * @param int $id
     * @return null
     */
    public function getById($id)
    {
       return Model_ConfigSetting::getInstance()->getById($id);
    }
}