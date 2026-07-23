ALTER TABLE `sites`
  ADD COLUMN `reverse_logo_path` varchar(255) DEFAULT NULL AFTER `logo_path`;

UPDATE `sites`
SET
  `website_name` = (SELECT `website_name` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `contact_mail` = (SELECT `contact_mail` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `contact_mail_cnt_form` = (SELECT `contact_mail_cnt_form` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `contact_number` = (SELECT `contact_number` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `contact_number_html` = (SELECT `contact_number_html` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `mobile_contact_number` = (SELECT `mobile_contact_number` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `mobile_contact_number_html` = (SELECT `mobile_contact_number_html` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `address` = (SELECT `address` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `correspondence_address` = (SELECT `correspondence_address` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `map_link` = (SELECT `map_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `facebook_link` = (SELECT `facebook_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `youtube_link` = (SELECT `youtube_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `twitter_link` = (SELECT `twitter_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `snapchat_link` = (SELECT `snapchat_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `instagram_link` = (SELECT `instagram_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `pinterest_link` = (SELECT `pinterest_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `google_link` = (SELECT `google_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1),
  `linkedin_link` = (SELECT `linkedin_link` FROM `site_settings` WHERE `id` = 1 LIMIT 1)
WHERE `id` IN (1, 2);

UPDATE `sites`
SET
  `logo_path` = '/uploads/settings/1-image.png',
  `reverse_logo_path` = '/uploads/sites/1-reverse-logo.png'
WHERE `domain` = 'propertiesarounditaly.com';

UPDATE `sites`
SET
  `logo_path` = '/uploads/settings/1-image.png',
  `reverse_logo_path` = '/uploads/sites/1-reverse-logo.png'
WHERE `domain` = 'propertiesforsaleinabruzzo.com';
