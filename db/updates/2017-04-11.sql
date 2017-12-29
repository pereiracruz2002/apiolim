ALTER TABLE `friends` ADD `status` ENUM('pendding','accepted','rejected') NOT NULL DEFAULT 'pendding' AFTER `friend_id`;
update friends set status = 'accepted';
