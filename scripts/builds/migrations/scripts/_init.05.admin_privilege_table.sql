CREATE TABLE `admin_privilege`
(
  admin_privilege_id int(11) unsigned not null auto_increment,
  admin_privilege_name varchar(100) not null,
  admin_privilege_action varchar(50) not null comment 'Action name reference from admin_resource - controller',
  admin_privilege_active tinyint(1) default 1,
  admin_privilege_priority tinyint(4) unsigned default 0,
  admin_privilege_display tinyint(1) default 1 comment 'Hien thi tren menu',
  admin_privilege_created_at  timestamp default current_timestamp,
  fk_admin_resource int(11) unsigned not null,
  primary key (admin_privilege_id),
  constraint `fk_admin_acl_admin_resource` foreign key (fk_admin_resource) references admin_resource(admin_resource_id)
) ENGINE=InnoDb AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT 'Resource privileges';

Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('1', 'admin_privilege_listing', 'index', 20, '1');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('2', 'admin_privilege_edit', 'edit', 10, '1');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('3', 'admin_privilege_listing', 'index', 20, '2');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('4', 'admin_privilege_edit', 'edit', 10, '2');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('5', 'admin_privilege_listing', 'index', 20, '3');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('6', 'admin_privilege_edit', 'edit', 10, '3');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('7', 'admin_privilege_listing', 'index', 20, '4');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('8', 'admin_privilege_edit', 'edit', 10, '4');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('9', 'admin_privilege_listing', 'index', 20, '5');
Insert Into `admin_privilege`(admin_privilege_id, admin_privilege_name, admin_privilege_action, admin_privilege_priority, fk_admin_resource)
Values ('10', 'admin_privilege_edit', 'edit', 10, '5');