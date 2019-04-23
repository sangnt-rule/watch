Set @module = 3;
Insert into admin_module(admin_module_id, admin_module_name, admin_module_priority, fk_admin_component) Values
(@module, 'admin_module_booking', 8000, 1);

Insert into admin_resource(admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module) Values
('admin_resource_booking', 'booking', '10000', @module);
Set @resource = 0;
Select LAST_INSERT_ID() into @resource;

Insert Into admin_privilege(admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource) Values
('admin_privilege_listing', 'index', 100, @resource);