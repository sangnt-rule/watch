<?php

class MigrationList
{
    /**
     * Return list of migration need to be deployed
     * @return array
     */
    static public function getList()
    {
        return array(
            '_config_active.sql',
            '_init.01.admin_table.sql',
        );
    }
}