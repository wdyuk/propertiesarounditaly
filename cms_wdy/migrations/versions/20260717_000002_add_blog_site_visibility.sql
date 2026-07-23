CREATE TABLE IF NOT EXISTS `blog_site_visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_blog_site_visibility` (`blog_id`, `site_id`),
  KEY `idx_blog_id` (`blog_id`),
  KEY `idx_site_id` (`site_id`)
);

INSERT IGNORE INTO `blog_site_visibility` (`blog_id`, `site_id`, `is_visible`)
SELECT b.id, s.id, 1
FROM `blog` b
CROSS JOIN `sites` s;
