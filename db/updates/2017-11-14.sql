CREATE TABLE `payments_events` (
  `payment_id` int(12) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` float NOT NULL,
  `status` varchar(100) NOT NULL,
  `user_data` text NOT NULL,
  `discountAmount` float NOT NULL,
  `feeAmountPagseguro` int(11) NOT NULL,
  `netAmount` float NOT NULL,
  `extraAmount` float NOT NULL,
  `feeAmountSite` float NOT NULL,
  `feePagSeguro` float NOT NULL,
  `amountReal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `payments_events`
  ADD PRIMARY KEY (`payment_id`);

ALTER TABLE `payments_events`
  MODIFY `payment_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
