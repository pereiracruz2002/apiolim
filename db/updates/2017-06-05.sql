ALTER TABLE `user` CHANGE `status` `status` ENUM('enable','disable', 'not_activated') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'enable';
