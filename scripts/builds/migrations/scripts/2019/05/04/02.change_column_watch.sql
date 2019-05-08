ALTER TABLE watch CHANGE COLUMN `watch_cord` `fk_cord` int(11) unsigned not null;
ALTER TABLE watch ADD FOREIGN KEY(fk_cord) REFERENCES cord(cord_id);