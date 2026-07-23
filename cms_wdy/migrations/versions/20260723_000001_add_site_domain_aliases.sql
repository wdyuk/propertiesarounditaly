ALTER TABLE `sites`
    ADD COLUMN `domain_aliases` text NULL AFTER `domain`;

UPDATE `sites`
SET `domain_aliases` = 'propertiesarounditaly.co.uk'
WHERE `domain` = 'propertiesarounditaly.com' OR `website_name` = 'Properties Around Italy';

UPDATE `sites`
SET `domain_aliases` = 'propertiesforsaleinabruzzo.co.uk'
WHERE `domain` = 'propertiesforsaleinabruzzo.com' OR `website_name` = 'Properties Around Abruzzo';
