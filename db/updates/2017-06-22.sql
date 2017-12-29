ALTER TABLE `event_guests` CHANGE `status` `status` ENUM('invited','confirmed','waiting') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'invited';

INSERT INTO `event_info_types` (`event_info_type_id`, `name`, `field_type`, `field_values`, `event_info_category_id`) VALUES ('7', 'Couvert', 'text', NULL, '1'), ('8', 'Primeiro Prato', 'text', NULL, '1'), ('9', 'Acompanhamento', 'text', NULL, '1'), ('10', 'Extra', 'text', NULL, '1');

ALTER TABLE `events` ADD `complement` VARCHAR(50) NULL AFTER `feeAmountSite`, ADD `reference` VARCHAR(50) NULL AFTER `complement`, ADD `phone` VARCHAR(20) NULL AFTER `reference`;

ALTER TABLE `events` CHANGE `status` `status` ENUM('enable','disable','deleted','incomplete') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

