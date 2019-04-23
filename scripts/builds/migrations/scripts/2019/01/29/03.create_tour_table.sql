CREATE TABLE tour
(
  tour_id int(11) unsigned not null auto_increment,
  tour_title varchar(200) not null,
  tour_sub_content text not null,
  tour_content text not null,
  tour_image varchar(100) not null,
  tour_sponsor tinyint(1) not null default 0 comment 'Sponsor',
  tour_original int(11) unsigned default null comment 'Thong tin goc',
  tour_created_at datetime not null,
  tour_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_tour_category int(11) unsigned not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (tour_id),
  constraint `fk_tour_id_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_tour_tour_category` foreign key (fk_tour_category) references tour_category(tour_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Tin Tuc';