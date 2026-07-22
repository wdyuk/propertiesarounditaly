ALTER TABLE `page`
  ADD COLUMN `meta_title` varchar(255) DEFAULT NULL AFTER `page_title`;

UPDATE `page`
SET `meta_title` = `page_title`
WHERE `meta_title` IS NULL OR `meta_title` = '';
