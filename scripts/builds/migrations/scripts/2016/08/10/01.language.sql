CREATE TABLE locale
(
  locale_id tinyint(4) unsigned not null auto_increment,
  locale_name varchar(50) not null,
  locale_code varchar(5) not null,
  primary key (locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Locale';
Insert Into locale(locale_id, locale_name, locale_code) values
(1, 'Việt Nam', 'vi'),
(2, 'English', 'en'),
(3, '中文', 'zh')
;