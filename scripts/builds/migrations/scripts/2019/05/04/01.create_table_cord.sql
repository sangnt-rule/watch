CREATE TABLE cord
(
  cord_id int(11) unsigned not null auto_increment,
  cord_name varchar(200) null,
  cord_active int(11) unsigned null,
  primary key (cord_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Loai day';

Insert Into `cord`(cord_id, cord_name,cord_active) Values
(1, 'Dây Da',1),
(2, 'Dây Kim Loại',1),
(3, 'Dây Vải',1)
;