Set @module = 2;

Insert into admin_resource(admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module) Values
('admin_resource_footer', 'footer', '1000', @module);
Set @resource = 0;
Select LAST_INSERT_ID() into @resource;

Insert Into admin_privilege(admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource) Values
('admin_privilege_footer_contact_us', 'contact-us', 200, @resource),
('admin_privilege_footer_social_network', 'social-network', 150, @resource),
('admin_privilege_footer_connect_with_us', 'connect-with-us', 100, @resource),
('admin_privilege_footer_blog', 'blog', 90, @resource),
('admin_privilege_footer_term', 'term', 80, @resource);