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
            '2019/05/04/01.create_table_cord.sql',
            '2019/05/04/02.change_column_watch.sql',
            '2019/05/04/03.insert_data_category.sql',
            '2019/05/04/05.create_table_banner.sql',
            '2019/05/04/06.add_column_watch.sql',
            '2019/05/04/07.create_table_watch_image.sql',
            '2019/05/04/08.add_column_banner.sql',
            '2019/05/04/09.change_column_banner.sql',
            '2019/05/07/01.add_column_table_watch.sql',
            '2019/05/09/01.add_column_table_watch.sql',
            '2019/05/11/01.delete_forign_key_watch.sql',
            '2019/05/11/02.change_column_watch.sql',
        );
    }
}