CREATE TABLE banner
(
  banner_id int(11) unsigned not null auto_increment,
  banner_image varchar(200) null,
  banner_title varchar(200) null,
  banner_content int(11) unsigned null,
  banner_active int(11) unsigned null,
  primary key (banner_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Ảnh trang chủ';