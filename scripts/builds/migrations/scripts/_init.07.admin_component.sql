CREATE TABLE admin_component
(
  admin_component_id tinyint(4) unsigned not null auto_increment,
  admin_component_name varchar(50) not null,
  admin_component_created_at timestamp default current_timestamp,
  primary key (admin_component_id)
) ENGINE=InnoDb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT 'Các thành phàn BackEnd';

Insert Into admin_component(admin_component_id, admin_component_name) values
(1, 'CMS - Công cụ quản lý cấu hình/ dữ liệu hệ thống'),
(2, 'OPS - Công cụ vận hành')
;