CREATE TABLE IF NOT EXISTS `homepage_slider_site_visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `homepage_slider_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_homepage_slider_site_visibility` (`homepage_slider_id`, `site_id`),
  KEY `idx_homepage_slider_id` (`homepage_slider_id`),
  KEY `idx_site_id` (`site_id`)
);

INSERT IGNORE INTO `homepage_slider_site_visibility` (`homepage_slider_id`, `site_id`, `is_visible`)
SELECT hs.id, s.id, 1
FROM `homepage_slider` hs
CROSS JOIN `sites` s;
