CREATE TABLE IF NOT EXISTS `page_site_visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_page_site_visibility` (`page_id`, `site_id`),
  KEY `idx_page_id` (`page_id`),
  KEY `idx_site_id` (`site_id`)
);

INSERT IGNORE INTO `page_site_visibility` (`page_id`, `site_id`, `is_visible`)
SELECT p.id, s.id, 1
FROM `page` p
CROSS JOIN `sites` s;
