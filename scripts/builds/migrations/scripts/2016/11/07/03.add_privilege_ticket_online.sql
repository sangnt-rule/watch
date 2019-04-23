Set @module = 2;

Insert into admin_resource(admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module) Values
('admin_resource_ticket_online', 'ticket-online', '7400', @module);
Set @resource = 0;
Select LAST_INSERT_ID() into @resource;

Insert Into admin_privilege(admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource) Values
('admin_privilege_ticket_online_introduction', 'introduction', 200, @resource),
('admin_privilege_ticket_online_rule', 'rule', 150, @resource)
;