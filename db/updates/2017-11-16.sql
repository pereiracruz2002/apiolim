CREATE TABLE `amigochef`.`event_like` ( `event_like_id` INT NOT NULL AUTO_INCREMENT , `event_id` INT NOT NULL , `user_id` INT NOT NULL , PRIMARY KEY (`event_like_id`), INDEX (`event_id`), INDEX (`user_id`)) ENGINE = InnoDB;

ALTER TABLE `event_like` ADD FOREIGN KEY (`event_id`) REFERENCES `events`(`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `event_like` ADD FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
