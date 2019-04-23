CREATE TABLE horse_type
(
  horse_type_id tinyint(4) unsigned not null auto_increment,
  horse_type_name varchar(10) not null,
  horse_type_priority int(11) unsigned not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (horse_type_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Class ngua dua';

Insert into horse_type(horse_type_id, horse_type_name, horse_type_priority) values
(1, 'A', 1000),
(2, 'B', 900),
(3, 'C', 800),
(4, 'D', 700),
(5, 'E', 600)
;