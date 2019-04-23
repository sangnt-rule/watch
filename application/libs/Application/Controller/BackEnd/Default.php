<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/10/16
 * Time: 4:41 PM
 */
class Application_Controller_BackEnd_Default extends Application_Controller_BackEnd
{
    /**
     * Get Partner ID login
     * @return int
     */
    protected function getPartnerId()
    {
        return $this->adminInfo->{DbTable_Admin::COL_FK_PARTNER};
    }
}