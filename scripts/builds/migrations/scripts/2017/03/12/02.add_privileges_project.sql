Set @module = 2;

Insert into admin_resource(admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module) Values
('admin_resource_project', 'project', '9000', @module);
Set @resource = 0;
Select LAST_INSERT_ID() into @resource;

Insert Into admin_privilege(admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource) Values
('admin_privilege_listing', 'category-listing', 255, @resource),
('admin_privilege_add_new', 'category-edit', 250, @resource)
;