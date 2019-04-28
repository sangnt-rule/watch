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
            '2019/04/24/01.machine.sql',
            '2019/04/24/02.category.sql',
            '2019/04/24/03.watch.sql',
            '2019/04/28/01.add_column_machine.sql',
        );
    }
}