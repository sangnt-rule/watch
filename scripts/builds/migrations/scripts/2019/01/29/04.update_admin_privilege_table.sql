update  admin_privilege as a inner join admin_resource as b
on a.fk_admin_resource = b.admin_resource_id
set admin_privilege_name='admin_privilege_category_listing'
where admin_resource_controller='value' and admin_privilege_action = 'category-listing';

update  admin_privilege as a inner join admin_resource as b
on a.fk_admin_resource = b.admin_resource_id
set admin_privilege_name='admin_privilege_category_edit'
where admin_resource_controller='value' and admin_privilege_action = 'category-edit';

update  admin_privilege as a inner join admin_resource as b
on a.fk_admin_resource = b.admin_resource_id
set admin_privilege_name='admin_privilege_listing'
where admin_resource_controller='value' and admin_privilege_action = 'index';

update  admin_privilege as a inner join admin_resource as b
on a.fk_admin_resource = b.admin_resource_id
set admin_privilege_name='admin_privilege_add_new'
where admin_resource_controller='value' and admin_privilege_action = 'edit';