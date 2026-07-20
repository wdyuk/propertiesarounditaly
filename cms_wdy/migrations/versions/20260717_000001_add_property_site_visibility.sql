CREATE TABLE IF NOT EXISTS `property_site_visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_property_site_visibility` (`property_id`, `site_id`),
  KEY `idx_property_id` (`property_id`),
  KEY `idx_site_id` (`site_id`)
);

INSERT IGNORE INTO `property_site_visibility` (`property_id`, `site_id`, `is_visible`)
SELECT p.id, s.id, 1
FROM `properties` p
CROSS JOIN `sites` s;
