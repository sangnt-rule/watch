truncate table banner;

alter table banner modify column banner_image varchar(100) default null;

Insert into banner(banner_id, banner_note, banner_created_at, banner_original, fk_locale) values
(1, 'Trang chu', sysdate(), 1, 1),
(2, 'Homepage', sysdate(), 1, 2),
(3, 'Homepage', sysdate(), 1, 3),

(4, 'Giới thiệu', sysdate(), 4, 1),
(5, 'About Us', sysdate(), 4, 2),
(6, 'About Us', sysdate(), 4, 3),

(7, 'Lịch đua', sysdate(), 7, 1),
(8, 'Schedule', sysdate(), 7, 2),
(9, 'Schedule', sysdate(), 7, 3),

(10, 'Tường thuật các vòng đua', sysdate(), 10, 1),
(11, 'Report', sysdate(), 10, 2),
(12, 'Report', sysdate(), 10, 3),

(13, 'Quà lưu niệm', sysdate(), 13, 1),
(14, 'Souvenir', sysdate(), 13, 2),
(15, 'Souvenir', sysdate(), 13, 3),

(16, 'Dịch vụ và tiện ích', sysdate(), 16, 1),
(17, 'Service', sysdate(), 16, 2),
(18, 'Service', sysdate(), 16, 3),

(19, 'Tuyển dụng', sysdate(), 19, 1),
(20, 'Recruitment', sysdate(), 19, 2),
(21, 'Recruitment', sysdate(), 19, 3),

(22, 'Đặt vé online', sysdate(), 22, 1),
(23, 'Ticket Online', sysdate(), 22, 2),
(24, 'Ticket Online', sysdate(), 22, 3),

(25, 'Câu lạc bộ trường đua', sysdate(), 25, 1),
(26, 'Club', sysdate(), 25, 2),
(27, 'Club', sysdate(), 25, 3),

(28, 'Tin tức nổi bật', sysdate(), 28, 1),
(29, 'News', sysdate(), 28, 2),
(30, 'News', sysdate(), 28, 3),

(31, 'Thành viên', sysdate(), 31, 1),
(32, 'Member', sysdate(), 31, 2),
(33, 'Member', sysdate(), 31, 3)
;