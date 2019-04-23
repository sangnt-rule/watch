Set @module = 2;

Insert into admin_resource(admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module) Values
('admin_resource_recruitment', 'recruitment', '5000', @module);
Set @resource = 0;
Select LAST_INSERT_ID() into @resource;

Insert Into admin_privilege(admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource) Values
('admin_privilege_listing', 'index', 255, @resource),
('admin_privilege_add_new', 'edit', 250, @resource),
('admin_privilege_hr_benefit', 'hr-benefit', 240, @resource)
;