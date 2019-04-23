Set @module = 2;

Insert into admin_resource(admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module) Values
('admin_resource_contact', 'contact', '6000', @module);
Set @resource = 0;
Select LAST_INSERT_ID() into @resource;

Insert Into admin_privilege(admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource) Values
('admin_privilege_contact_us', 'contact-us', 200, @resource),
('admin_privilege_recruitment', 'recruitment-listing', 150, @resource),
('admin_privilege_map', 'map', 60, @resource),
('admin_privilege_comment', 'comment-listing', 40, @resource)
;