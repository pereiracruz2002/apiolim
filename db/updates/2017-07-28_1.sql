CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `type_faq` set('site','chef') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT;
