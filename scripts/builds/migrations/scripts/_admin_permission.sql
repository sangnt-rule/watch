CREATE TABLE `admin_permission`
(
  admin_permission_id int(11) unsigned not null auto_increment,
  admin_permission_created_at  timestamp default current_timestamp,
  fk_admin int(11) unsigned not null,
  fk_admin_privilege int(11) unsigned not null,
  primary key (admin_permission_id),
  constraint `fk_admin_permission_admin` foreign key (fk_admin) references admin(admin_id),
  constraint `fk_admin_permission_admin_privilege` foreign key (fk_admin_privilege) references admin_privilege(admin_privilege_id)
) ENGINE=InnoDb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT 'Phan quyen cac nhom quan tri';

Insert Into `admin_permission`(fk_admin, fk_admin_privilege) Values
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10)
;