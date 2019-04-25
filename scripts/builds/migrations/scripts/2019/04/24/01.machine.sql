CREATE TABLE machine
(
  machine_id int(11) unsigned not null auto_increment,
  machine_name varchar(200) null,
  machine_active int(11) unsigned null,
  primary key (machine_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Loai may';