ALTER TABLE `faqs`
  ADD COLUMN `category` varchar(255) DEFAULT NULL AFTER `question`;
