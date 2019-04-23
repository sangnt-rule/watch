CREATE TABLE config_active
(
  config_active_id tinyint(4) unsigned not null auto_increment,
  config_active_name varchar(50) not null,
  config_active_note varchar(100) not null,
  config_active_created_at timestamp default current_timestamp,
  primary key (config_active_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Config Activation';
Insert Into config_active(config_active_id, config_active_name, config_active_note) values
(2, 'InActive', 'Đã ngừng hoạt động'),
(1, 'Active', 'Đang hoạt động')
;
update config_active set config_active_id=0 where config_active_id=2;