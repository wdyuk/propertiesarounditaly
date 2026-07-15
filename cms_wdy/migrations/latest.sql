-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 19, 2020 at 10:23 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `whitemill`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `last_login`) VALUES
(1, 'Test', 'cms@wdymail.co.uk', '10c4981bb793e1698a83aea43030a388', '2020-03-19 14:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `link` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `page_id`, `title`, `content`, `link`, `status`) VALUES
(1, 20, 'Sell Your Vehicle', '<p>For a fair valuation, complete the form and click Send. We usually can provide an estimated valuation within 24 hours.</p>', '28', 1),
(2, 20, 'About', '<p>The team at White Hill Commercials are experts in exports. Offering advice and guidance with your export requirements, from purchase to after sales. Committed to offering the best service throughout the sales process.</p>\r\n', '24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_title` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `teaser` mediumtext NOT NULL,
  `content` mediumtext,
  `meta_keywords` mediumtext,
  `meta_description` mediumtext,
  `publish_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `page_title`, `title`, `teaser`, `content`, `meta_keywords`, `meta_description`, `publish_date`, `status`) VALUES
(43, NULL, 'New Blog Post', '<p>Test</p>\r\n', '<p>Testing the blog</p>\r\n', NULL, '', '2019-10-22 12:24:00', 1),
(44, NULL, 'Test', '<p>Test</p>\r\n', '<p>Testing the blog</p>\r\n', NULL, '', '1970-01-01 01:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `will_cat_name` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `will_cat_name`, `status`) VALUES
(1, 'Tractor Units', 'Tractor Units', 1),
(2, 'Rigid Trucks', 'Rigid Trucks', 1),
(3, 'Trailers', 'Trailers', 1),
(4, 'Vans', 'Bodies', 1),
(5, 'Plant Equipment', '', 1),
(6, 'Tipper Trucks', 'Tippers', 1),
(7, '', 'Skip Loaders', 0),
(8, '', 'Mixers', 0),
(9, '', 'Grab/crane', 0),
(10, '', 'Tanks', 0),
(11, '', 'Specialist', 0),
(12, '', 'Hook Loader', 0),
(13, '', 'Municipal', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
  `id` int(11) NOT NULL,
  `form_type` varchar(256) NOT NULL,
  `c_name` varchar(256) NOT NULL,
  `c_email` varchar(256) NOT NULL,
  `c_tel` varchar(20) NOT NULL,
  `company_name` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `make` varchar(256) NOT NULL,
  `model` varchar(256) NOT NULL,
  `chassis_number` varchar(256) NOT NULL,
  `part_number` varchar(256) NOT NULL,
  `part_description` text NOT NULL,
  `reg_number` varchar(25) NOT NULL,
  `sent_to` text NOT NULL,
  `date_of_enquiry` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `export_process`
--

CREATE TABLE `export_process` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `about` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `export_process`
--

INSERT INTO `export_process` (`id`, `title`, `about`, `status`, `position`) VALUES
(1, 'Choose your Truck:', '<p>Website or Facebook pages. Selection of vehicles available. Choice is yours.</p>\r\n', 1, 0),
(2, 'Contact Us:', '<p>Contact us via What&rsquo;s app message, email, telephone or facebook.</p>\r\n', 1, 1),
(3, 'Information:', '<p>We&rsquo;ll give you all the information you require, photo&rsquo;s and videos.</p>\r\n', 1, 2),
(4, 'Quote:', '<p>Once selected we&rsquo;ll start the digital accounts process. An electronic quote will be sent direct to your email address this is valid for 3 working days.</p>\r\n', 1, 3),
(5, 'Confirm:', '<p>If you are happy with the quote you must confirm electronically or verbally. If not confirmed the truck will be put back for resale</p>\r\n', 1, 4),
(6, 'Invoice:', '<p>Once confirmed an invoice will be produced through the digital system. Full payment must be received in 14 days from invoice date or truck will be put back for resale.</p>\r\n', 1, 5),
(7, 'Payment:', '<p>Bank transfers only. Once payment is received in full, truck will be booked on first available vessel from nearest UK port, to your chosen destination.</p>\r\n', 1, 6),
(8, 'Clearing Agent:', '<p>You need to appoint a clearing agent.</p>\r\n', 1, 7),
(9, 'Documents:', '<p>Documentation required for clearing your truck will be sent approximately 5-7 days after the vessel has sailed. Documents are sent DHL airfreight, Copy of bill of laden will be sent via email. Telex release will be sent from shipping Agent to your clearing agent Electronically.</p>\r\n', 1, 8),
(10, 'Release:', '<p>Arrange your customs clearance and your truck is ready for release.</p>\r\n', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(250) NOT NULL,
  `answer` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `position` int(11) NOT NULL DEFAULT '99'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `status`, `position`) VALUES
(8, 'What is the answer to the life, the universe and everything?', '42', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_images`
--

CREATE TABLE `module_images` (
  `id` int(11) NOT NULL,
  `table_name` varchar(200) NOT NULL,
  `table_id` int(11) NOT NULL,
  `type` enum('FULL','LARGE','THUMB','SQUARE') NOT NULL,
  `groupings` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `module_images`
--

INSERT INTO `module_images` (`id`, `table_name`, `table_id`, `type`, `groupings`) VALUES
(1, 'vehicles', 1, 'THUMB', '20200319212832439'),
(2, 'vehicles', 1, 'FULL', '20200319212832439'),
(3, 'vehicles', 1, 'THUMB', '20200319212847529'),
(4, 'vehicles', 1, 'FULL', '20200319212847529');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '-1',
  `menu_title` varchar(250) DEFAULT NULL,
  `page_title` varchar(250) DEFAULT NULL,
  `h1_title` varchar(250) DEFAULT NULL,
  `content` mediumtext,
  `content_2` text NOT NULL,
  `content_3` text NOT NULL,
  `content_4` text NOT NULL,
  `content_5` text NOT NULL,
  `content_6` text NOT NULL,
  `meta_description` mediumtext,
  `status` tinyint(4) DEFAULT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT '99',
  `top_nav` tinyint(4) DEFAULT NULL,
  `footer_nav` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `parent_id`, `menu_title`, `page_title`, `h1_title`, `content`, `content_2`, `content_3`, `content_4`, `content_5`, `content_6`, `meta_description`, `status`, `position`, `top_nav`, `footer_nav`) VALUES
(16, -1, '404', 'Page Not Found', 'Page Not Found', '<p>We&#39;re sorry but the page you were looking for was not found.</p>\r\n\r\n<p>Please use the links above to find what you were looking for.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '', '', '', '', '', '', 1, 1, NULL, NULL),
(20, -1, 'Home', 'Home', 'Home', '', '', '', '', '', '', '', 1, 0, NULL, NULL),
(24, -1, 'About', 'About', 'About', '', '', '', '', '', '', '', 1, 2, 1, NULL),
(25, -1, 'View Stock', 'View Stock', 'View Stock', '', '', '', '', '', '', '', 1, 5, 1, NULL),
(26, -1, 'Parts', 'Parts', 'Parts', '<h2>White Hill Commercials are able to supply parts for many truck models. We can also supply parts for cars and plant machinery.</h2>\r\n\r\n<p>We have trucks onsite that we are able to use for the supply of used parts, and are able to source new parts for most vehicles. Whether you require after market or genuine.</p>\r\n\r\n<ul>\r\n	<li>Engine and Gearbox parts</li>\r\n	<li>Fuel system parts</li>\r\n	<li>Brakes and Axles</li>\r\n	<li>Steering system parts</li>\r\n</ul>\r\n\r\n<p>Diagnostic computer packages are available to purchase from us, supplied with laptop, battery, charger and cable adaptors for many models.</p>\r\n', '<p>White Hill Commercials can supply you with accessories for your trucks, vans and pickups.</p>\r\n\r\n<ul>\r\n	<li>LED Light bars and spot lamps</li>\r\n	<li>Roof bars, middle grill bars and bottom bars</li>\r\n	<li>Side bars</li>\r\n	<li>Chrome mirror backs</li>\r\n	<li>Alloy wheels</li>\r\n	<li>Sun visors</li>\r\n	<li>Running boards and roof rails</li>\r\n</ul>\r\n\r\n<p>All parts will be sent out DHL airfreight, usually a 3 day service worldwide. Heavy items can be sent by sea shipments.</p>\r\n', '', '', '', '', '', 1, 6, 1, NULL),
(27, -1, 'Export Process FAQ', 'Export Process FAQ', 'Export Process FAQ', '<h2>White Hill Commercials now use a digital accounts system used by Vat registered companies in the UK. All quotes and statements are electronically sent by email.</h2>\r\n', '', '', '', '', '', '', 1, 7, 1, NULL),
(28, -1, 'Sell Your Vehicle', 'Sell Your Vehicle', 'Sell Your Vehicle', '<p>Sell your tractor unit, rigid truck, trailer, van or tipper truck</p>\r\n', '<p>For a fair valuation, complete the form below and click the Send button. We usually can provide an estimated valuation within 24 hours.</p>\r\n', '', '', '', '', '', 1, 8, 1, NULL),
(29, -1, 'Services', 'Services', 'Services', '<h2>White Hill Commercials offer many services, all done in our onsite workshop facilities. Ranging from simple mechanical solutions to more complex bodywork.</h2>\r\n\r\n<p>We are able to offer the following services.</p>\r\n\r\n<ul>\r\n	<li>Supply and fit cranes of all sizes</li>\r\n	<li>Remove Ad Blue from vehicles, including all Euro 6 models (This is only available on trucks being exported)</li>\r\n	<li>Shotblast and paint</li>\r\n	<li>Fit tipping hydraulics, supply and fit PTO pumps</li>\r\n</ul>\r\n', '<p>Our fabricators are able to build truck bodies to customers individual specifications on vehicles bought from White Hill Commercials or on their own vehicles.</p>\r\n\r\n<ul>\r\n	<li>Flatbed bodies</li>\r\n	<li>Dropside bodies</li>\r\n	<li>Tipper bodies</li>\r\n	<li>Recovery truck bodies</li>\r\n	<li>Narrower truck bodies for specific islands</li>\r\n</ul>\r\n\r\n<p>More complex bodywork such as</p>\r\n\r\n<ul>\r\n	<li>Converting 4 x 2 units into 6 x 4 units</li>\r\n	<li>Shorten and Lengthen chassis</li>\r\n</ul>\r\n', '', '', '', '', '', 1, 9, 1, NULL),
(30, -1, 'The Rose Charity', 'The Rose Charity', 'The Rose Charity', '<h2>White Hill Commercials have been closely involved with The Rose of Charity Orphanage since November 2018.</h2>\r\n\r\n<p>The Rose of Charity Orphanage is based in Victoria Falls, Zimbabwe. It was founded by Sima Moyo in response to the growing number of children orphaned, for many different reasons on the streets of Victoria Falls.</p>\r\n\r\n<p>Sima began by feeding the street children from her own home, using her own savings, three days a week and taking them to church. Her work was soon recognised by the national media and she founded The Rose of Charity Orphanage.&nbsp;</p>\r\n', '<p>Over the years the orphanage has grown, as the number of children needing help increased. Year on Year they are making improvements to the orphanage, thanks to the hard work of Sima and the helpers and the supporters they have worldwide. All the children attend school.</p>\r\n\r\n<p>White Hill Commercials were introduced to Sima and The Rose of &nbsp;Charity in 2018. We collected various gifts, toys, clothes and games, with the help of some of our friends and in December 2018 we sent the children a large box for Christmas.</p>\r\n', '<p>In February 2019 The Rose of Charity raised enough funds to be able to drill a borehole. This was going to be the start of great things. Enough water to sustain their land and water for the goats and chickens which they have on their land.</p>\r\n\r\n<p>This was the start of our close relationship with Sima and The Rose of Charity. We spoke with Sima, discussing how we could improve the children&rsquo;s future.We helped with funds for the children&rsquo;s school fees, managing to send them all to school for the year 2019.</p>\r\n', '<p>Once the borehole was completed. The next step was to purchase a water storage tank, solar panels and a pump, with the help of other supporters and ourselves these were all obtained. The last piece of equipment needed was to install the irrigation pipes in the garden. White Hill Commercials worked closely with Sima to purchase these and the garden project was up and running.</p>\r\n\r\n<p>The garden has been producing a whole range of vegetables and fruits since the summer of 2019. This has made a vast difference to the children&rsquo;s diets, ensuring they are getting the nutritional support they require. The food harvested has been fantastic. The staff at The Rose of Charity work tirelessly to provide for the children, their achievements in 2019 have been amazing.</p>\r\n', '<p>The Rose of Charity also work closely with girls in the rural regions of Monde and Sizanda. The project called &lsquo; Believe in Girls&rsquo; goes out to these areas talking to the girls about a variety of topics, including health, hygiene and personal achievement. They offer counselling sessions for the girls who have major issues to discuss.</p>\r\n\r\n<p>We have been able to send the children another Christmas box in 2019, with new clothes, colouring books, pencils and games.&nbsp;</p>\r\n\r\n<p>White Hill Commercials are looking forward to continuing our support. We have been discussing this years projects with Sima. Work is underway to build a pre school for the younger children. We are planning on funding the older children&rsquo;s school fees for 2020, and are sourcing materials for school uniforms.</p>\r\n', '<p>The Rose of Charity also work closely with girls in the rural regions of Monde and Sizanda. The project called &lsquo; Believe in Girls&rsquo; goes out to these areas talking to the girls about a variety of topics, including health, hygiene and personal achievement. They offer counselling sessions for the girls who have major issues to discuss.</p>\r\n\r\n<p>We have been able to send the children another Christmas box in 2019, with new clothes, colouring books, pencils and games. White Hill Commercials are looking forward to continuing our support. We have been discussing this years projects with Sima. Work is underway to build a pre school for the younger children. We are planning on funding the older children&rsquo;s school fees for 2020, and are sourcing materials for school uniforms.</p>\r\n', '', 1, 10, 1, NULL),
(31, 24, 'Meet The Team', 'Meet The Team', 'Meet The Team', '', '', '', '', '', '', '', 1, 3, 1, NULL),
(32, -1, 'Contact', 'Contact', 'Contact', '', '', '', '', '', '', '', 1, 11, 1, NULL),
(33, 24, 'History', 'History', 'History', '<h2>White Hill Commercials has over 30 years&rsquo; experience of selling used commercial vehicles, spares and plant equipment.</h2>\r\n\r\n<p>White Hill Commercials was established in 2008 by Mick, after working for over 30 years in the export business with his family at J Johnson &amp; sons in York. In 2008, his father Jimmy Johnson retired and Mick opened his own business now known as White Hill Commercials.</p>\r\n\r\n<p>We still remain the family business we have always been, now bringing in the next generation to continue the business.</p>\r\n\r\n<p>White Hill Commercials is owned and operated by Mick Johnson, his wife Jackie, son Danny and daughter Jade.</p>\r\n', '', '', '', '', '', '', 1, 4, 1, NULL),
(34, -1, 'Terms & Conditions', 'Terms & Conditions', 'Terms & Conditions', '', '', '', '', '', '', '', 1, 12, NULL, 1),
(35, -1, 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '', '', '', '', '', '', '', 1, 13, NULL, 1),
(36, -1, 'Cookie Policy', 'Cookie Policy', 'Cookie Policy', '', '', '', '', '', '', '', 1, 14, NULL, 1),
(37, -1, 'Faqs', 'Faqs', 'Faqs', '', '', '', '', '', '', '', 1, 15, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `label` mediumtext,
  `value` mediumtext,
  `control` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `table` varchar(25) DEFAULT NULL,
  `column` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `label`, `value`, `control`, `type`, `class`, `size`, `table`, `column`) VALUES
(1, 'contact_email', 'Contact Email', 'info@newwebsite.co.uk', 'input', 'text', 'required', 40, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `job_title` varchar(256) NOT NULL,
  `about` text NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `job_title`, `about`, `telephone`, `mobile`, `email`, `status`) VALUES
(1, 'Mick Johnson', 'Director, Workshop Manager and Sales Manager', '<p>Mick has over 30 years&rsquo; experience in the trade, both in the sales and the workshop. Bringing to the sales process his knowledge of the vehicles, repair and maintenance skills and the ability to fabricate truck bodies to any specification set by the customer.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '+447889103544 ', '+447889103544 ', 'mick.whc@gmail.com', 1),
(2, 'Jackie Johnson', 'Director, Company Secretary + Sales Consultant', '<p>Director, Company Secretary + Sales Consultant Jackie started working for the company in 2008. Knowledge of the industry came from being an HGV driver herself and being around the trucking industry for many years. As a director and company secretary Jackie deals with the financial management of the company on a day to day basis. As well as dealing with sales and customer services.</p>\r\n', '+44 (0)7889 103544 ', '+447889103544 ', 'whcommercials@gmail.com', 1),
(3, 'Danny Johnson', 'Director and Workshop Fabricator', '<p>Danny started working for the company in 2014, becoming a director in the company in 2017. He is responsible for the day to day running of the workshop. Also dealing with the fabrication and painting work in our onsite workshop facilities.</p>\r\n', '', '', '', 1),
(4, 'Jade Johnson', 'Director and Workshop Fabricator', '<p>Jade started working for the company in 2018. She is responsible for the sales and document administration, advertising and marketing.</p>\r\n', '', '', 'jadejohnsonwhc@gmail.com', 1),
(5, 'Oliver Clough', 'Workshop Fabricator', '', '', '', '', 1),
(6, 'Andy Johnson', 'Transport and Workshop', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '99'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `title`, `content`, `status`, `position`) VALUES
(1, 'John Smith Pocklington', '<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\r\n\r\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n', 1, 99),
(2, 'John Smith Pocklington 2', '<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\r\n\r\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n', 1, 99),
(3, 'John Smith Pocklington 3', '<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\r\n\r\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n', 1, 99);

-- --------------------------------------------------------

--
-- Table structure for table `url_rewrite`
--

CREATE TABLE `url_rewrite` (
  `id` int(11) NOT NULL,
  `table_name` varchar(200) NOT NULL,
  `table_id` int(11) NOT NULL,
  `module` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `url_rewrite`
--

INSERT INTO `url_rewrite` (`id`, `table_name`, `table_id`, `module`, `url`) VALUES
(77, 'page', 16, '', '/404'),
(79, 'page', 20, '', '/'),
(84, 'page', 24, '', '/about'),
(85, 'page', 25, '', '/view-stock'),
(86, 'page', 26, '', '/parts'),
(87, 'page', 27, '', '/export-process-faq'),
(88, 'page', 28, '', '/sell-your-vehicle'),
(89, 'page', 29, '', '/services'),
(90, 'page', 30, '', '/the-rose-charity'),
(91, 'page', 31, '', '/meet-the-team'),
(92, 'page', 32, '', '/contact'),
(93, 'page', 33, '', '/history'),
(94, 'page', 34, '', '/terms-conditions'),
(95, 'page', 35, '', '/privacy-policy'),
(96, 'page', 36, '', '/cookie-policy'),
(97, 'testimonials', 1, '', '/testimonials-john-smith-pocklington'),
(98, 'testimonials', 2, '', '/testimonials-john-smith-pocklington-2'),
(99, 'testimonials', 3, '', '/testimonials-john-smith-pocklington-3'),
(101, 'team', 1, '', '/team/mick-johnson'),
(102, 'team', 2, '', '/team/jackie-johnson'),
(103, 'team', 3, '', '/team/danny-johnson'),
(104, 'team', 4, '', '/team/jade-johnson'),
(105, 'team', 5, '', '/team/oliver-clough'),
(106, 'team', 6, '', '/team/andy-johnson'),
(107, 'page', 37, '', '/faqs'),
(108, 'vehicles', 1, '', '/vehicles/2007-57-daf-xf105');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `display_name` varchar(256) NOT NULL,
  `category` int(11) NOT NULL,
  `make` varchar(256) NOT NULL,
  `model` varchar(256) NOT NULL,
  `year` varchar(4) NOT NULL,
  `description` text NOT NULL,
  `currency` varchar(256) NOT NULL DEFAULT 'GBP',
  `price` decimal(10,2) NOT NULL,
  `hours` int(11) NOT NULL,
  `reg_year` varchar(2) NOT NULL,
  `cab_type` varchar(256) NOT NULL,
  `axel_config` varchar(256) NOT NULL,
  `is_featured` tinyint(2) NOT NULL,
  `is_sold` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `meta_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `display_name`, `category`, `make`, `model`, `year`, `description`, `currency`, `price`, `hours`, `reg_year`, `cab_type`, `axel_config`, `is_featured`, `is_sold`, `status`, `meta_keywords`) VALUES
(1, '2007 (57) DAF XF105', 1, 'DAF', 'XF105', '2007', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmod tempor incidiunt ut labore et dolere magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labor</p>\r\n', 'GBP', '6000.00', 0, '57', 'Sleeper Cab', '6x2', 1, 0, 1, 'whitehill commercials');

-- --------------------------------------------------------

--
-- Table structure for table `web_forms`
--

CREATE TABLE `web_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `form_key` varchar(255) DEFAULT NULL,
  `data` mediumtext,
  `html` tinyint(4) DEFAULT '0',
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_forms`
--
ALTER TABLE `contact_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `export_process`
--
ALTER TABLE `export_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_images`
--
ALTER TABLE `module_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `url_rewrite`
--
ALTER TABLE `url_rewrite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_forms`
--
ALTER TABLE `web_forms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `export_process`
--
ALTER TABLE `export_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `module_images`
--
ALTER TABLE `module_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `url_rewrite`
--
ALTER TABLE `url_rewrite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `web_forms`
--
ALTER TABLE `web_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
