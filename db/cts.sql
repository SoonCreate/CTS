-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2014 at 09:28 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cts`
--

-- --------------------------------------------------------

--
-- Table structure for table `ct_authobj_lines`
--

CREATE TABLE IF NOT EXISTS `ct_authobj_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `valuelist_id` int(11) NOT NULL,
  `default_value` text NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`object_id`,`valuelist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ct_authobj_lines`
--

INSERT INTO `ct_authobj_lines` (`id`, `object_id`, `valuelist_id`, `default_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(3, 1, 9, 'all', NULL, NULL, NULL, NULL),
(4, 1, 6, 'all', NULL, NULL, NULL, NULL),
(5, 1, 8, 'all', NULL, NULL, NULL, NULL),
(6, 2, 11, 'TRUE', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_authobj_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_authobj_lines_v` (
`id` int(11)
,`object_id` int(11)
,`valuelist_id` int(11)
,`default_value` text
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`object_name` varchar(20)
,`object_desc` varchar(255)
,`auth_item_name` varchar(20)
,`auth_item_desc` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_authority_objects`
--

CREATE TABLE IF NOT EXISTS `ct_authority_objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object_name` (`object_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ct_authority_objects`
--

INSERT INTO `ct_authority_objects` (`id`, `object_name`, `description`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'category_control', '订单控制权限对象1', NULL, NULL, 1411958674, -1),
(2, 'only_mine_control', '只能自己的订单', 1412066866, -1, 1412066866, -1);

-- --------------------------------------------------------

--
-- Table structure for table `ct_configs`
--

CREATE TABLE IF NOT EXISTS `ct_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  `editable_flag` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_name` (`config_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `ct_configs`
--

INSERT INTO `ct_configs` (`id`, `config_name`, `description`, `config_value`, `editable_flag`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'company_name', '公司名称', '浙江天正集团', 1, NULL, NULL, NULL, NULL),
(2, 'logo_file', 'Logo文件路径', '1', 1, NULL, NULL, NULL, NULL),
(3, 'upload_path', '文件上传路径。该路径必须是可写的，相对路径和绝对路径均可以。', 'resources/uploads', 0, NULL, NULL, NULL, NULL),
(4, 'category_control', '投诉订单分类功能开关', '0', 1, NULL, NULL, NULL, NULL),
(5, 'all_values', '包含所有值', 'all', 0, NULL, NULL, NULL, NULL),
(6, 'alarm_period', '报警周期，每次报警的时间间隔，单位为小时', '24', 1, NULL, NULL, NULL, NULL),
(7, 'mail_protocol', 'mail, sendmail, or smtp 邮件发送协议', 'smtp', 1, NULL, NULL, NULL, NULL),
(8, 'sendmail_path', '服务器上 Sendmail 的实际路径。protocol 为 sendmail 时使用', '/usr/sbin/sendmail', 1, NULL, NULL, NULL, NULL),
(9, 'smtp_host', 'SMTP 服务器地址', 'smtp.ym.163.com', 1, NULL, NULL, NULL, NULL),
(10, 'smtp_user', 'SMTP 用户账号', 'yacole@sooncreate.com', 1, NULL, NULL, NULL, NULL),
(11, 'smtp_pass', 'SMTP 密码', '325604', 1, NULL, NULL, NULL, NULL),
(12, 'smtp_port', 'SMTP 端口', '25', 1, NULL, NULL, NULL, NULL),
(13, 'smtp_timeout', 'SMTP 超时设置(单位：秒)', '5', 1, NULL, NULL, NULL, NULL),
(14, 'mail_wordwrap', 'TRUE 或 FALSE (布尔值)	MAIL开启自动换行', 'TRUE', 1, NULL, NULL, NULL, NULL),
(15, 'mail_wrapchars', '自动换行时每行的最大字符数', '76', 1, NULL, NULL, NULL, NULL),
(16, 'mail_content_type', 'text 或 html	邮件类型。发送 HTML 邮件比如是完整的网页。请确认网页中是否有相对路径的链接和图片地址，它们在邮件中不能正确显示。', 'html', 1, NULL, NULL, NULL, NULL),
(17, 'mail_charset', '字符集(utf-8, iso-8859-1 等)', 'utf-8', 1, NULL, NULL, NULL, NULL),
(18, 'mail_validate', 'TRUE 或 FALSE (布尔值)	是否验证邮件地址', 'FALSE', 1, NULL, NULL, NULL, NULL),
(19, 'mail_newline', '"\\r\\n" or "\\n" or "\\r"	换行符. (使用 "\\r\\n" to 以遵守RFC 822).', '\\n', 1, NULL, NULL, NULL, NULL),
(20, 'bcc_batch_mode', 'TRUE or FALSE (boolean)	启用批量暗送模式', 'FALSE', 1, NULL, NULL, NULL, NULL),
(21, 'bcc_batch_size', '批量暗送的邮件数', '200', 1, NULL, NULL, NULL, NULL),
(22, 'mail_from', '邮件默认来自于，如果是smtp方式，必须同smtp_user', 'yacole@sooncreate.com', 1, NULL, NULL, NULL, NULL),
(23, 'mail_from_name', '邮件来自，名称用于显示自动邮件的发件人姓名', '系统管理员', 1, NULL, NULL, NULL, NULL),
(24, 'site_url', '网站地址', 'localhost', 1, NULL, NULL, NULL, NULL),
(25, 'initial_password', '系统用户初始密码', '123456', 1, NULL, NULL, NULL, NULL),
(26, 'upload_allowed_types', '允许上传文件的MIME类型；通常文件扩展名可以做为MIME类型. 允许多个类型用竖线‘|’分开', 'gif|jpg|png|pdf|doc|docx|xls|xlsx', 1, NULL, NULL, NULL, NULL),
(27, 'upload_overwrite', '是否覆盖。该参数为TRUE时，如果上传文件时碰到重名文件，将会把原文件覆盖；如果该参数为FALSE，上传文件重名时，CI将会在新文件的文件名后面加一个数字。', 'FALSE', 1, NULL, NULL, NULL, NULL),
(28, 'upload_max_size', '允许上传文件大小的最大值（以K为单位）。该参数为0则不限制。注意：通常PHP也有这项限制，可以在php.ini文件中指定。通常默认为2MB。', '200', 1, NULL, NULL, NULL, NULL),
(29, 'upload_max_width', '上传文件的宽度最大值（像素为单位）。0为不限制。', '1024', 1, NULL, NULL, NULL, NULL),
(30, 'upload_max_height', '上传文件的高度最大值（像素为单位）。0为不限制。', '768', 1, NULL, NULL, NULL, NULL),
(31, 'upload_max_filename', '文件名的最大长度。0为不限制。', '0', 1, NULL, NULL, NULL, NULL),
(32, 'upload_encrypt_name', '是否重命名文件。如果该参数为TRUE，上传的文件将被重命名为随机的加密字符串。当你想让文件上传者也不能区分自己上传的文件的文件名时，是非常有用的。当 overwrite 为 FALSE 时，此选项才起作用。', 'TRUE', 1, NULL, NULL, NULL, NULL),
(33, 'upload_remove_spaces', '参数为TRUE时，文件名中的空格将被替换为下划线。推荐使用。', 'TRUE', 1, NULL, NULL, NULL, NULL),
(34, 'status_for_lock', '在此状态下，订单被锁定，无法操作', 'closed', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ct_feedbacks`
--

CREATE TABLE IF NOT EXISTS `ct_feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `content` text,
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ct_feedback_stars`
--

CREATE TABLE IF NOT EXISTS `ct_feedback_stars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedback_id` int(11) NOT NULL,
  `feedback_type` varchar(20) NOT NULL,
  `stars` int(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`feedback_id`,`feedback_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ct_files`
--

CREATE TABLE IF NOT EXISTS `ct_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` float DEFAULT NULL,
  `is_image` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `file_path` varchar(255) DEFAULT NULL,
  `full_path` varchar(255) DEFAULT NULL,
  `raw_name` varchar(100) DEFAULT NULL,
  `orig_name` varchar(255) DEFAULT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `file_ext` varchar(45) DEFAULT NULL,
  `image_width` int(10) unsigned DEFAULT NULL,
  `image_height` int(10) unsigned DEFAULT NULL,
  `image_type` varchar(45) DEFAULT NULL,
  `image_size_str` varchar(255) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ct_files`
--

INSERT INTO `ct_files` (`id`, `file_name`, `file_type`, `file_size`, `is_image`, `file_path`, `full_path`, `raw_name`, `orig_name`, `client_name`, `file_ext`, `image_width`, `image_height`, `image_type`, `image_size_str`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, '07849043460b9e3f5bf54b3dd5e69793.doc', 'application/msword', 40.5, 0, 'E:/xampp/htdocs/CTS/resources/uploads/', 'E:/xampp/htdocs/CTS/resources/uploads/07849043460b9e3f5bf54b3dd5e69793.doc', '07849043460b9e3f5bf54b3dd5e69793', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '.doc', 0, 0, '', '', 1412296792, 44, 1412296792, 44),
(2, 'f14237f81c80fbb22517a0cbb368d8ae.doc', 'application/msword', 40.5, 0, 'E:/xampp/htdocs/CTS/resources/uploads/', 'E:/xampp/htdocs/CTS/resources/uploads/f14237f81c80fbb22517a0cbb368d8ae.doc', 'f14237f81c80fbb22517a0cbb368d8ae', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '.doc', 0, 0, '', '', 1412316270, 44, 1412316270, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_functions`
--

CREATE TABLE IF NOT EXISTS `ct_functions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `help` text,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `display_flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `display_class` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `function_name` (`function_name`,`display_flag`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ct_functions`
--

INSERT INTO `ct_functions` (`id`, `function_name`, `description`, `controller`, `action`, `help`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`, `display_flag`, `display_class`) VALUES
(1, 'order_create', '投诉订单创建', 'order', 'create', '1', 1412060589, -1, 1412302661, 44, 1, 'goo'),
(3, 'user_index', '用户管理首页', 'user', 'index', '', 1412147486, 44, 1412147486, 44, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ct_meetings`
--

CREATE TABLE IF NOT EXISTS `ct_meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `start_date` int(10) unsigned NOT NULL,
  `end_date` int(10) unsigned NOT NULL,
  `site` varchar(100) NOT NULL,
  `anchor` varchar(45) NOT NULL,
  `recorder` varchar(45) DEFAULT NULL,
  `actor` varchar(255) NOT NULL,
  `discuss` text,
  `cancel_reason` varchar(20) DEFAULT NULL,
  `cancel_remark` text,
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(10) unsigned DEFAULT NULL,
  `last_update_date` int(10) unsigned DEFAULT NULL,
  `last_updated_by` int(10) unsigned DEFAULT NULL,
  `inactive_flag` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ct_meetings`
--

INSERT INTO `ct_meetings` (`id`, `title`, `start_date`, `end_date`, `site`, `anchor`, `recorder`, `actor`, `discuss`, `cancel_reason`, `cancel_remark`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`, `inactive_flag`) VALUES
(1, 'asdf', 1412265600, 1412265600, 'sdfasdf', 'asdfasdf', 'asdf', 'asdfasdf', 'asdfasdf', NULL, NULL, 44, 1412301790, 1412301790, 44, 0),
(2, 'asdfasdf', 1412352000, 1412352000, 'sadf', 'asdf', 'asdf', 'asdf', 'asdf', NULL, NULL, 44, 1412305995, 1412305995, 44, 0),
(3, 'asdf', 1412265600, 1412265600, 'ggg', 'gg', 'gg', 'gg', NULL, '10', '阿三东帆', 44, 1412309412, 1412313261, 44, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ct_meeting_files`
--

CREATE TABLE IF NOT EXISTS `ct_meeting_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` int(10) unsigned NOT NULL,
  `file_id` int(10) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `creation_date` int(10) unsigned DEFAULT NULL,
  `last_update_date` int(10) unsigned DEFAULT NULL,
  `last_updated_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ct_meeting_files`
--

INSERT INTO `ct_meeting_files` (`id`, `meeting_id`, `file_id`, `description`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, 2, '会议纪要', 44, 1412316270, 1412316270, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_meeting_files_v`
--
CREATE TABLE IF NOT EXISTS `ct_meeting_files_v` (
`id` int(10) unsigned
,`file_name` varchar(255)
,`file_type` varchar(255)
,`file_size` float
,`is_image` tinyint(3) unsigned
,`file_path` varchar(255)
,`full_path` varchar(255)
,`raw_name` varchar(100)
,`orig_name` varchar(255)
,`client_name` varchar(100)
,`file_ext` varchar(45)
,`image_width` int(10) unsigned
,`image_height` int(10) unsigned
,`image_type` varchar(45)
,`image_size_str` varchar(255)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`meeting_id` int(10) unsigned
,`description` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_messages`
--

CREATE TABLE IF NOT EXISTS `ct_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `message_code` varchar(20) NOT NULL,
  `content` varchar(255) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_id` (`class_id`,`message_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_messages_v`
--
CREATE TABLE IF NOT EXISTS `ct_messages_v` (
`id` int(11)
,`class_id` int(11)
,`message_code` varchar(20)
,`content` varchar(255)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`class_code` varchar(20)
,`class_desc` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_message_classes`
--

CREATE TABLE IF NOT EXISTS `ct_message_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_code` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_code` (`class_code`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ct_message_classes`
--

INSERT INTO `ct_message_classes` (`id`, `class_code`, `description`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'DB', '数据库相关消息', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ct_module_header`
--

CREATE TABLE IF NOT EXISTS `ct_module_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `display_class` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ct_module_header`
--

INSERT INTO `ct_module_header` (`id`, `module_name`, `description`, `sort`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`, `display_class`) VALUES
(3, 'system_admin', '系统管理', 0, 1412060859, -1, 1412060859, -1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ct_module_lines`
--

CREATE TABLE IF NOT EXISTS `ct_module_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `function_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ct_module_lines`
--

INSERT INTO `ct_module_lines` (`id`, `module_id`, `function_id`, `sort`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(13, 3, 1, 0, 1412060872, -1, 1412060872, -1),
(14, 3, 3, 0, 1412147498, 44, 1412147498, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_module_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_module_lines_v` (
`id` int(11)
,`module_id` int(11)
,`function_id` int(11)
,`sort` int(11)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`module_name` varchar(100)
,`module_desc` varchar(255)
,`function_name` varchar(100)
,`function_desc` varchar(255)
,`module_sort` int(11)
,`controller` varchar(255)
,`action` varchar(255)
,`display_flag` tinyint(3) unsigned
,`function_display_class` varchar(100)
,`module_display_class` varchar(100)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_notices`
--

CREATE TABLE IF NOT EXISTS `ct_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_id` int(11) DEFAULT NULL,
  `read_flag` tinyint(1) NOT NULL DEFAULT '0',
  `content` text,
  `from_log` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `ct_notices`
--

INSERT INTO `ct_notices` (`id`, `log_id`, `read_flag`, `content`, `from_log`, `title`, `order_id`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 21, 0, '', 1, '', 1, 44, 1412149769, 1412149769, 44),
(2, 22, 0, '', 1, '', 2, 44, 1412150096, 1412150096, 44),
(6, 26, 0, '从confirmed 变成 released', 1, '投诉单3 状态有新的变化', 3, 44, 1412150362, 1412150362, 44),
(7, 27, 0, '从allocated 变成 confirmed', 1, '投诉单1 状态有新的变化', 1, 44, 1412216119, 1412216119, 44),
(8, 28, 0, '从done 变成 allocated', 1, '投诉单1 状态有新的变化', 1, 44, 1412227442, 1412227442, 44),
(9, 29, 0, '从closed 变成 done', 1, '投诉单1 状态有新的变化', 1, 44, 1412227657, 1412227657, 44),
(10, 30, 0, '从allocated 变成 confirmed', 1, '投诉单2 状态有新的变化', 2, 44, 1412227892, 1412227892, 44),
(11, 33, 0, '从已分配 变成 已分配', 1, '投诉单2 状态有新的变化', 2, 44, 1412228471, 1412228471, 44),
(12, 34, 0, '从已分配 变成 已分配', 1, '投诉单2 状态有新的变化', 2, 44, 1412228630, 1412228630, 44),
(13, 35, 0, '责任人从 44 变成 40', 1, '订单 2 责任人变更', 2, 44, 1412228630, 1412228630, 44),
(14, 36, 0, '责任人从 40 变成 1', 1, '订单 2 责任人变更', 2, 44, 1412228914, 1412228914, 44),
(15, 37, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 2 责任人变更', 2, 44, 1412232565, 1412232565, 44),
(16, 38, 0, '从已确认 变成 已分配', 1, '投诉单3 状态有新的变化', 3, 44, 1412232638, 1412232638, 44),
(17, 39, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 3 责任人变更', 3, 44, 1412232638, 1412232638, 44),
(18, 40, 0, '从已分配 变成 已解决', 1, '投诉单2 状态有新的变化', 2, 44, 1412232766, 1412232766, 44),
(19, 41, 0, '从已解决 变成 已关闭', 1, '投诉单2 状态有新的变化', 2, 44, 1412320728, 1412320728, 44),
(20, 42, 0, '从已关闭 变成 重新打开', 1, '投诉单2 状态有新的变化', 2, 44, 1412320737, 1412320737, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_orders`
--

CREATE TABLE IF NOT EXISTS `ct_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `severity` varchar(20) NOT NULL,
  `frequency` varchar(20) NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `plan_complete_date` int(11) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `mobile_telephone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `warning_count` int(11) NOT NULL DEFAULT '0',
  `creation_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_type`,`status`,`manager_id`) USING BTREE,
  KEY `Index_3` (`created_by`,`creation_date`,`status`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `ct_orders`
--

INSERT INTO `ct_orders` (`id`, `order_type`, `status`, `severity`, `frequency`, `category`, `title`, `manager_id`, `plan_complete_date`, `contact`, `phone_number`, `mobile_telephone`, `address`, `full_name`, `warning_count`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'employee', 'closed', 'low', 'low', '30', 'google', 1, 1412697600, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058395, 44, 1412227657, 44),
(2, 'employee', 'reopen', 'low', 'low', '30', 'google', 44, 1407686400, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058525, 44, 1412320737, 44),
(3, 'employee', 'allocated', 'low', 'low', '30', 'google', 44, 0, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058552, 44, 1412232638, 44),
(4, 'employee', 'released', 'low', 'low', '30', 'google', 0, NULL, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058587, 44, 1412058587, 44),
(5, 'employee', 'released', 'low', 'low', '30', 'google', 0, NULL, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058603, 44, 1412058603, 44),
(6, 'employee', 'released', 'low', 'low', '30', 'google', 0, NULL, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058653, 44, 1412058653, 44),
(7, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, 'asdf', NULL, NULL, 0, 1412058707, 44, 1412058707, 44),
(8, 'vendor', 'released', 'low', 'middle', '20', '啊水电费', 0, NULL, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059034, 44, 1412059034, 44),
(9, 'vendor', 'released', 'low', 'middle', '20', '啊水电费', 0, NULL, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059093, 44, 1412059093, 44),
(10, 'vendor', 'released', 'low', 'high', '10', '啊水电费', 0, NULL, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059118, 44, 1412059118, 44),
(11, 'vendor', 'released', 'middle', 'high', '10', '啊水电费', 0, NULL, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059234, 44, 1412059234, 44),
(12, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '1111', NULL, NULL, 0, 1412122645, 44, 1412122645, 44),
(13, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '1111', NULL, NULL, 0, 1412122807, 44, 1412122807, 44),
(14, 'employee', 'released', 'low', 'low', '10', 'dsg', 0, NULL, 'asd', NULL, '111', NULL, NULL, 0, 1412124607, 44, 1412124607, 44),
(15, 'vendor', 'released', 'low', 'middle', '10', 'asdf', 0, NULL, 'asdf', NULL, '1111', NULL, NULL, 0, 1412125865, 44, 1412125865, 44),
(16, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412132305, 44, 1412132305, 44),
(17, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412132354, 44, 1412132354, 44),
(18, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412132369, 44, 1412132369, 44),
(19, 'vendor', 'released', 'low', 'low', '10', '11', 0, NULL, '1', NULL, '111', NULL, NULL, 0, 1412132416, 44, 1412132416, 44),
(20, 'vendor', 'released', 'low', 'low', '10', '11', 0, NULL, '1', NULL, '111', NULL, NULL, 0, 1412133624, 44, 1412133624, 44),
(21, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'f', NULL, '111', NULL, NULL, 0, 1412133640, 44, 1412133640, 44),
(22, 'vendor', 'released', 'low', 'low', '10', 'adsf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412133729, 44, 1412133729, 44),
(23, 'vendor', 'released', 'low', 'low', '10', 'adsf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412133795, 44, 1412133795, 44),
(24, 'vendor', 'released', 'low', 'low', '10', 'adsf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412133817, 44, 1412133817, 44),
(25, 'employee', '', 'low', 'middle', '10', 'asdf', 0, NULL, 'asf', '', '11', '', '', 0, 1412215786, 44, 1412215786, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_order_addfiles`
--

CREATE TABLE IF NOT EXISTS `ct_order_addfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `file_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_order_addfiles_v`
--
CREATE TABLE IF NOT EXISTS `ct_order_addfiles_v` (
`id` int(11)
,`order_id` int(11)
,`created_by` int(11)
,`creation_date` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`file_id` int(11)
,`description` varchar(255)
,`file_name` varchar(255)
,`full_path` varchar(255)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_order_category_vl`
--
CREATE TABLE IF NOT EXISTS `ct_order_category_vl` (
`segment_desc` text
,`segment_value` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_order_contents`
--

CREATE TABLE IF NOT EXISTS `ct_order_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `ct_order_contents`
--

INSERT INTO `ct_order_contents` (`id`, `order_id`, `content`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, '供应商投诉订单测试', 44, 1412058395, 1412058395, -1),
(2, 2, '供应商投诉订单测试', 44, 1412058525, 1412058525, 44),
(3, 3, '供应商投诉订单测试', 44, 1412058552, 1412058552, 44),
(4, 4, '供应商投诉订单测试', 44, 1412058587, 1412058587, 44),
(5, 5, '供应商投诉订单测试', 44, 1412058603, 1412058603, 44),
(6, 6, '供应商投诉订单测试', 44, 1412058653, 1412058653, 44),
(7, 7, 'asdf', 44, 1412058707, 1412058707, 44),
(8, 8, '阿三地方', 44, 1412059034, 1412059034, 44),
(9, 9, '阿三地方', 44, 1412059093, 1412059093, 44),
(10, 10, '阿三地方', 44, 1412059118, 1412059118, 44),
(11, 11, '阿三地方', 44, 1412059234, 1412059234, 44),
(12, 12, 'asdf', 44, 1412122645, 1412122645, 44),
(13, 13, 'asdf', 44, 1412122807, 1412122807, 44),
(14, 14, 'asdf', 44, 1412124607, 1412124607, 44),
(15, 15, 'asdf', 44, 1412125865, 1412125865, 44),
(16, 16, 'asdf', 44, 1412132305, 1412132305, 44),
(17, 17, 'asdf', 44, 1412132354, 1412132354, 44),
(18, 18, 'asdf', 44, 1412132369, 1412132369, 44),
(19, 19, '11', 44, 1412132416, 1412132416, 44),
(20, 20, '11', 44, 1412133624, 1412133624, 44),
(21, 21, 'asdf', 44, 1412133640, 1412133640, 44),
(22, 22, 'asdf', 44, 1412133729, 1412133729, 44),
(23, 23, 'asdf', 44, 1412133795, 1412133795, 44),
(24, 24, 'asdf', 44, 1412133817, 1412133817, 44),
(25, 25, 'asdfasdf', 44, 1412215786, 1412215786, 44),
(26, 2, '问题已经解决，你可以关闭了', 44, 1412233237, 1412233237, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_order_logs`
--

CREATE TABLE IF NOT EXISTS `ct_order_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `log_type` varchar(20) NOT NULL,
  `new_value` varchar(255) NOT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `reason` text,
  `change_hash` int(11) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`),
  KEY `Index_3` (`change_hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `ct_order_logs`
--

INSERT INTO `ct_order_logs` (`id`, `order_id`, `log_type`, `new_value`, `old_value`, `reason`, `change_hash`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, 'stauts', 'released', NULL, NULL, 0, 1412058395, -1, 1412058395, -1),
(2, 1, 'status', 'released', NULL, NULL, 0, 1412058395, -1, 1412058395, -1),
(3, 2, 'stauts', 'released', NULL, NULL, 0, 1412058525, -1, 1412058525, -1),
(4, 3, 'stauts', 'released', NULL, NULL, 0, 1412058552, -1, 1412058552, -1),
(5, 4, 'stauts', 'released', NULL, NULL, 0, 1412058587, -1, 1412058587, -1),
(6, 5, 'stauts', 'released', NULL, NULL, 0, 1412058603, -1, 1412058603, -1),
(7, 6, 'stauts', 'released', NULL, NULL, 0, 1412058653, -1, 1412058653, -1),
(8, 7, 'stauts', 'released', NULL, NULL, 0, 1412058707, -1, 1412058707, -1),
(9, 8, 'stauts', 'released', NULL, NULL, 0, 1412059034, -1, 1412059034, -1),
(10, 9, 'stauts', 'released', NULL, NULL, 0, 1412059093, -1, 1412059093, -1),
(11, 10, 'stauts', 'released', NULL, NULL, 0, 1412059118, -1, 1412059118, -1),
(12, 11, 'stauts', 'released', NULL, NULL, 0, 1412059234, -1, 1412059234, -1),
(13, 12, 'stauts', 'released', NULL, NULL, 0, 1412122645, -1, 1412122645, -1),
(14, 13, 'stauts', 'released', NULL, NULL, 0, 1412122807, -1, 1412122807, -1),
(15, 14, 'stauts', 'released', NULL, NULL, 0, 1412124607, -1, 1412124607, -1),
(16, 15, 'stauts', 'released', NULL, NULL, 0, 1412125865, -1, 1412125865, -1),
(17, 16, 'status_insert', 'released', NULL, NULL, 0, 1412132305, 44, 1412132305, 44),
(18, 17, 'status_insert', 'released', NULL, NULL, 0, 1412132354, 44, 1412132354, 44),
(19, 18, 'status_insert', 'released', NULL, NULL, 0, 1412132369, 44, 1412132369, 44),
(20, 24, 'status_insert', 'released', NULL, 'cao', 1412133817, 1412133817, 44, 1412135673, 44),
(21, 1, 'status_update', 'confirmed', 'released', '测试', 1412149769, 1412149769, 44, 1412149780, 44),
(22, 2, 'status_update', 'confirmed', 'released', NULL, 1412150096, 1412150096, 44, 1412150096, 44),
(26, 3, 'status_update', 'confirmed', 'released', '第三个测试', 1412150362, 1412150362, 44, 1412150370, 44),
(27, 1, 'status_update', 'allocated', 'confirmed', 'adf', 1412216119, 1412216119, 44, 1412216123, 44),
(28, 1, 'status_update', 'done', 'allocated', NULL, 1412227442, 1412227442, 44, 1412227442, 44),
(29, 1, 'status_update', 'closed', 'done', NULL, 1412227657, 1412227657, 44, 1412227657, 44),
(30, 2, 'status_update', 'allocated', 'confirmed', NULL, 1412227892, 1412227892, 44, 1412227892, 44),
(32, 2, 'status_update', 'allocated', 'allocated', NULL, 1412228419, 1412228419, 44, 1412228419, 44),
(33, 2, 'status_update', 'allocated', 'allocated', NULL, 1412228471, 1412228471, 44, 1412228471, 44),
(34, 2, 'status_update', 'allocated', 'allocated', '陈杨阳出差了', 1412228630, 1412228630, 44, 1412228642, 44),
(35, 2, 'manager_change', '40', '44', '陈杨阳出差了', 1412228630, 1412228630, 44, 1412228642, 44),
(36, 2, 'manager_change', '1', '40', '陈杨阳又回来了', 1412228914, 1412228914, 44, 1412228923, 44),
(37, 2, 'manager_change', '44', '1', NULL, 1412232565, 1412232565, 44, 1412232565, 44),
(38, 3, 'status_update', 'allocated', 'confirmed', NULL, 1412232638, 1412232638, 44, 1412232638, 44),
(39, 3, 'manager_change', '44', '0', NULL, 1412232638, 1412232638, 44, 1412232638, 44),
(40, 2, 'status_update', 'done', 'allocated', NULL, 1412232766, 1412232766, 44, 1412232766, 44),
(41, 2, 'status_update', 'closed', 'done', NULL, 1412320728, 1412320728, 44, 1412320728, 44),
(42, 2, 'status_update', 'reopen', 'closed', NULL, 1412320737, 1412320737, 44, 1412320737, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_order_logs_v`
--
CREATE TABLE IF NOT EXISTS `ct_order_logs_v` (
`id` int(11)
,`order_id` int(11)
,`log_type` varchar(20)
,`new_value` varchar(255)
,`old_value` varchar(255)
,`reason` text
,`change_hash` int(11)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`description` varchar(255)
,`title` varchar(255)
,`content` text
,`need_reason_flag` tinyint(4)
,`field_name` varchar(100)
,`dll_type` varchar(20)
,`notice_flag` int(11)
,`field_valuelist_id` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_order_log_types`
--

CREATE TABLE IF NOT EXISTS `ct_order_log_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `need_reason_flag` tinyint(4) NOT NULL DEFAULT '0',
  `field_name` varchar(100) NOT NULL,
  `dll_type` varchar(20) NOT NULL,
  `notice_flag` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `field_valuelist_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ct_order_log_types`
--

INSERT INTO `ct_order_log_types` (`id`, `log_type`, `description`, `title`, `content`, `need_reason_flag`, `field_name`, `dll_type`, `notice_flag`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`, `field_valuelist_id`) VALUES
(2, 'status_insert', '新建是状态日志记录', '投诉单&order_id 状态有新的变化', '从&old_value 变成 &new_value', 0, 'status', 'insert', 0, 44, 1412131199, 1412228114, 44, 16),
(3, 'status_update', '状态更新', '投诉单&order_id 状态有新的变化', '从&old_value 变成 &new_value', 0, 'status', 'update', 1, 44, 1412149621, 1412228124, 44, 16),
(4, 'manager_change', '责任人修改', '订单 &order_id 责任人变更', '责任人从 &old_value 变成 &new_value', 1, 'manager_id', 'update', 1, 44, 1412228612, 1412232535, 44, 17);

-- --------------------------------------------------------

--
-- Table structure for table `ct_order_meetings`
--

CREATE TABLE IF NOT EXISTS `ct_order_meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `meeting_id` int(10) unsigned NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(10) unsigned DEFAULT NULL,
  `last_updated_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`order_id`,`meeting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ct_order_meetings`
--

INSERT INTO `ct_order_meetings` (`id`, `order_id`, `meeting_id`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 2, 1, NULL, NULL, NULL, NULL),
(2, 2, 2, 44, 1412305995, 1412305995, 44),
(4, 3, 3, 44, 1412310745, 1412310745, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_order_meetings_v`
--
CREATE TABLE IF NOT EXISTS `ct_order_meetings_v` (
`id` int(10) unsigned
,`title` varchar(100)
,`start_date` int(10) unsigned
,`end_date` int(10) unsigned
,`site` varchar(100)
,`anchor` varchar(45)
,`recorder` varchar(45)
,`actor` varchar(255)
,`discuss` text
,`cancel_reason` varchar(20)
,`cancel_remark` text
,`created_by` int(11)
,`creation_date` int(10) unsigned
,`last_update_date` int(10) unsigned
,`last_updated_by` int(10) unsigned
,`inactive_flag` int(10) unsigned
,`order_id` int(10) unsigned
,`order_title` varchar(100)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_order_status_vl`
--
CREATE TABLE IF NOT EXISTS `ct_order_status_vl` (
`id` int(11)
,`status_id` int(11)
,`segment` varchar(20)
,`segment_value` varchar(255)
,`segment_desc` varchar(255)
,`next_status` varchar(255)
,`back_status` varchar(20)
,`default_flag` tinyint(1)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_roles`
--

CREATE TABLE IF NOT EXISTS `ct_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ct_roles`
--

INSERT INTO `ct_roles` (`id`, `role_name`, `description`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 'reporter_vender', '投诉人-供应商1', NULL, NULL, 1411969381, -1),
(2, 'dispatcher', '调度员', NULL, NULL, NULL, NULL),
(3, 'reporter_employee', '投诉人-内部员工', NULL, NULL, NULL, NULL),
(4, 'reporter_customer', '投诉人-客户', NULL, NULL, NULL, NULL),
(5, 'manager-vendor', '采购经理', NULL, NULL, NULL, NULL),
(6, 'manager-customer', '质量经理', NULL, NULL, NULL, NULL),
(7, 'manager-employee', '人事经理', NULL, NULL, NULL, NULL),
(8, 'administrator', '系统管理员', NULL, NULL, NULL, NULL),
(11, 'sadfasdf', 'asdfsadf', -1, 1411974364, 1411974364, -1);

-- --------------------------------------------------------

--
-- Table structure for table `ct_role_functions`
--

CREATE TABLE IF NOT EXISTS `ct_role_functions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `function_id` int(11) NOT NULL,
  `allow_flag` tinyint(1) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `creation_dat` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ct_role_module_lines`
--

CREATE TABLE IF NOT EXISTS `ct_role_module_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module_line_id` int(11) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ct_role_module_lines`
--

INSERT INTO `ct_role_module_lines` (`id`, `role_id`, `module_line_id`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 8, 13, 1412060895, -1, 1412060895, -1),
(2, 1, 13, 1412060925, -1, 1412060925, -1),
(3, 8, 14, 1412148323, 44, 1412148323, 44),
(4, 1, 14, 1412225521, 44, 1412225521, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_role_module_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_role_module_lines_v` (
`role_module_line_id` int(11)
,`role_id` int(11)
,`id` int(11)
,`module_id` int(11)
,`function_id` int(11)
,`sort` int(11)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`module_name` varchar(100)
,`module_desc` varchar(255)
,`function_name` varchar(100)
,`function_desc` varchar(255)
,`module_sort` int(11)
,`controller` varchar(255)
,`action` varchar(255)
,`display_flag` tinyint(3) unsigned
,`function_display_class` varchar(100)
,`module_display_class` varchar(100)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_role_profiles`
--

CREATE TABLE IF NOT EXISTS `ct_role_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`role_id`,`object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ct_role_profiles`
--

INSERT INTO `ct_role_profiles` (`id`, `role_id`, `object_id`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL),
(2, 1, 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ct_role_profile_lines`
--

CREATE TABLE IF NOT EXISTS `ct_role_profile_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `object_line_id` int(11) NOT NULL,
  `auth_value` text NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`profile_id`,`object_line_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ct_role_profile_lines`
--

INSERT INTO `ct_role_profile_lines` (`id`, `profile_id`, `object_line_id`, `auth_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, 3, 'all', NULL, NULL, NULL, NULL),
(2, 1, 4, 'all', NULL, NULL, NULL, NULL),
(3, 1, 5, 'all', NULL, NULL, NULL, NULL),
(4, 2, 6, 'TRUE', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_role_profile_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_role_profile_lines_v` (
`role_id` int(11)
,`id` int(11)
,`profile_id` int(11)
,`object_line_id` int(11)
,`auth_value` text
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`auth_item_name` varchar(20)
,`auth_item_desc` varchar(255)
,`object_name` varchar(20)
,`object_desc` varchar(255)
,`object_id` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_status_header`
--

CREATE TABLE IF NOT EXISTS `ct_status_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_code` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`status_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ct_status_header`
--

INSERT INTO `ct_status_header` (`id`, `status_code`, `description`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'order_status', '投诉订单状态', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ct_status_lines`
--

CREATE TABLE IF NOT EXISTS `ct_status_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `segment` varchar(20) NOT NULL,
  `segment_value` varchar(255) NOT NULL,
  `segment_desc` varchar(255) NOT NULL,
  `next_status` varchar(255) DEFAULT NULL,
  `back_status` varchar(20) DEFAULT NULL,
  `default_flag` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `default_next_status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_vl_line_01` (`status_id`,`segment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ct_status_lines`
--

INSERT INTO `ct_status_lines` (`id`, `status_id`, `segment`, `segment_value`, `segment_desc`, `next_status`, `back_status`, `default_flag`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`, `default_next_status`) VALUES
(1, 1, '10', 'released', '已提交', '20,50', NULL, 1, NULL, NULL, NULL, NULL, '20'),
(2, 1, '20', 'confirmed', '已确认', '30,50', NULL, 0, NULL, NULL, NULL, NULL, '30'),
(3, 1, '30', 'allocated', '已分配', '30,40,50', NULL, 0, NULL, NULL, NULL, NULL, '40'),
(4, 1, '40', 'done', '已解决', '50', NULL, 0, NULL, NULL, NULL, NULL, '50'),
(5, 1, '50', 'closed', '已关闭', '60', NULL, 0, NULL, NULL, NULL, NULL, '60'),
(6, 1, '60', 'reopen', '重新打开', '30,50', NULL, 0, NULL, NULL, NULL, NULL, '30');

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_status_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_status_lines_v` (
`status_code` varchar(20)
,`description` varchar(255)
,`id` int(11)
,`status_id` int(11)
,`segment` varchar(20)
,`segment_value` varchar(255)
,`segment_desc` varchar(255)
,`next_status` varchar(255)
,`back_status` varchar(20)
,`default_flag` tinyint(1)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`default_next_status` varchar(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_users`
--

CREATE TABLE IF NOT EXISTS `ct_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `mobile_telephone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `inactive_flag` tinyint(1) NOT NULL DEFAULT '0',
  `email_flag` tinyint(1) NOT NULL DEFAULT '0',
  `sms_flag` tinyint(1) NOT NULL DEFAULT '0',
  `initial_pass_flag` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`username`),
  KEY `Index_3` (`username`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `ct_users`
--

INSERT INTO `ct_users` (`id`, `username`, `password`, `contact`, `email`, `phone_number`, `mobile_telephone`, `address`, `full_name`, `inactive_flag`, `email_flag`, `sms_flag`, `initial_pass_flag`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(44, 'yacole', '7c4a8d09ca3762af61e59520943dc26494f8941b', '陈杨阳', 'yacole@sooncreate.com', '13777777777', '13989775601', '乐清柳市镇', '速创科技工作室1', 0, 0, 0, 1, -1, 1412039595, 1412229918, 44),
(45, 'yacole1', 'fbeae417c84f2bf1121ab58c55105b4247c8e069', NULL, NULL, NULL, NULL, NULL, '陈杨阳', 0, 0, 0, 1, 44, 1412229944, 1412229944, 44),
(46, 'yacole2', 'fbeae417c84f2bf1121ab58c55105b4247c8e069', NULL, NULL, NULL, NULL, NULL, '陈杨阳', 0, 0, 0, 1, 44, 1412230134, 1412230134, 44),
(47, 'hellogs', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, NULL, '高哨', 0, 0, 0, 1, 44, 1412230196, 1412230196, 44),
(48, 'yacole111', '92429d82a41e930486c6de5ebda9602d55c39986', NULL, NULL, NULL, NULL, NULL, 'asdfasdf', 0, 0, 0, 1, 44, 1412230229, 1412230229, 44),
(66, 'asdfasdf', '92429d82a41e930486c6de5ebda9602d55c39986', NULL, NULL, NULL, NULL, NULL, 'asdfsadf', 0, 0, 0, 0, 44, 1412231054, 1412231054, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_user_auth_v`
--
CREATE TABLE IF NOT EXISTS `ct_user_auth_v` (
`role_id` int(11)
,`object_name` varchar(20)
,`description` varchar(255)
,`user_id` int(11)
,`profile_id` int(11)
,`id` int(11)
,`username` varchar(200)
,`password` varchar(255)
,`contact` varchar(255)
,`email` varchar(255)
,`phone_number` varchar(255)
,`mobile_telephone` varchar(255)
,`address` varchar(255)
,`full_name` varchar(255)
,`inactive_flag` tinyint(1)
,`email_flag` tinyint(1)
,`sms_flag` tinyint(1)
,`initial_pass_flag` int(11)
,`created_by` int(11)
,`creation_date` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_user_functions_v`
--
CREATE TABLE IF NOT EXISTS `ct_user_functions_v` (
`role_module_line_id` int(11)
,`controller` varchar(255)
,`action` varchar(255)
,`role_id` int(11)
,`id` int(11)
,`module_id` int(11)
,`function_id` int(11)
,`sort` int(11)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`module_name` varchar(100)
,`module_desc` varchar(255)
,`function_name` varchar(100)
,`function_desc` varchar(255)
,`user_id` int(11)
,`module_sort` int(11)
,`display_flag` tinyint(3) unsigned
,`function_display_class` varchar(100)
,`module_display_class` varchar(100)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_user_roles`
--

CREATE TABLE IF NOT EXISTS `ct_user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`user_id`,`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ct_user_roles`
--

INSERT INTO `ct_user_roles` (`id`, `user_id`, `role_id`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 37, 3, 1411826157, 0, 1411826157, 0),
(2, 39, 4, 1411826432, 0, 1411826432, 0),
(3, 40, 1, 1411826457, 0, 1411826457, 0),
(4, 41, 3, 1411826496, 0, 1411826496, 0),
(5, 42, 3, 1411826529, 0, 1411826529, 0),
(9, 40, 1, 1411880420, 0, 1411880420, 0),
(11, 1, 1, 1411892389, 1, 1411892389, 1),
(12, 44, 1, 1412039683, -1, 1412039683, -1),
(13, 44, 1, 1412148394, 44, 1412148394, 44),
(14, 48, 3, 1412230229, 44, 1412230229, 44),
(15, 66, 1, 1412231054, 44, 1412231054, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_valuelist_header`
--

CREATE TABLE IF NOT EXISTS `ct_valuelist_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valuelist_name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `from_obj` tinyint(4) DEFAULT '0',
  `label_fieldname` varchar(100) DEFAULT NULL,
  `value_fieldname` varchar(100) DEFAULT NULL,
  `source_view` varchar(100) DEFAULT NULL,
  `condition` text,
  `parent_id` int(11) DEFAULT NULL,
  `editable_flag` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`valuelist_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `ct_valuelist_header`
--

INSERT INTO `ct_valuelist_header` (`id`, `valuelist_name`, `description`, `from_obj`, `label_fieldname`, `value_fieldname`, `source_view`, `condition`, `parent_id`, `editable_flag`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'vl_order_type', '投诉订单类型', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(2, 'vl_severity', '严重程度', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(3, 'vl_priority', '优先级', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(4, 'vl_frequency', '发生频率', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(6, 'ao_order_status', '订单状态权限对象', 1, 'segment_desc', 'segment_value', 'ct_order_status_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(7, 'vl_order_category', '订单分类', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(8, 'ao_order_category', '订单分类权限对象', 1, 'segment_desc', 'segment_value', 'ct_order_category_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(9, 'ao_order_type', '订单类型权限对象', 1, 'segment_desc', 'segment_value', 'ct_valuelist_vl', 'valuelist_name = ''vl_order_type''', NULL, 1, NULL, NULL, NULL, NULL),
(10, 'default_role', '订单类型默认角色', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(11, 'ao_only_mine', '只能查询自己的订单', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(12, 'default_category', '订单默认的分类（在分类未开启时）', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(14, 'vl_dll_type', '数据库dll操作类型', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(15, 'vl_valuelist', '值集列表', 1, 'description', 'id', 'ct_valuelist_header', 'valuelist_name like ''vl_%''', NULL, 1, NULL, NULL, NULL, NULL),
(16, 'vl_order_status', '投诉单状态', 1, 'segment_desc', 'segment_value', 'ct_order_status_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(17, 'vl_user', '用户列表', 1, 'full_name', 'id', 'ct_users', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(18, 'vl_meeting_cancel', '会议取消原因', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ct_valuelist_lines`
--

CREATE TABLE IF NOT EXISTS `ct_valuelist_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valuelist_id` int(11) NOT NULL,
  `segment` varchar(20) NOT NULL,
  `segment_value` varchar(255) NOT NULL,
  `segment_desc` varchar(255) NOT NULL,
  `inactive_flag` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `parent_segment_value` varchar(20) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_vl_line_01` (`valuelist_id`,`segment`,`parent_segment_value`) USING BTREE,
  KEY `Index_3` (`valuelist_id`,`parent_segment_value`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `ct_valuelist_lines`
--

INSERT INTO `ct_valuelist_lines` (`id`, `valuelist_id`, `segment`, `segment_value`, `segment_desc`, `inactive_flag`, `sort`, `parent_segment_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, '10', 'vendor', '供应商投诉订单', 0, 0, '0', NULL, NULL, NULL, NULL),
(2, 1, '20', 'employee', '内部员工投诉订单', 0, 0, '0', NULL, NULL, NULL, NULL),
(3, 1, '30', 'customer', '客户投诉订单', 0, 0, '0', NULL, NULL, NULL, NULL),
(4, 2, '30', 'low', '低', 0, 0, '0', NULL, NULL, NULL, NULL),
(5, 2, '20', 'middle', '中', 0, 0, '0', NULL, NULL, NULL, NULL),
(6, 2, '10', 'high', '高', 0, 0, '0', NULL, NULL, NULL, NULL),
(7, 3, '30', 'low', '低', 0, 0, '0', NULL, NULL, NULL, NULL),
(8, 3, '20', 'middle', '中', 0, 0, '0', NULL, NULL, NULL, NULL),
(9, 3, '10', 'high', '高', 0, 0, '0', NULL, NULL, NULL, NULL),
(10, 4, '10', 'low', '仅发生一次', 0, 0, '0', NULL, NULL, NULL, NULL),
(11, 4, '20', 'middle', '偶尔发生', 0, 0, '0', NULL, NULL, NULL, NULL),
(12, 4, '30', 'high', '发生频率很高', 0, 0, '0', NULL, NULL, NULL, NULL),
(16, 7, '10', '10', '供应商投诉默认分类', 0, 0, 'vendor', NULL, NULL, NULL, NULL),
(18, 10, '10', 'reporter_vender', '默认供应商投诉角色', 0, 0, 'vendor', NULL, NULL, NULL, NULL),
(21, 10, '10', 'reporter_customer', '默认客户投诉角色', 0, 0, 'customer', NULL, NULL, NULL, NULL),
(22, 10, '10', 'reporter_employee', '默认员工投诉角色', 0, 0, 'employee', NULL, NULL, NULL, NULL),
(24, 7, '20', '20', '分类二', 0, 0, 'vendor', NULL, NULL, NULL, NULL),
(25, 7, '10', '10', '客户投诉默认分类', 0, 0, 'customer', NULL, NULL, NULL, NULL),
(26, 7, '10', '30', '内部员工投诉默认分类', 0, 0, 'employee', NULL, NULL, NULL, NULL),
(27, 11, '10', 'TRUE', '是', 0, 0, NULL, NULL, NULL, NULL, NULL),
(28, 11, '20', 'FALSE', '否', 0, 0, NULL, NULL, NULL, NULL, NULL),
(29, 12, '10', '10', '供应商投诉订单默认分类', 0, 0, 'vendor', NULL, NULL, NULL, NULL),
(30, 12, '20', '10', '客户投诉订单默认分类', 0, 0, 'customer', NULL, NULL, NULL, NULL),
(31, 12, '30', '10', '内部投诉订单默认分类', 0, 0, 'employee', NULL, NULL, NULL, NULL),
(32, 14, '10', 'update', '更新', 0, 0, NULL, NULL, NULL, NULL, NULL),
(33, 14, '20', 'insert', '创建', 0, 0, NULL, NULL, NULL, NULL, NULL),
(34, 18, '10', '10', '投诉问题已解决', 0, 0, NULL, NULL, NULL, NULL, NULL),
(35, 18, '20', '20', '创建失误', 0, 0, NULL, NULL, NULL, NULL, NULL),
(36, 18, '30', '30', '确认无需再召开', 0, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_valuelist_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_valuelist_lines_v` (
`valuelist_name` varchar(20)
,`description` varchar(255)
,`from_obj` tinyint(4)
,`label_fieldname` varchar(100)
,`value_fieldname` varchar(100)
,`source_view` varchar(100)
,`condition` text
,`parent_id` int(11)
,`id` int(11)
,`valuelist_id` int(11)
,`segment` varchar(20)
,`segment_value` varchar(255)
,`segment_desc` varchar(255)
,`inactive_flag` tinyint(1)
,`sort` int(11)
,`parent_segment` varchar(20)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_valuelist_vl`
--
CREATE TABLE IF NOT EXISTS `ct_valuelist_vl` (
`valuelist_name` varchar(20)
,`valuelist_desc` varchar(255)
,`segment` varchar(20)
,`segment_value` varchar(255)
,`segment_desc` varchar(255)
);
-- --------------------------------------------------------

--
-- Structure for view `ct_authobj_lines_v`
--
DROP TABLE IF EXISTS `ct_authobj_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_authobj_lines_v` AS select `l`.`id` AS `id`,`l`.`object_id` AS `object_id`,`l`.`valuelist_id` AS `valuelist_id`,`l`.`default_value` AS `default_value`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by`,`h`.`object_name` AS `object_name`,`h`.`description` AS `object_desc`,`vl`.`valuelist_name` AS `auth_item_name`,`vl`.`description` AS `auth_item_desc` from ((`ct_authority_objects` `h` join `ct_authobj_lines` `l`) join `ct_valuelist_header` `vl`) where ((`l`.`object_id` = `h`.`id`) and (`vl`.`id` = `l`.`valuelist_id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_meeting_files_v`
--
DROP TABLE IF EXISTS `ct_meeting_files_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_meeting_files_v` AS select `f`.`id` AS `id`,`f`.`file_name` AS `file_name`,`f`.`file_type` AS `file_type`,`f`.`file_size` AS `file_size`,`f`.`is_image` AS `is_image`,`f`.`file_path` AS `file_path`,`f`.`full_path` AS `full_path`,`f`.`raw_name` AS `raw_name`,`f`.`orig_name` AS `orig_name`,`f`.`client_name` AS `client_name`,`f`.`file_ext` AS `file_ext`,`f`.`image_width` AS `image_width`,`f`.`image_height` AS `image_height`,`f`.`image_type` AS `image_type`,`f`.`image_size_str` AS `image_size_str`,`f`.`creation_date` AS `creation_date`,`f`.`created_by` AS `created_by`,`f`.`last_update_date` AS `last_update_date`,`f`.`last_updated_by` AS `last_updated_by`,`omf`.`meeting_id` AS `meeting_id`,`omf`.`description` AS `description` from (`ct_files` `f` join `ct_meeting_files` `omf`) where (`omf`.`file_id` = `f`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_messages_v`
--
DROP TABLE IF EXISTS `ct_messages_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_messages_v` AS select `m`.`id` AS `id`,`m`.`class_id` AS `class_id`,`m`.`message_code` AS `message_code`,`m`.`content` AS `content`,`m`.`creation_date` AS `creation_date`,`m`.`created_by` AS `created_by`,`m`.`last_update_date` AS `last_update_date`,`m`.`last_updated_by` AS `last_updated_by`,`mc`.`class_code` AS `class_code`,`mc`.`description` AS `class_desc` from (`ct_message_classes` `mc` join `ct_messages` `m`) where (`m`.`class_id` = `mc`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_module_lines_v`
--
DROP TABLE IF EXISTS `ct_module_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_module_lines_v` AS select `l`.`id` AS `id`,`l`.`module_id` AS `module_id`,`l`.`function_id` AS `function_id`,`l`.`sort` AS `sort`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by`,`h`.`module_name` AS `module_name`,`h`.`description` AS `module_desc`,`fn`.`function_name` AS `function_name`,`fn`.`description` AS `function_desc`,`h`.`sort` AS `module_sort`,`fn`.`controller` AS `controller`,`fn`.`action` AS `action`,`fn`.`display_flag` AS `display_flag`,`fn`.`display_class` AS `function_display_class`,`h`.`display_class` AS `module_display_class` from ((`ct_module_header` `h` join `ct_module_lines` `l`) join `ct_functions` `fn`) where ((`l`.`module_id` = `h`.`id`) and (`l`.`function_id` = `fn`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_order_addfiles_v`
--
DROP TABLE IF EXISTS `ct_order_addfiles_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_order_addfiles_v` AS select `oa`.`id` AS `id`,`oa`.`order_id` AS `order_id`,`oa`.`created_by` AS `created_by`,`oa`.`creation_date` AS `creation_date`,`oa`.`last_update_date` AS `last_update_date`,`oa`.`last_updated_by` AS `last_updated_by`,`oa`.`file_id` AS `file_id`,`oa`.`description` AS `description`,`f`.`file_name` AS `file_name`,`f`.`full_path` AS `full_path` from (`ct_order_addfiles` `oa` join `ct_files` `f`) where (`f`.`id` = `oa`.`file_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_order_category_vl`
--
DROP TABLE IF EXISTS `ct_order_category_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_order_category_vl` AS select concat(`pl`.`segment_desc`,' : ',`cl`.`segment_desc`) AS `segment_desc`,`cl`.`segment_value` AS `segment_value` from ((`ct_valuelist_header` `c` join `ct_valuelist_lines` `cl`) join `ct_valuelist_lines` `pl`) where ((`cl`.`valuelist_id` = `c`.`id`) and (`c`.`valuelist_name` = 'vl_order_category') and (`pl`.`segment_value` = `cl`.`parent_segment_value`) and (`pl`.`inactive_flag` = 0) and (`cl`.`inactive_flag` = 0));

-- --------------------------------------------------------

--
-- Structure for view `ct_order_logs_v`
--
DROP TABLE IF EXISTS `ct_order_logs_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_order_logs_v` AS select `ol`.`id` AS `id`,`ol`.`order_id` AS `order_id`,`ol`.`log_type` AS `log_type`,`ol`.`new_value` AS `new_value`,`ol`.`old_value` AS `old_value`,`ol`.`reason` AS `reason`,`ol`.`change_hash` AS `change_hash`,`ol`.`creation_date` AS `creation_date`,`ol`.`created_by` AS `created_by`,`ol`.`last_update_date` AS `last_update_date`,`ol`.`last_updated_by` AS `last_updated_by`,`olt`.`description` AS `description`,`olt`.`title` AS `title`,`olt`.`content` AS `content`,`olt`.`need_reason_flag` AS `need_reason_flag`,`olt`.`field_name` AS `field_name`,`olt`.`dll_type` AS `dll_type`,`olt`.`notice_flag` AS `notice_flag`,`olt`.`field_valuelist_id` AS `field_valuelist_id` from (`ct_order_logs` `ol` join `ct_order_log_types` `olt`) where (`olt`.`log_type` = `ol`.`log_type`);

-- --------------------------------------------------------

--
-- Structure for view `ct_order_meetings_v`
--
DROP TABLE IF EXISTS `ct_order_meetings_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_order_meetings_v` AS select `m`.`id` AS `id`,`m`.`title` AS `title`,`m`.`start_date` AS `start_date`,`m`.`end_date` AS `end_date`,`m`.`site` AS `site`,`m`.`anchor` AS `anchor`,`m`.`recorder` AS `recorder`,`m`.`actor` AS `actor`,`m`.`discuss` AS `discuss`,`m`.`cancel_reason` AS `cancel_reason`,`m`.`cancel_remark` AS `cancel_remark`,`m`.`created_by` AS `created_by`,`m`.`creation_date` AS `creation_date`,`m`.`last_update_date` AS `last_update_date`,`m`.`last_updated_by` AS `last_updated_by`,`m`.`inactive_flag` AS `inactive_flag`,`om`.`order_id` AS `order_id`,`o`.`title` AS `order_title` from ((`ct_meetings` `m` join `ct_order_meetings` `om`) join `ct_orders` `o`) where ((`m`.`id` = `om`.`meeting_id`) and (`o`.`id` = `om`.`order_id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_order_status_vl`
--
DROP TABLE IF EXISTS `ct_order_status_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_order_status_vl` AS select `l`.`id` AS `id`,`l`.`status_id` AS `status_id`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc`,`l`.`next_status` AS `next_status`,`l`.`back_status` AS `back_status`,`l`.`default_flag` AS `default_flag`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by` from (`ct_status_header` `h` join `ct_status_lines` `l`) where ((`h`.`id` = `l`.`status_id`) and (`h`.`status_code` = 'order_status'));

-- --------------------------------------------------------

--
-- Structure for view `ct_role_module_lines_v`
--
DROP TABLE IF EXISTS `ct_role_module_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_role_module_lines_v` AS select `l`.`id` AS `role_module_line_id`,`l`.`role_id` AS `role_id`,`ml`.`id` AS `id`,`ml`.`module_id` AS `module_id`,`ml`.`function_id` AS `function_id`,`ml`.`sort` AS `sort`,`ml`.`creation_date` AS `creation_date`,`ml`.`created_by` AS `created_by`,`ml`.`last_update_date` AS `last_update_date`,`ml`.`last_updated_by` AS `last_updated_by`,`ml`.`module_name` AS `module_name`,`ml`.`module_desc` AS `module_desc`,`ml`.`function_name` AS `function_name`,`ml`.`function_desc` AS `function_desc`,`ml`.`module_sort` AS `module_sort`,`ml`.`controller` AS `controller`,`ml`.`action` AS `action`,`ml`.`display_flag` AS `display_flag`,`ml`.`function_display_class` AS `function_display_class`,`ml`.`module_display_class` AS `module_display_class` from (`ct_role_module_lines` `l` join `ct_module_lines_v` `ml`) where (`l`.`module_line_id` = `ml`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_role_profile_lines_v`
--
DROP TABLE IF EXISTS `ct_role_profile_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_role_profile_lines_v` AS select `rp`.`role_id` AS `role_id`,`rpl`.`id` AS `id`,`rpl`.`profile_id` AS `profile_id`,`rpl`.`object_line_id` AS `object_line_id`,`rpl`.`auth_value` AS `auth_value`,`rpl`.`creation_date` AS `creation_date`,`rpl`.`created_by` AS `created_by`,`rpl`.`last_update_date` AS `last_update_date`,`rpl`.`last_updated_by` AS `last_updated_by`,`vl`.`valuelist_name` AS `auth_item_name`,`vl`.`description` AS `auth_item_desc`,`obj`.`object_name` AS `object_name`,`obj`.`description` AS `object_desc`,`rp`.`object_id` AS `object_id` from ((((`ct_role_profile_lines` `rpl` join `ct_authobj_lines` `al`) join `ct_role_profiles` `rp`) join `ct_valuelist_header` `vl`) join `ct_authority_objects` `obj`) where ((`rpl`.`object_line_id` = `al`.`id`) and (`al`.`valuelist_id` = `vl`.`id`) and (`rpl`.`profile_id` = `rp`.`id`) and (`rp`.`object_id` = `obj`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_status_lines_v`
--
DROP TABLE IF EXISTS `ct_status_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_status_lines_v` AS select `h`.`status_code` AS `status_code`,`h`.`description` AS `description`,`l`.`id` AS `id`,`l`.`status_id` AS `status_id`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc`,`l`.`next_status` AS `next_status`,`l`.`back_status` AS `back_status`,`l`.`default_flag` AS `default_flag`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by`,`l`.`default_next_status` AS `default_next_status` from (`ct_status_header` `h` join `ct_status_lines` `l`) where (`h`.`id` = `l`.`status_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_user_auth_v`
--
DROP TABLE IF EXISTS `ct_user_auth_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_user_auth_v` AS select `ur`.`role_id` AS `role_id`,`ao`.`object_name` AS `object_name`,`ao`.`description` AS `description`,`ur`.`user_id` AS `user_id`,`rp`.`id` AS `profile_id`,`u`.`id` AS `id`,`u`.`username` AS `username`,`u`.`password` AS `password`,`u`.`contact` AS `contact`,`u`.`email` AS `email`,`u`.`phone_number` AS `phone_number`,`u`.`mobile_telephone` AS `mobile_telephone`,`u`.`address` AS `address`,`u`.`full_name` AS `full_name`,`u`.`inactive_flag` AS `inactive_flag`,`u`.`email_flag` AS `email_flag`,`u`.`sms_flag` AS `sms_flag`,`u`.`initial_pass_flag` AS `initial_pass_flag`,`u`.`created_by` AS `created_by`,`u`.`creation_date` AS `creation_date`,`u`.`last_update_date` AS `last_update_date`,`u`.`last_updated_by` AS `last_updated_by` from (((`ct_user_roles` `ur` join `ct_role_profiles` `rp`) join `ct_authority_objects` `ao`) join `ct_users` `u`) where ((`ur`.`role_id` = `rp`.`role_id`) and (`rp`.`object_id` = `ao`.`id`) and (`u`.`id` = `ur`.`user_id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_user_functions_v`
--
DROP TABLE IF EXISTS `ct_user_functions_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_user_functions_v` AS select `mlv`.`role_module_line_id` AS `role_module_line_id`,`mlv`.`controller` AS `controller`,`mlv`.`action` AS `action`,`mlv`.`role_id` AS `role_id`,`mlv`.`id` AS `id`,`mlv`.`module_id` AS `module_id`,`mlv`.`function_id` AS `function_id`,`mlv`.`sort` AS `sort`,`mlv`.`creation_date` AS `creation_date`,`mlv`.`created_by` AS `created_by`,`mlv`.`last_update_date` AS `last_update_date`,`mlv`.`last_updated_by` AS `last_updated_by`,`mlv`.`module_name` AS `module_name`,`mlv`.`module_desc` AS `module_desc`,`mlv`.`function_name` AS `function_name`,`mlv`.`function_desc` AS `function_desc`,`ur`.`user_id` AS `user_id`,`mlv`.`module_sort` AS `module_sort`,`mlv`.`display_flag` AS `display_flag`,`mlv`.`function_display_class` AS `function_display_class`,`mlv`.`module_display_class` AS `module_display_class` from (`ct_role_module_lines_v` `mlv` join `ct_user_roles` `ur`) where (`ur`.`role_id` = `mlv`.`role_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_valuelist_lines_v`
--
DROP TABLE IF EXISTS `ct_valuelist_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_valuelist_lines_v` AS select `h`.`valuelist_name` AS `valuelist_name`,`h`.`description` AS `description`,`h`.`from_obj` AS `from_obj`,`h`.`label_fieldname` AS `label_fieldname`,`h`.`value_fieldname` AS `value_fieldname`,`h`.`source_view` AS `source_view`,`h`.`condition` AS `condition`,`h`.`parent_id` AS `parent_id`,`l`.`id` AS `id`,`l`.`valuelist_id` AS `valuelist_id`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc`,`l`.`inactive_flag` AS `inactive_flag`,`l`.`sort` AS `sort`,`l`.`parent_segment_value` AS `parent_segment`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by` from (`ct_valuelist_header` `h` join `ct_valuelist_lines` `l`) where (`h`.`id` = `l`.`valuelist_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_valuelist_vl`
--
DROP TABLE IF EXISTS `ct_valuelist_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_valuelist_vl` AS select `h`.`valuelist_name` AS `valuelist_name`,`h`.`description` AS `valuelist_desc`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc` from (`ct_valuelist_header` `h` join `ct_valuelist_lines` `l`) where ((`l`.`valuelist_id` = `h`.`id`) and (`l`.`inactive_flag` = 0));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
