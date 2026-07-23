ALTER TABLE `sites`
  ADD COLUMN `company_number` varchar(100) DEFAULT NULL AFTER `website_name`;

UPDATE `sites`
SET `company_number` = (SELECT `company_number` FROM `site_settings` WHERE `id` = 1 LIMIT 1)
WHERE `company_number` IS NULL OR `company_number` = '';
