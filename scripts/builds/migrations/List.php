<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/19/15
 * Time: 4:25 PM
 */
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
            '_init.01.admin_role_table.sql',
            '_init.02.admin_table.sql',
            '_init.07.admin_component.sql',
            '_init.03.admin_module_table.sql',
            '_init.04.admin_resource_table.sql',
            '_init.05.admin_privilege_table.sql',
            '_init.06.admin_acl_table.sql',
            '_admin_permission.sql',
            '2016/08/10/01.language.sql',
            '2016/08/12/03.news_category.sql',
            '2016/08/12/04.news.sql',
            '2016/08/12/05.add_privilege_news.sql',
            '2016/08/13/05.content.sql',
            '2016/08/13/07.add_new_content.sql',
            '2016/08/13/11.about_us_category.sql',
            '2016/08/13/12.about_us_sub_category.sql',
            '2016/08/13/13.about_us.sql',
            '2016/08/13/14.add_privilege_about_us.sql',
            '2016/08/16/01.slider.sql',
            '2016/08/16/02.add_privilege_homepage.sql',
            '2016/09/04/01.banner.sql',
            '2016/09/04/02.add_privilege_banner.sql',
            '2016/09/04/03.add_banner.sql',
            '2016/09/11/01.add_column_meta_to_banner.sql',
            '2016/09/11/02.add_banner_homepage.sql',
            '2017/03/10/03.truncate_content_table.sql',
            '2017/03/10/01.add_content_footer.sql',
            '2017/03/10/02.add_privileges_footer.sql',
            '2017/03/12/01.project_category.sql',
            '2017/03/12/02.add_privileges_project.sql',
            '2017/03/12/02.add_privileges_partner.sql',
            '2017/03/12/01.partner_category.sql',
            '2017/03/12/01.feature_category.sql',
            '2017/03/12/02.add_privileges_feature.sql',
            '2016/08/16/06.recruitment.sql',
            '2017/03/12/03.recruitment.sql',
            '2017/03/12/03.add_content_hr_benefit.sql',
            '2017/03/12/04.install_banner.sql',
            '2017/03/15/01.add_column_to_about_us_category.sql',
            '2017/03/27/01.intro_category.sql',
            '2017/03/27/02.add_privileges_intro.sql',
            '2017/03/27/02.value_category.sql',
            '2017/03/27/04.add_privileges_value.sql',
            '2017/03/27/05.add_banner_intro_and_value.sql',
            '2017/06/16/01.add_new_content.sql',
            '2017/06/16/02.add_privilege_new_content.sql',
            '2018/04/05/01.add_about_us_category_image_link.sql',
            '2018/08/31/01.create_information_tourist_table.sql',
            '2019/01/29/01.create_tour_category_table.sql',
            '2019/01/29/02.insert_admin_privilege_table.sql',
            '2019/01/29/03.create_tour_table.sql',
            '2019/01/29/04.update_admin_privilege_table.sql',
        );
    }
}