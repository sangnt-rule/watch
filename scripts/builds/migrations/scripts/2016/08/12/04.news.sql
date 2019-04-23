CREATE TABLE news
(
  news_id int(11) unsigned not null auto_increment,
  news_title varchar(200) not null,
  news_sub_content text not null,
  news_content text not null,
  news_image varchar(100) not null,
  news_sponsor tinyint(1) not null default 0 comment 'Sponsor',
  news_original int(11) unsigned default null comment 'Thong tin goc',
  news_created_at datetime not null,
  news_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_news_category int(11) unsigned not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (news_id),
  constraint `fk_news_id_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_news_news_category` foreign key (fk_news_category) references news_category(news_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Tin Tuc';