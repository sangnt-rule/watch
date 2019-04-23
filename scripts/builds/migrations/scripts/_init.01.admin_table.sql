CREATE TABLE admin
(
  admin_id int(11) unsigned not null auto_increment,
  admin_email varchar(100) not null,
  admin_password varchar(100) not null,
  admin_fullname varchar(100),
  admin_created_at timestamp default current_timestamp,
  admin_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_config_active tinyint(4) unsigned default 1 comment '1=active/ 0=inactive',
  primary key (admin_id),
  unique key `uni_admin_email` (admin_email),
  constraint `fk_admin_to_config_active` foreign key (fk_config_active) references config_active(config_active_id)
) ENGINE=InnoDb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT 'Danh sach quan tri vien';

Insert Into admin(admin_id, admin_email, admin_password, admin_fullname, fk_config_active) values
(1, 'root@gmail.com', md5('12345678'), 'Quản Trị Viên', '1'),
(2, 'admin@gmail.com', md5('12345678'), 'Quản Trị Viên', '1');