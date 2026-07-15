-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 16, 2020 at 10:32 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

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
(1, 'Test', 'cms@wdymail.co.uk', '10c4981bb793e1698a83aea43030a388', '2020-03-15 17:55:29');

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
  `meta_description` mediumtext,
  `status` tinyint(4) DEFAULT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT '99',
  `top_nav` tinyint(4) DEFAULT NULL,
  `footer_nav` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `parent_id`, `menu_title`, `page_title`, `h1_title`, `content`, `meta_description`, `status`, `position`, `top_nav`, `footer_nav`) VALUES
(16, -1, '404', 'Page Not Found', 'Page Not Found', '<p>We&#39;re sorry but the page you were looking for was not found.</p>\r\n\r\n<p>Please use the links above to find what you were looking for.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '', 1, 4, NULL, NULL),
(20, -1, 'Home', 'Home', 'Home', '', '', 1, 0, NULL, NULL),
(24, -1, 'About', 'About', 'About', '', '', 1, 99, 1, NULL),
(25, -1, 'View Stock', 'View Stock', 'View Stock', '', '', 1, 99, 1, NULL),
(26, -1, 'Parts', 'Parts', 'Parts', '', '', 1, 99, 1, NULL),
(27, -1, 'Export Process FAQ', 'Export Process FAQ', 'Export Process FAQ', '', '', 1, 99, 1, NULL),
(28, -1, 'Sell Your Vehicle', 'Sell Your Vehicle', 'Sell Your Vehicle', '<p>Sell your tractor unit, rigid truck, trailer, van or tipper truck</h2>         <p>For a fair valuation, complete the form below and click the Send button. We usually can provide an estimated valuation within 24 hours.</p>', '', 1, 99, 1, NULL),
(29, -1, 'Services', 'Services', 'Services', '', '', 1, 99, 1, NULL),
(30, -1, 'The Rose Charity', 'The Rose Charity', 'The Rose Charity', '', '', 1, 99, 1, NULL),
(31, 24, 'Meet The Team', 'Meet The Team', 'Meet The Team', '', '', 1, 99, 1, NULL),
(32, -1, 'Contact', 'Contact', 'Contact', '', '', 1, 99, 1, NULL),
(33, 24, 'History', 'History', 'History', '', '', 1, 99, 1, NULL),
(34, -1, 'Terms & Conditions', 'Terms & Conditions', 'Terms & Conditions', '', '', 1, 99, NULL, 1),
(35, -1, 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '', '', 1, 99, NULL, 1),
(36, -1, 'Cookie Policy', 'Cookie Policy', 'Cookie Policy', '', '', 1, 99, NULL, 1);

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
  `telephone` varchar(25) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `email` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `job_title`, `about`, `telephone`, `mobile`, `email`, `status`) VALUES
(1, 'Mick Johnson', 'Director, Workshop Manager and Sales Manager', '<p>Mick has over 30 years&rsquo; experience in the trade, both in the sales and the workshop. Bringing to the sales process his knowledge of the vehicles, repair and maintenance skills and the ability to fabricate truck bodies to any specification set by the customer.</p>\r\n', '+44 (0)7889 103544', '+447889 103544', 'mick.whc@gmail.com', 1);

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
(101, 'team', 1, '', '');

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
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `module_images`
--
ALTER TABLE `module_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `url_rewrite`
--
ALTER TABLE `url_rewrite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `web_forms`
--
ALTER TABLE `web_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
