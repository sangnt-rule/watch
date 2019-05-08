CREATE TABLE watch_image
(
  watch_image_id int(11) unsigned not null auto_increment,
  watch_image_image varchar(200) null,
  fk_watch int(11) unsigned not null,
  watch_image_active varchar(200) null,
  primary key (watch_image_id),
  constraint `fk_watch_image_watch` foreign key (fk_watch) references watch(watch_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'anh dong ho';
