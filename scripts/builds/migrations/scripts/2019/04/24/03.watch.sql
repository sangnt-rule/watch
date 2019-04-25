CREATE TABLE watch
(
  watch_id int(11) unsigned not null auto_increment,
  watch_name varchar(200) null,
  watch_cord varchar(200) null,
  watch_glasses varchar(200) null,
  watch_face varchar(200) null,
  watch_waterproof varchar(200) null,
  watch_price decimal(14,2) null,
  watch_size int(11) null,
  fk_machine int(11) unsigned not null,
  fk_category int(11) unsigned not null,
  primary key (watch_id),
  constraint `fk_watch_machine` foreign key (fk_machine) references machine(machine_id),
  constraint `fk_watch_category` foreign key (fk_category) references category(category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'dong ho';
