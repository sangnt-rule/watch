CREATE TABLE `admin_module`
(
  admin_module_id int(11) unsigned not null auto_increment,
  admin_module_name varchar(50) not null,
  admin_module_name_created_at timestamp default current_timestamp,
  admin_module_priority int(11) unsigned default 0 comment 'Thu tu hien thi len menu',
  fk_admin_component tinyint(4) unsigned not null default 1 comment 'Thanh phan cua module',
  primary key (admin_module_id),
  constraint `fk_admin_module_admin_component` foreign key (fk_admin_component) references admin_component(admin_component_id)
) ENGINE=InnoDb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT 'Module / Main tab for Admin Tool';

Insert into admin_module(admin_module_id, admin_module_name, admin_module_priority) values (1, 'admin_module_administrator', 10000);