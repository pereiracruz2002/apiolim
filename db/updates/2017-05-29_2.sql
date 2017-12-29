ALTER TABLE `events` CHANGE `status` `status` ENUM('enable','disable','deleted') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
