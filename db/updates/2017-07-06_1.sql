
CREATE TABLE `event_cupom_user` (
  `event_cupom_user_id` int(10) UNSIGNED NOT NULL,
  `event_cupom_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `event_cupom_user`
--
ALTER TABLE `event_cupom_user`
  ADD PRIMARY KEY (`event_cupom_user_id`),
  ADD KEY `event_cupom_id` (`event_cupom_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `event_cupom_user`
--
ALTER TABLE `event_cupom_user`
  MODIFY `event_cupom_user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `event_cupom_user`
--
ALTER TABLE `event_cupom_user`
  ADD CONSTRAINT `event_cupom_user_ibfk_1` FOREIGN KEY (`event_cupom_id`) REFERENCES `event_cupom` (`event_cupom_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_cupom_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

ALTER TABLE `event_guests` DROP FOREIGN KEY `fk_event_guests_events1`; ALTER TABLE `event_guests` ADD CONSTRAINT `fk_event_guests_events1` FOREIGN KEY (`event_id`) REFERENCES `events`(`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

