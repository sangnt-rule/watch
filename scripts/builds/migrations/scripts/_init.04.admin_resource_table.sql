CREATE TABLE `admin_resource`
(
  admin_resource_id int(11) unsigned not null auto_increment,
  admin_resource_name varchar(100) not null,
  admin_resource_controller varchar(50) not null comment 'Controller name to identify resource',
  admin_resource_priority int(11) default 0,
  admin_resource_active tinyint(1) default 1,
  admin_resource_display tinyint(1) default 1 comment 'Hien thi len Menu',
  fk_admin_module int(11) unsigned not null,
  admin_resource_created_at timestamp default current_timestamp,
  primary key (admin_resource_id),
  constraint `fk_admin_resource_admin_module` foreign key (fk_admin_module) references admin_module(admin_module_id)
) ENGINE=InnoDb AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT 'Resource for Admin ACL';

Insert Into `admin_resource`(admin_resource_id, admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module, admin_resource_display) Values
('1', 'Module/ Main Tab', 'admin-module', 100, 1, 0),
('2', 'Resource', 'admin-resource', 95, 1, 0),
('3', 'Privilege', 'admin-privilege', 90, 1, 0),
('4', 'admin_resource_admin_role', 'admin-role', 85, 1, 1),
('5', 'admin_resource_admin', 'admin', 80, 1, 1)
;