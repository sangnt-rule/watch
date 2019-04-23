set @resource =(
select admin_resource_id from admin_resource where admin_resource_controller = 'value'
);

Insert Into admin_privilege(admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource) Values
('admin_privilege_category_listing', 'index', 100, @resource),
('admin_privilege_category_edit', 'edit', 90, @resource);