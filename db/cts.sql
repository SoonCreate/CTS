-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2014 at 04:35 PM
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
  `valuelist_id` int(11) NOT NULL COMMENT '项目值集',
  `default_value` text NOT NULL COMMENT '默认值',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`object_id`,`valuelist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限对象明细表' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ct_authobj_lines`
--

INSERT INTO `ct_authobj_lines` (`id`, `object_id`, `valuelist_id`, `default_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(3, 1, 9, 'customer', NULL, NULL, 1412991465, 44),
(4, 1, 6, 'all', NULL, NULL, NULL, NULL),
(5, 1, 8, 'all', NULL, NULL, NULL, NULL),
(6, 2, 11, 'TRUE', NULL, NULL, NULL, NULL),
(7, 3, 25, 'all', NULL, NULL, NULL, NULL),
(8, 4, 11, 'TRUE', NULL, NULL, NULL, NULL),
(11, 4, 25, 'all', 1412992687, 44, 1413520681, 44);

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
  `object_name` varchar(20) NOT NULL COMMENT '权限对象名称',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object_name` (`object_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限对象表' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ct_authority_objects`
--

INSERT INTO `ct_authority_objects` (`id`, `object_name`, `description`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'category_control', '订单控制权限对象', NULL, NULL, 1413516417, 44),
(2, 'only_mine_control', '只能自己的订单', 1412066866, -1, 1412066866, -1),
(3, 'log_display_control', '订单日志类型显示控制', 1412928745, 44, 1412928745, 44),
(4, 'log_display_fullname', '日志显示操作人', 1412937910, 44, 1413516478, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_configs`
--

CREATE TABLE IF NOT EXISTS `ct_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(20) NOT NULL COMMENT '配置名称',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `config_value` varchar(255) NOT NULL COMMENT '配置值',
  `editable_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可被前台编辑',
  `data_type` varchar(20) NOT NULL DEFAULT 'string' COMMENT '数据类型',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_name` (`config_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统配置表' AUTO_INCREMENT=38 ;

--
-- Dumping data for table `ct_configs`
--

INSERT INTO `ct_configs` (`id`, `config_name`, `description`, `config_value`, `editable_flag`, `data_type`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'company_name', '公司名称', '浙江天正集团', 1, 'string', NULL, NULL, 1413637551, 44),
(2, 'logo_file', 'Logo文件路径', '1', 1, 'string', NULL, NULL, NULL, NULL),
(3, 'upload_path', '文件上传路径。该路径必须是可写的，相对路径和绝对路径均可以。', 'resources/uploads', 0, 'string', NULL, NULL, NULL, NULL),
(4, 'category_control', '投诉订单分类功能开关', 'TRUE', 1, 'boolean', NULL, NULL, 1413338754, 44),
(5, 'all_values', '包含所有值', 'all', 0, 'string', NULL, NULL, NULL, NULL),
(6, 'alarm_period', '报警周期，每次报警的时间间隔，单位为小时', '24', 1, 'number', NULL, NULL, NULL, NULL),
(7, 'mail_protocol', 'mail, sendmail, or smtp 邮件发送协议', 'smtp', 1, 'string', NULL, NULL, NULL, NULL),
(8, 'sendmail_path', '服务器上 Sendmail 的实际路径。protocol 为 sendmail 时使用', '/usr/sbin/sendmail', 1, 'string', NULL, NULL, NULL, NULL),
(9, 'smtp_host', 'SMTP 服务器地址', 'smtp.ym.163.com', 1, 'string', NULL, NULL, NULL, NULL),
(10, 'smtp_user', 'SMTP 用户账号', 'yacole@sooncreate.com', 1, 'string', NULL, NULL, NULL, NULL),
(11, 'smtp_pass', 'SMTP 密码', '325604', 1, 'string', NULL, NULL, NULL, NULL),
(12, 'smtp_port', 'SMTP 端口', '25', 1, 'number', NULL, NULL, NULL, NULL),
(13, 'smtp_timeout', 'SMTP 超时设置(单位：秒)', '5', 1, 'number', NULL, NULL, NULL, NULL),
(14, 'mail_wordwrap', 'TRUE 或 FALSE (布尔值)	MAIL开启自动换行', 'TRUE', 1, 'boolean', NULL, NULL, NULL, NULL),
(15, 'mail_wrapchars', '自动换行时每行的最大字符数', '76', 1, 'number', NULL, NULL, NULL, NULL),
(16, 'mail_content_type', 'text 或 html	邮件类型。发送 HTML 邮件比如是完整的网页。请确认网页中是否有相对路径的链接和图片地址，它们在邮件中不能正确显示。', 'html', 1, 'string', NULL, NULL, NULL, NULL),
(17, 'mail_charset', '字符集(utf-8, iso-8859-1 等)', 'utf-8', 1, 'string', NULL, NULL, NULL, NULL),
(18, 'mail_validate', 'TRUE 或 FALSE (布尔值)	是否验证邮件地址', 'FALSE', 1, 'boolean', NULL, NULL, NULL, NULL),
(19, 'mail_newline', '"\\r\\n" or "\\n" or "\\r"	换行符. (使用 "\\r\\n" to 以遵守RFC 822).', '\\n', 1, 'string', NULL, NULL, NULL, NULL),
(20, 'bcc_batch_mode', 'TRUE or FALSE (boolean)	启用批量暗送模式', 'FALSE', 1, 'boolean', NULL, NULL, NULL, NULL),
(21, 'bcc_batch_size', '批量暗送的邮件数', '200', 1, 'number', NULL, NULL, NULL, NULL),
(22, 'mail_from', '邮件默认来自于，如果是smtp方式，必须同smtp_user', 'yacole@sooncreate.com', 1, 'string', NULL, NULL, NULL, NULL),
(23, 'mail_from_name', '邮件来自，名称用于显示自动邮件的发件人姓名', '系统管理员', 1, 'string', NULL, NULL, NULL, NULL),
(24, 'site_url', '网站地址', 'localhost', 1, 'string', NULL, NULL, NULL, NULL),
(25, 'initial_password', '系统用户初始密码', '123456', 1, 'string', NULL, NULL, NULL, NULL),
(26, 'upload_allowed_types', '允许上传文件的MIME类型；通常文件扩展名可以做为MIME类型. 允许多个类型用竖线‘|’分开', 'gif|jpg|png|pdf|doc|docx|xls|xlsx', 1, 'string', NULL, NULL, NULL, NULL),
(27, 'upload_overwrite', '是否覆盖。该参数为TRUE时，如果上传文件时碰到重名文件，将会把原文件覆盖；如果该参数为FALSE，上传文件重名时，CI将会在新文件的文件名后面加一个数字。', 'FALSE', 1, 'boolean', NULL, NULL, NULL, NULL),
(28, 'upload_max_size', '允许上传文件大小的最大值（以K为单位）。该参数为0则不限制。注意：通常PHP也有这项限制，可以在php.ini文件中指定。通常默认为2MB。', '200', 1, 'number', NULL, NULL, NULL, NULL),
(29, 'upload_max_width', '上传文件的宽度最大值（像素为单位）。0为不限制。', '1024', 1, 'number', NULL, NULL, NULL, NULL),
(30, 'upload_max_height', '上传文件的高度最大值（像素为单位）。0为不限制。', '768', 1, 'number', NULL, NULL, NULL, NULL),
(31, 'upload_max_filename', '文件名的最大长度。0为不限制。', '0', 1, 'number', NULL, NULL, NULL, NULL),
(32, 'upload_encrypt_name', '是否重命名文件。如果该参数为TRUE，上传的文件将被重命名为随机的加密字符串。当你想让文件上传者也不能区分自己上传的文件的文件名时，是非常有用的。当 overwrite 为 FALSE 时，此选项才起作用。', 'TRUE', 1, 'boolean', NULL, NULL, NULL, NULL),
(33, 'upload_remove_spaces', '参数为TRUE时，文件名中的空格将被替换为下划线。推荐使用。', 'TRUE', 1, 'boolean', NULL, NULL, NULL, NULL),
(34, 'status_for_lock', '在此状态下，订单被锁定，无法操作', 'closed', 1, 'string', NULL, NULL, NULL, NULL),
(35, 'word_truncate', '文字截断默认长度', '100', 1, 'number', NULL, NULL, NULL, NULL),
(36, 'allow_register', '是否允许用户注册', 'TRUE', 1, 'boolean', NULL, NULL, NULL, NULL),
(37, 'feedback_star', '用户反馈的打分星数', '10', 1, 'number', NULL, NULL, 1413637565, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_feedbacks`
--

CREATE TABLE IF NOT EXISTS `ct_feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `content` text COMMENT '反馈意见内容',
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投诉单反馈表' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ct_feedbacks`
--

INSERT INTO `ct_feedbacks` (`id`, `order_id`, `content`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 101, '反馈测试1', 44, 1413625271, 1413626197, 44),
(2, 102, '', 44, 1413632623, 1413632623, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_feedback_stars`
--

CREATE TABLE IF NOT EXISTS `ct_feedback_stars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedback_id` int(11) NOT NULL,
  `feedback_type` varchar(20) NOT NULL COMMENT '反馈类型',
  `stars` int(1) NOT NULL DEFAULT '0' COMMENT '打分',
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `feedback_desc` varchar(255) NOT NULL COMMENT '类型描述',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`feedback_id`,`feedback_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投诉单反馈明细表' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ct_feedback_stars`
--

INSERT INTO `ct_feedback_stars` (`id`, `feedback_id`, `feedback_type`, `stars`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`, `feedback_desc`) VALUES
(1, 1, '10', 3, 44, 1413625271, 1413626197, 44, '响应速度'),
(2, 1, '20', 5, 44, 1413625271, 1413626197, 44, '服务态度'),
(3, 2, '10', 5, 44, 1413632623, 1413632623, 44, '响应速度'),
(4, 2, '20', 5, 44, 1413632623, 1413632623, 44, '服务态度');

-- --------------------------------------------------------

--
-- Table structure for table `ct_files`
--

CREATE TABLE IF NOT EXISTS `ct_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL COMMENT '已上传的文件名（包括扩展名）',
  `file_type` varchar(255) NOT NULL COMMENT '文件的Mime类型',
  `file_size` float DEFAULT NULL COMMENT '图像大小，单位是kb',
  `is_image` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是图像。 1 =是图像。 0 = 不是图像。',
  `file_path` varchar(255) DEFAULT NULL COMMENT '不包括文件名的文件绝对路径',
  `full_path` varchar(255) DEFAULT NULL COMMENT '包括文件名在内的文件绝对路径',
  `raw_name` varchar(100) DEFAULT NULL COMMENT '不包括扩展名在内的文件名部分',
  `orig_name` varchar(255) DEFAULT NULL COMMENT '上传的文件最初的文件名。这只有在设置上传文件重命名（encrypt_name）时才有效。',
  `client_name` varchar(100) DEFAULT NULL COMMENT '上传的文件在客户端的文件名。',
  `file_ext` varchar(45) DEFAULT NULL COMMENT '文件扩展名（包括‘.’）',
  `image_width` int(10) unsigned DEFAULT NULL COMMENT '图像宽度',
  `image_height` int(10) unsigned DEFAULT NULL COMMENT '图像高度',
  `image_type` varchar(45) DEFAULT NULL COMMENT '文件类型，即文件扩展名（不包括‘.’）',
  `image_size_str` varchar(255) DEFAULT NULL COMMENT '一个包含width和height的字符串。用于放在一个img标签里。',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='上传文件记录表' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ct_files`
--

INSERT INTO `ct_files` (`id`, `file_name`, `file_type`, `file_size`, `is_image`, `file_path`, `full_path`, `raw_name`, `orig_name`, `client_name`, `file_ext`, `image_width`, `image_height`, `image_type`, `image_size_str`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, '07849043460b9e3f5bf54b3dd5e69793.doc', 'application/msword', 40.5, 0, 'E:/xampp/htdocs/CTS/resources/uploads/', 'E:/xampp/htdocs/CTS/resources/uploads/07849043460b9e3f5bf54b3dd5e69793.doc', '07849043460b9e3f5bf54b3dd5e69793', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '.doc', 0, 0, '', '', 1412296792, 44, 1412296792, 44),
(2, 'f14237f81c80fbb22517a0cbb368d8ae.doc', 'application/msword', 40.5, 0, 'E:/xampp/htdocs/CTS/resources/uploads/', 'E:/xampp/htdocs/CTS/resources/uploads/f14237f81c80fbb22517a0cbb368d8ae.doc', 'f14237f81c80fbb22517a0cbb368d8ae', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '2014年第3季度专项计划检查(自查)记录表_陈杨阳.doc', '.doc', 0, 0, '', '', 1412316270, 44, 1412316270, 44),
(3, '86bfdf2b8c98f67fbccea33d8d26632c.jpg', 'image/jpeg', 20, 1, 'E:/xampp/htdocs/CTS/resources/uploads/', 'E:/xampp/htdocs/CTS/resources/uploads/86bfdf2b8c98f67fbccea33d8d26632c.jpg', '86bfdf2b8c98f67fbccea33d8d26632c', '11-b.jpg', '11-b.jpg', '.jpg', 175, 131, 'jpeg', 'width="175" height="131"', 1412391635, 44, 1412391635, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_functions`
--

CREATE TABLE IF NOT EXISTS `ct_functions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(100) NOT NULL COMMENT '功能名称',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `controller` varchar(255) NOT NULL COMMENT '控制器',
  `action` varchar(255) NOT NULL COMMENT '函数',
  `help` text COMMENT '帮助文档',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `display_flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `display_class` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `function_name` (`function_name`,`display_flag`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统功能信息表' AUTO_INCREMENT=21 ;

--
-- Dumping data for table `ct_functions`
--

INSERT INTO `ct_functions` (`id`, `function_name`, `description`, `controller`, `action`, `help`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`, `display_flag`, `display_class`) VALUES
(1, 'choose_create', '投诉订单创建', 'order', 'choose_create', NULL, 1412060589, -1, 1413512538, 44, 1, 'icon-globe'),
(3, 'user_index', '用户管理', 'user', 'index', NULL, 1412147486, 44, 1413334018, 44, 1, ''),
(5, 'my_orders', '投诉管理', 'order', 'index', NULL, 1413115571, 44, 1413115571, 44, 1, ''),
(6, 'user_edit', '用户信息', 'user', 'user_edit', NULL, 1413115703, 44, 1413115703, 44, 1, ''),
(7, 'my_notices', '我的消息', 'user', 'notices', NULL, 1413115821, 44, 1413115821, 44, 1, ''),
(8, 'change_password', '修改密码', 'user', 'change_password', NULL, 1413425007, 44, 1413463593, 44, 0, ''),
(9, 'valuelist_manage', '值集管理', 'valuelist', 'index', NULL, 1413425274, 44, 1413425274, 44, 1, ''),
(10, 'role_manage', '角色管理', 'role', 'index', NULL, 1413425363, 44, 1413425363, 44, 1, ''),
(11, 'module_manage', '模块管理', 'modules', 'index', NULL, 1413425386, 44, 1413425386, 44, 1, ''),
(12, 'function_manage', '功能管理', 'functions', 'index', NULL, 1413425406, 44, 1413425406, 44, 1, ''),
(13, 'ao_manage', '权限对象管理', 'auth_object', 'index', NULL, 1413425444, 44, 1413425444, 44, 1, ''),
(14, 'olt_manage', '订单日志类型管理', 'order_log_type', 'index', NULL, 1413425500, 44, 1413425500, 44, 1, ''),
(15, 'message_manage', '系统消息管理', 'messages', 'index', NULL, 1413425531, 44, 1413425531, 44, 1, ''),
(16, 'config_manage', '系统配置', 'configs', 'index', NULL, 1413425561, 44, 1413425561, 44, 1, ''),
(17, 'test', 'test', 'test', 'test', NULL, 1413512764, 44, 1413512764, 44, 1, ''),
(18, 'order_show', '投诉单显示', 'order', 'show', NULL, 1413543719, 44, 1413543719, 44, 0, ''),
(19, 'order_create', '投诉单创建', 'order', 'create', NULL, 1413543810, 44, 1413543810, 44, 0, ''),
(20, 'notice_show', '显示消息', 'user', 'notice_show', NULL, 1413544917, 44, 1413544917, 44, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ct_function_objects`
--

CREATE TABLE IF NOT EXISTS `ct_function_objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `function_id` int(10) unsigned NOT NULL COMMENT '功能ID',
  `object_id` int(10) unsigned NOT NULL COMMENT '权限对象ID',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='功能权限对象表' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ct_function_objects`
--

INSERT INTO `ct_function_objects` (`id`, `function_id`, `object_id`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(2, 1, 1, 44, 1413012134, 1413012134, 44),
(3, 1, 3, 44, 1413012476, 1413012476, 44),
(5, 17, 1, 44, 1413513944, 1413513944, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_function_objects_v`
--
CREATE TABLE IF NOT EXISTS `ct_function_objects_v` (
`id` int(10) unsigned
,`function_id` int(10) unsigned
,`object_id` int(10) unsigned
,`created_by` int(11)
,`creation_date` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`object_name` varchar(20)
,`description` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_function_obj_lines`
--

CREATE TABLE IF NOT EXISTS `ct_function_obj_lines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_line_id` int(10) unsigned NOT NULL,
  `fun_object_id` int(10) unsigned NOT NULL,
  `default_value` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`fun_object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='功能权限对象明细表' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ct_function_obj_lines`
--

INSERT INTO `ct_function_obj_lines` (`id`, `object_line_id`, `fun_object_id`, `default_value`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(4, 3, 2, 'vendor', 44, 1413012134, 1413012451, 44),
(5, 4, 2, 'all', 44, 1413012134, 1413012499, 44),
(6, 5, 2, 'all', 44, 1413012134, 1413012134, 44),
(7, 7, 3, 'manager_change', 44, 1413012476, 1413012489, 44),
(11, 3, 5, 'employee', 44, 1413513944, 1413514880, 44),
(12, 4, 5, 'all', 44, 1413513944, 1413513944, 44),
(13, 5, 5, 'all', 44, 1413513944, 1413513944, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_function_obj_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_function_obj_lines_v` (
`id` int(10) unsigned
,`object_line_id` int(10) unsigned
,`fun_object_id` int(10) unsigned
,`default_value` text
,`created_by` int(11)
,`creation_date` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`function_id` int(10) unsigned
,`object_id` int(10) unsigned
,`object_name` varchar(20)
,`object_desc` varchar(255)
,`valuelist_id` int(11)
,`auth_item_name` varchar(20)
,`auth_item_desc` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_meetings`
--

CREATE TABLE IF NOT EXISTS `ct_meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '会议主题',
  `start_date` int(10) unsigned NOT NULL COMMENT '开始时间',
  `end_date` int(10) unsigned NOT NULL COMMENT '结束时间',
  `site` varchar(100) NOT NULL COMMENT '会议地点',
  `anchor` varchar(45) NOT NULL COMMENT '主持人',
  `recorder` varchar(45) DEFAULT NULL COMMENT '记录人',
  `actor` varchar(255) NOT NULL COMMENT '参与者',
  `discuss` text COMMENT '会议决议',
  `cancel_reason` varchar(20) DEFAULT NULL COMMENT '取消原因',
  `cancel_remark` text COMMENT '备注',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(10) unsigned DEFAULT NULL,
  `last_update_date` int(10) unsigned DEFAULT NULL,
  `last_updated_by` int(10) unsigned DEFAULT NULL,
  `inactive_flag` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '失效标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会议信息表' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ct_meetings`
--

INSERT INTO `ct_meetings` (`id`, `title`, `start_date`, `end_date`, `site`, `anchor`, `recorder`, `actor`, `discuss`, `cancel_reason`, `cancel_remark`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`, `inactive_flag`) VALUES
(1, 'asdf', 1412265600, 1412265600, 'sdfasdf', 'asdfasdf', 'asdf', 'asdfasdf', 'asdfasdf', NULL, NULL, 44, 1412301790, 1412301790, 44, 0),
(2, 'asdfasdf', 1412352000, 1412352000, 'sadf', 'asdf', 'asdf', 'asdf', 'asdf', NULL, NULL, 44, 1412305995, 1412305995, 44, 0),
(3, 'asdf', 1412265600, 1412265600, 'ggg', 'gg', 'gg', 'gg', NULL, '10', '阿三东帆', 44, 1412309412, 1412313261, 44, 1),
(4, 'asdf', 1413561600, 1413561600, 'asfd', 'asd', 'asfd', 'aadsf', NULL, '10', '', 44, 1413611547, 1413614005, 44, 1),
(5, '第二次会议', 1413623400, 1413642600, '会议室一', '陈杨阳', '', '全部人员', NULL, NULL, NULL, 44, 1413615576, 1413616445, 44, 0),
(6, '会议三', 1413567900, 1413568800, '暗室逢灯', '暗室逢灯', '', '暗室逢灯', NULL, NULL, NULL, 44, 1413616500, 1413616500, 44, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ct_meeting_files`
--

CREATE TABLE IF NOT EXISTS `ct_meeting_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` int(10) unsigned NOT NULL,
  `file_id` int(10) unsigned NOT NULL,
  `description` varchar(255) NOT NULL COMMENT '文件描述',
  `created_by` int(10) unsigned DEFAULT NULL,
  `creation_date` int(10) unsigned DEFAULT NULL,
  `last_update_date` int(10) unsigned DEFAULT NULL,
  `last_updated_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会议文件记录表' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ct_meeting_files`
--

INSERT INTO `ct_meeting_files` (`id`, `meeting_id`, `file_id`, `description`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, 2, '会议纪要', 44, 1412316270, 1412316270, 44),
(2, 2, 3, 'asfd', 44, 1412391635, 1412391635, 44);

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
  `class_id` int(11) NOT NULL COMMENT '分类ID',
  `message_code` varchar(20) NOT NULL COMMENT '消息码',
  `content` varchar(255) NOT NULL COMMENT '消息内容',
  `language` varchar(20) NOT NULL DEFAULT 'zh-CN' COMMENT '语言环境',
  `help` text COMMENT '帮助文档',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_id` (`class_id`,`message_code`,`language`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统消息表' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ct_messages`
--

INSERT INTO `ct_messages` (`id`, `class_id`, `message_code`, `content`, `language`, `help`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(2, 3, '10', '数据库保存成功！', 'zh-CN', NULL, 1412917791, 44, 1412926006, 44),
(3, 4, '10', '系统未知错误，请联系管理员！', 'zh-CN', NULL, 1413091223, 44, 1413091223, 44),
(4, 3, '20', '数据库保存失败！', 'zh-CN', NULL, 1413094460, 44, 1413094460, 44),
(5, 4, '20', '没有操作权限，请联系系统管理员！', 'zh-CN', NULL, 1413094784, 44, 1413094784, 44);

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
,`language` varchar(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_message_classes`
--

CREATE TABLE IF NOT EXISTS `ct_message_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_code` varchar(20) NOT NULL COMMENT '分类码',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_code` (`class_code`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统消息分类表' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ct_message_classes`
--

INSERT INTO `ct_message_classes` (`id`, `class_code`, `description`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(3, 'db', '数据库操作相关消息', 1412917773, 44, 1412917773, 44),
(4, 'system', '系统消息类', 1413091179, 44, 1413091179, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_module_header`
--

CREATE TABLE IF NOT EXISTS `ct_module_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL COMMENT '模块名称',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `display_class` varchar(100) DEFAULT NULL COMMENT '抬头图标样式码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统模块信息表' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ct_module_header`
--

INSERT INTO `ct_module_header` (`id`, `module_name`, `description`, `sort`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`, `display_class`) VALUES
(3, 'system_manage', '系统管理', 98, 1412060859, -1, 1413429712, 44, 'icon-cogs'),
(4, 'user_center', '用户中心', 2, 1413076355, 44, 1413077216, 44, 'icon-user'),
(5, 'order_create', '发布问题', 0, 1413076497, 44, 1413508328, 44, 'icon-edit'),
(6, 'order_manage', '我的投诉', 1, 1413076525, 44, 1413077210, 44, 'icon-comments'),
(7, 'message_manage', '我的提醒', 3, 1413076578, 44, 1413077203, 44, 'icon-envelope'),
(10, 'test', 'test', 0, 1413510852, 44, 1413510852, 44, '');

-- --------------------------------------------------------

--
-- Table structure for table `ct_module_lines`
--

CREATE TABLE IF NOT EXISTS `ct_module_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL COMMENT '模块ID',
  `function_id` int(11) NOT NULL COMMENT '功能ID',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统模块明细表' AUTO_INCREMENT=45 ;

--
-- Dumping data for table `ct_module_lines`
--

INSERT INTO `ct_module_lines` (`id`, `module_id`, `function_id`, `sort`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(14, 3, 3, 0, 1412147498, 44, 1412147498, 44),
(18, 5, 1, 0, 1413076637, 44, 1413076637, 44),
(20, 7, 1, 0, 1413076650, 44, 1413076650, 44),
(22, 6, 5, 0, 1413115587, 44, 1413115587, 44),
(23, 4, 6, 0, 1413115730, 44, 1413115730, 44),
(24, 7, 7, 0, 1413115831, 44, 1413115831, 44),
(25, 4, 8, 0, 1413425202, 44, 1413425202, 44),
(34, 3, 16, 0, 1413425762, 44, 1413425762, 44),
(35, 10, 17, 0, 1413512768, 44, 1413512768, 44),
(36, 6, 18, 0, 1413543917, 44, 1413543917, 44),
(37, 5, 19, 0, 1413543926, 44, 1413543926, 44),
(38, 7, 20, 0, 1413544934, 44, 1413544934, 44),
(39, 3, 9, 0, 1413628063, 44, 1413628063, 44),
(40, 3, 10, 0, 1413628063, 44, 1413628063, 44),
(41, 3, 11, 0, 1413628063, 44, 1413628063, 44),
(42, 3, 12, 0, 1413628063, 44, 1413628063, 44),
(43, 3, 13, 0, 1413628063, 44, 1413628063, 44),
(44, 3, 14, 0, 1413628063, 44, 1413628063, 44);

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
-- Stand-in structure for view `ct_module_line_objects_v`
--
CREATE TABLE IF NOT EXISTS `ct_module_line_objects_v` (
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
,`object_id` int(10) unsigned
,`object_name` varchar(20)
,`object_desc` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_notices`
--

CREATE TABLE IF NOT EXISTS `ct_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_id` int(11) DEFAULT NULL,
  `read_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读',
  `content` text COMMENT '内容',
  `from_log` tinyint(1) NOT NULL DEFAULT '0' COMMENT '来自日志',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `received_by` int(11) NOT NULL COMMENT '接收人',
  `direct_url` varchar(255) DEFAULT NULL COMMENT '直接跳转至URL',
  `with_manager` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户通知信息表' AUTO_INCREMENT=161 ;

--
-- Dumping data for table `ct_notices`
--

INSERT INTO `ct_notices` (`id`, `log_id`, `read_flag`, `content`, `from_log`, `title`, `order_id`, `received_by`, `direct_url`, `with_manager`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 21, 0, '', 1, '', 1, 44, '', 1, 44, 1412149769, 1413630240, 44),
(2, 22, 0, '', 1, '', 2, 44, '', 1, 44, 1412150096, 1413630240, 44),
(6, 26, 0, '从confirmed 变成 released', 1, '投诉单3 状态有新的变化', 3, 44, '', 1, 44, 1412150362, 1413630240, 44),
(7, 27, 0, '从allocated 变成 confirmed', 1, '投诉单1 状态有新的变化', 1, 44, '', 1, 44, 1412216119, 1413630240, 44),
(8, 28, 0, '从done 变成 allocated', 1, '投诉单1 状态有新的变化', 1, 44, '', 1, 44, 1412227442, 1413630240, 44),
(9, 29, 0, '从closed 变成 done', 1, '投诉单1 状态有新的变化', 1, 44, '', 1, 44, 1412227657, 1413630240, 44),
(10, 30, 0, '从allocated 变成 confirmed', 1, '投诉单2 状态有新的变化', 2, 44, '', 1, 44, 1412227892, 1413630240, 44),
(11, 33, 0, '从已分配 变成 已分配', 1, '投诉单2 状态有新的变化', 2, 44, '', 1, 44, 1412228471, 1413630240, 44),
(12, 34, 0, '从已分配 变成 已分配', 1, '投诉单2 状态有新的变化', 2, 44, '', 1, 44, 1412228630, 1413630240, 44),
(13, 35, 0, '责任人从 44 变成 40', 1, '订单 2 责任人变更', 2, 44, '', 1, 44, 1412228630, 1413630240, 44),
(14, 36, 0, '责任人从 40 变成 1', 1, '订单 2 责任人变更', 2, 44, '', 1, 44, 1412228914, 1413630240, 44),
(15, 37, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 2 责任人变更', 2, 44, '', 1, 44, 1412232565, 1413630240, 44),
(16, 38, 0, '从已确认 变成 已分配', 1, '投诉单3 状态有新的变化', 3, 44, '', 1, 44, 1412232638, 1413630240, 44),
(17, 39, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 3 责任人变更', 3, 44, '', 1, 44, 1412232638, 1413630240, 44),
(18, 40, 0, '从已分配 变成 已解决', 1, '投诉单2 状态有新的变化', 2, 44, '', 1, 44, 1412232766, 1413630240, 44),
(19, 41, 0, '从已解决 变成 已关闭', 1, '投诉单2 状态有新的变化', 2, 44, '', 1, 44, 1412320728, 1413630240, 44),
(20, 42, 0, '从已关闭 变成 重新打开', 1, '投诉单2 状态有新的变化', 2, 44, '', 1, 44, 1412320737, 1413630240, 44),
(21, 43, 0, '从已提交 变成 已确认', 1, '投诉单5 状态有新的变化', 5, 44, '', 1, 44, 1412399511, 1413630240, 44),
(22, 44, 0, '从已确认 变成 已分配', 1, '投诉单5 状态有新的变化', 5, 44, '', 1, 44, 1412399578, 1413630240, 44),
(23, 45, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 5 责任人变更', 5, 44, '', 1, 44, 1412399578, 1413630240, 44),
(24, 46, 0, '从已分配 变成 已解决', 1, '投诉单5 状态有新的变化', 5, 44, '', 1, 44, 1412399669, 1413630240, 44),
(25, 47, 0, '从已解决 变成 已关闭', 1, '投诉单5 状态有新的变化', 5, 44, '', 1, 44, 1412399684, 1413630240, 44),
(26, 48, 0, '从已关闭 变成 重新打开', 1, '投诉单5 状态有新的变化', 5, 44, '', 1, 44, 1412399692, 1413630240, 44),
(27, 49, 0, '从已提交 变成 已确认', 1, '投诉单9 状态有新的变化', 9, 44, '', 1, 44, 1412407466, 1413630240, 44),
(28, 50, 0, '从已确认 变成 已分配', 1, '投诉单9 状态有新的变化', 9, 44, '', 1, 44, 1412407511, 1413630240, 44),
(29, 51, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 9 责任人变更', 9, 44, '', 1, 44, 1412407511, 1413630240, 44),
(30, 52, 0, '从已提交 变成 已确认', 1, '投诉单17 状态有新的变化', 17, 44, '', 1, 44, 1412407646, 1413630240, 44),
(31, 53, 0, '从已确认 变成 已分配', 1, '投诉单17 状态有新的变化', 17, 44, '', 1, 44, 1412407667, 1413630240, 44),
(32, 54, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 17 责任人变更', 17, 44, '', 1, 44, 1412407667, 1413630240, 44),
(33, 55, 0, '从已提交 变成 已确认', 1, '投诉单7 状态有新的变化', 7, 44, '', 1, 44, 1412407737, 1413630240, 44),
(34, 56, 0, '从已确认 变成 已分配', 1, '投诉单7 状态有新的变化', 7, 44, '', 1, 44, 1412407744, 1413630240, 44),
(35, 57, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 7 责任人变更', 7, 44, '', 1, 44, 1412407744, 1413630240, 44),
(36, 58, 0, '从已提交 变成 已确认', 1, '投诉单8 状态有新的变化', 8, 44, '', 1, 44, 1412407914, 1413630240, 44),
(37, 59, 0, '从已确认 变成 已分配', 1, '投诉单8 状态有新的变化', 8, 44, '', 1, 44, 1412407920, 1413630240, 44),
(38, 60, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 8 责任人变更', 8, 44, '', 1, 44, 1412407920, 1413630240, 44),
(39, 61, 0, '从已提交 变成 已确认', 1, '投诉单10 状态有新的变化', 10, 44, '', 1, 44, 1412408011, 1413630240, 44),
(40, 62, 0, '从已确认 变成 已分配', 1, '投诉单10 状态有新的变化', 10, 44, '', 1, 44, 1412408161, 1413630240, 44),
(41, 63, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 10 责任人变更', 10, 44, '', 1, 44, 1412408161, 1413630240, 44),
(42, 64, 0, '从重新打开 变成 已分配', 1, '投诉单2 状态有新的变化', 2, 44, '', 1, 44, 1412408787, 1413630240, 44),
(43, 65, 0, '计划完成时间变更从1407686400 改为 1407686400 ', 1, '订单$order_id 计划完成日期变更', 2, 44, '', 1, 44, 1412408787, 1413630240, 44),
(44, 66, 0, '计划完成时间变更从2014-08-11 00:00:00 改为 2014-08-11 00:30:00 ', 1, '订单$order_id 计划完成日期变更', 2, 44, '', 1, 44, 1412410328, 1413630240, 44),
(45, 67, 0, '从已提交 变成 已确认', 1, '投诉单4 状态有新的变化', 4, 44, '', 1, 44, 1412412631, 1413630240, 44),
(46, 68, 0, '责任人从 速创科技工作室1 变成 asdfsadf', 1, '订单 2 责任人变更', 2, 44, '', 1, 44, 1412412997, 1413630240, 44),
(47, 69, 0, '从已确认 变成 已分配', 1, '投诉单4 状态有新的变化', 4, 44, '', 1, 44, 1412415137, 1413630240, 44),
(48, 70, 0, '责任人从 未知 变成 速创科技工作室1', 1, '订单 4 责任人变更', 4, 44, '', 1, 44, 1412415138, 1413630240, 44),
(49, 71, 0, '计划完成时间变更从 改为 2014-09-10 00:00:00 ', 1, '订单$order_id 计划完成日期变更', 4, 44, '', 1, 44, 1412415138, 1413630240, 44),
(51, 73, 0, '责任人从 速创科技工作室1 变成 恭喜发财', 1, '订单 4 责任人变更', 4, 44, '', 1, 44, 1412415685, 1413630240, 44),
(52, 73, 0, '责任人从 速创科技工作室1 变成 恭喜发财', 1, '订单 4 责任人变更', 4, 66, '', 1, 44, 1412415686, 1412415686, 44),
(53, 74, 0, '从已分配 变成 已关闭', 1, '投诉单2 状态有新的变化', 2, 44, NULL, 1, 44, 1412732259, 1413630240, 44),
(54, 74, 0, '从已分配 变成 已关闭', 1, '投诉单2 状态有新的变化', 2, 66, NULL, 1, 44, 1412732259, 1412732259, 44),
(55, NULL, 0, NULL, 0, '关于投诉单2的反馈', 2, 44, 'http://localhost/cts/index.php/order/feedback?id=2', 0, 44, 1412732259, 1413630240, 44),
(56, 103, 0, 'content', 1, 'title', 65, 44, NULL, 1, 44, 1413531583, 1413630240, 44),
(57, 103, 0, 'content', 1, 'title', 65, 44, NULL, 1, 44, 1413531583, 1413630240, 44),
(58, 104, 0, 'content', 1, 'title', 66, 44, NULL, 1, 44, 1413531602, 1413630240, 44),
(59, 104, 0, 'content', 1, 'title', 66, 44, NULL, 1, 44, 1413531602, 1413630240, 44),
(60, 105, 0, 'content', 1, 'title', 67, 44, NULL, 1, 44, 1413531624, 1413630240, 44),
(61, 105, 0, 'content', 1, 'title', 67, 44, NULL, 1, 44, 1413531624, 1413630240, 44),
(62, 106, 0, 'content', 1, 'title', 68, 44, NULL, 1, 44, 1413531651, 1413630240, 44),
(63, 106, 0, 'content', 1, 'title', 68, 44, NULL, 1, 44, 1413531651, 1413630240, 44),
(64, 107, 0, 'content', 1, 'title', 69, 44, NULL, 1, 44, 1413531705, 1413630240, 44),
(65, 107, 0, 'content', 1, 'title', 69, 44, NULL, 1, 44, 1413531705, 1413630240, 44),
(66, 108, 0, 'content', 1, 'title', 70, 44, NULL, 1, 44, 1413531968, 1413630240, 44),
(67, 108, 0, 'content', 1, 'title', 70, 44, NULL, 1, 44, 1413531968, 1413630240, 44),
(68, 109, 0, 'content', 1, 'title', 71, 44, NULL, 1, 44, 1413532045, 1413630240, 44),
(69, 109, 0, 'content', 1, 'title', 71, 44, NULL, 1, 44, 1413532045, 1413630240, 44),
(70, 110, 0, '投诉单提交', 1, '投诉单72 状态有新的变化', 72, 44, NULL, 1, 44, 1413532174, 1413630240, 44),
(71, 110, 0, '投诉单提交', 1, '投诉单72 状态有新的变化', 72, 44, NULL, 1, 44, 1413532174, 1413630240, 44),
(72, 111, 0, '投诉单提交', 1, '投诉单73 状态有新的变化', 73, 44, NULL, 1, 44, 1413532233, 1413630240, 44),
(73, 111, 0, '投诉单提交', 1, '投诉单73 状态有新的变化', 73, 44, NULL, 1, 44, 1413532233, 1413630240, 44),
(80, 115, 0, '投诉单提交', 1, '投诉单77 状态有新的变化', 77, 44, NULL, 1, 44, 1413545424, 1413630240, 44),
(81, 115, 0, '投诉单提交', 1, '投诉单77 状态有新的变化', 77, 44, NULL, 1, 44, 1413545424, 1413630240, 44),
(82, 116, 0, '投诉单提交', 1, '投诉单78 状态有新的变化', 78, 44, NULL, 1, 44, 1413545651, 1413630240, 44),
(83, 116, 0, '投诉单提交', 1, '投诉单78 状态有新的变化', 78, 44, NULL, 1, 44, 1413545651, 1413630240, 44),
(84, 117, 0, '投诉单提交', 1, '投诉单79 状态有新的变化', 79, 44, NULL, 1, 44, 1413545690, 1413630240, 44),
(85, 117, 0, '投诉单提交', 1, '投诉单79 状态有新的变化', 79, 44, NULL, 1, 44, 1413545690, 1413630240, 44),
(86, 118, 0, '投诉单提交', 1, '投诉单80 状态有新的变化', 80, 44, NULL, 1, 44, 1413545846, 1413630240, 44),
(87, 118, 0, '投诉单提交', 1, '投诉单80 状态有新的变化', 80, 44, NULL, 1, 44, 1413545846, 1413630240, 44),
(88, 119, 0, '投诉单提交', 1, '投诉单81 状态有新的变化', 81, 44, NULL, 1, 44, 1413546023, 1413630240, 44),
(89, 119, 0, '投诉单提交', 1, '投诉单81 状态有新的变化', 81, 44, NULL, 1, 44, 1413546023, 1413630240, 44),
(90, 120, 0, '投诉单提交', 1, '投诉单82 状态有新的变化', 82, 44, NULL, 1, 44, 1413546035, 1413630240, 44),
(91, 120, 0, '投诉单提交', 1, '投诉单82 状态有新的变化', 82, 44, NULL, 1, 44, 1413546035, 1413630240, 44),
(92, 121, 0, '投诉单提交', 1, '投诉单83 状态有新的变化', 83, 44, NULL, 1, 44, 1413546112, 1413630240, 44),
(93, 121, 0, '投诉单提交', 1, '投诉单83 状态有新的变化', 83, 44, NULL, 1, 44, 1413546112, 1413630240, 44),
(94, 122, 0, '投诉单提交', 1, '投诉单84 状态有新的变化', 84, 44, NULL, 1, 44, 1413546149, 1413630240, 44),
(95, 122, 0, '投诉单提交', 1, '投诉单84 状态有新的变化', 84, 44, NULL, 1, 44, 1413546149, 1413630240, 44),
(96, 123, 0, '投诉单提交', 1, '投诉单85 状态有新的变化', 85, 44, NULL, 1, 44, 1413546302, 1413630240, 44),
(97, 123, 0, '投诉单提交', 1, '投诉单85 状态有新的变化', 85, 44, NULL, 1, 44, 1413546302, 1413630240, 44),
(98, 124, 0, '投诉单提交', 1, '投诉单86 状态有新的变化', 86, 44, NULL, 1, 44, 1413546327, 1413630240, 44),
(99, 124, 0, '投诉单提交', 1, '投诉单86 状态有新的变化', 86, 44, NULL, 1, 44, 1413546327, 1413630240, 44),
(100, 125, 0, '投诉单提交', 1, '投诉单87 状态有新的变化', 87, 44, NULL, 1, 44, 1413546466, 1413630240, 44),
(101, 125, 0, '投诉单提交', 1, '投诉单87 状态有新的变化', 87, 44, NULL, 1, 44, 1413546466, 1413630240, 44),
(102, 126, 0, '投诉单提交', 1, '投诉单88 状态有新的变化', 88, 44, NULL, 1, 44, 1413547082, 1413630240, 44),
(103, 126, 0, '投诉单提交', 1, '投诉单88 状态有新的变化', 88, 44, NULL, 1, 44, 1413547082, 1413630240, 44),
(104, 127, 0, '投诉单提交', 1, '投诉单89 状态有新的变化', 89, 44, NULL, 1, 44, 1413547106, 1413630240, 44),
(105, 127, 0, '投诉单提交', 1, '投诉单89 状态有新的变化', 89, 44, NULL, 1, 44, 1413547106, 1413630240, 44),
(106, 128, 0, '投诉单提交', 1, '投诉单90 状态有新的变化', 90, 44, NULL, 1, 44, 1413547147, 1413630240, 44),
(107, 128, 0, '投诉单提交', 1, '投诉单90 状态有新的变化', 90, 44, NULL, 1, 44, 1413547147, 1413630240, 44),
(108, 134, 0, '责任人从 未知 变成 速创科技工作室', 1, '订单 90 责任人变更', 90, 44, NULL, 1, 44, 1413548938, 1413630240, 44),
(109, 135, 0, '计划完成时间变更从 改为 1970-01-01 08:00:00 ', 1, '订单90 计划完成日期变更', 90, 44, NULL, 1, 44, 1413548938, 1413630240, 44),
(110, 138, 0, '责任人从 速创科技工作室 变成 速创科技工作室', 1, '订单 90 责任人变更', 90, 44, NULL, 1, 44, 1413550556, 1413630240, 44),
(111, 138, 0, '责任人从 速创科技工作室 变成 速创科技工作室', 1, '订单 90 责任人变更', 90, 44, NULL, 1, 44, 1413550556, 1413630240, 44),
(112, 139, 0, '计划完成时间变更从1970-01-01 08:00:00 改为 2014-10-17 00:00:00 ', 1, '订单90 计划完成日期变更', 90, 44, NULL, 1, 44, 1413550556, 1413630240, 44),
(113, 139, 0, '计划完成时间变更从1970-01-01 08:00:00 改为 2014-10-17 00:00:00 ', 1, '订单90 计划完成日期变更', 90, 44, NULL, 1, 44, 1413550556, 1413630240, 44),
(114, 141, 0, '计划完成时间变更从2014-10-17 00:00:00 改为 2014-10-18 00:00:00 ', 1, '订单90 计划完成日期变更', 90, 44, NULL, 1, 44, 1413550974, 1413630240, 44),
(115, 141, 0, '计划完成时间变更从2014-10-17 00:00:00 改为 2014-10-18 00:00:00 ', 1, '订单90 计划完成日期变更', 90, 44, NULL, 1, 44, 1413550974, 1413630240, 44),
(116, 142, 0, '计划完成时间变更从2014-10-18 00:00:00 改为 2014-10-17 00:00:00 ', 1, '订单90 计划完成日期变更', 90, 44, NULL, 1, 44, 1413551190, 1413630240, 44),
(117, 142, 0, '计划完成时间变更从2014-10-18 00:00:00 改为 2014-10-17 00:00:00 ', 1, '订单90 计划完成日期变更', 90, 44, NULL, 1, 44, 1413551190, 1413630240, 44),
(118, 143, 0, '投诉单状态： 已分配 => 已解决 ', 1, '投诉单90 已解决', 90, 44, NULL, 1, 44, 1413551407, 1413630240, 44),
(119, NULL, 0, NULL, 0, '关于投诉单90的反馈', 90, 44, 'http://localhost/cts/index.php/order/feedback?id=90', 0, 44, 1413551443, 1413630240, 44),
(120, 148, 0, '投诉单状态： 已关闭 => 重新打开 ', 1, '投诉单90被重新打开', 90, 44, NULL, 1, 44, 1413552179, 1413630240, 44),
(121, 148, 0, '投诉单状态： 已关闭 => 重新打开 ', 1, '投诉单90被重新打开', 90, 44, NULL, 1, 44, 1413552179, 1413630240, 44),
(122, 148, 0, '投诉单状态： 已关闭 => 重新打开 ', 1, '投诉单90被重新打开', 90, 44, NULL, 1, 44, 1413552179, 1413630240, 44),
(123, NULL, 0, NULL, 0, '关于投诉单90的反馈', 90, 44, 'http://localhost/cts/index.php/order/feedback?id=90', 0, 44, 1413552345, 1413630240, 44),
(124, 151, 0, '责任人从 未知 变成 速创科技工作室', 1, '订单 86 责任人变更', 86, 44, NULL, 1, 44, 1413554326, 1413630240, 44),
(125, 152, 0, '计划完成时间变更从 改为 2014-10-17 00:00:00 ', 1, '订单86 计划完成日期变更', 86, 44, NULL, 1, 44, 1413554326, 1413630240, 44),
(126, 153, 0, '投诉单状态： 已分配 => 已解决 ', 1, '投诉单86 已解决', 86, 44, NULL, 1, 44, 1413554385, 1413630240, 44),
(127, NULL, 0, NULL, 0, '关于投诉单86的反馈', 86, 44, 'http://localhost/cts/index.php/order/feedback?id=86', 0, 44, 1413554392, 1413630240, 44),
(128, 154, 0, '投诉单状态： 已关闭 => 重新打开 ', 1, '投诉单86被重新打开', 86, 44, NULL, 1, 44, 1413554428, 1413630240, 44),
(129, 154, 0, '投诉单状态： 已关闭 => 重新打开 ', 1, '投诉单86被重新打开', 86, 44, NULL, 1, 44, 1413554428, 1413630240, 44),
(130, 154, 0, '投诉单状态： 已关闭 => 重新打开 ', 1, '投诉单86被重新打开', 86, 44, NULL, 1, 44, 1413554428, 1413630240, 44),
(131, NULL, 0, NULL, 0, '关于投诉单86的反馈', 86, 44, 'http://localhost/cts/index.php/order/feedback?id=86', 0, 44, 1413554629, 1413630240, 44),
(132, NULL, 0, NULL, 0, '关于投诉单89的反馈', 89, 44, 'http://localhost/cts/index.php/order/feedback?id=89', 0, 44, 1413555683, 1413630240, 44),
(133, 161, 0, '投诉单提交', 1, '投诉单 97 提交', 97, 44, NULL, 1, 44, 1413559897, 1413630240, 44),
(134, 161, 0, '投诉单提交', 1, '投诉单 97 提交', 97, 44, NULL, 1, 44, 1413559897, 1413630240, 44),
(135, 162, 0, '投诉单提交', 1, '投诉单 98 提交', 98, 44, NULL, 1, 44, 1413559928, 1413630240, 44),
(136, 162, 0, '投诉单提交', 1, '投诉单 98 提交', 98, 44, NULL, 1, 44, 1413559928, 1413630240, 44),
(137, 168, 0, '投诉单提交', 1, '投诉单 99 提交', 99, 44, NULL, 1, 44, 1413560227, 1413630240, 44),
(138, 168, 0, '投诉单提交', 1, '投诉单 99 提交', 99, 44, NULL, 1, 44, 1413560227, 1413630240, 44),
(139, 169, 0, '投诉单提交', 1, '投诉单 100 提交', 100, 44, NULL, 1, 44, 1413562846, 1413630240, 44),
(140, 170, 0, '投诉单提交', 1, '投诉单 101 提交', 101, 44, NULL, 1, 44, 1413562875, 1413630240, 44),
(141, 172, 0, '责任人从 未知 变成 高哨', 1, '订单 101 责任人变更', 101, 47, NULL, 1, 44, 1413562963, 1413562963, 44),
(142, 174, 0, '已确认 => 已分配', 1, '投诉单 101状态更新', 101, 47, NULL, 1, 44, 1413562963, 1413562963, 44),
(143, 175, 0, '责任人从 高哨 变成 速创科技工作室', 1, '订单 101 责任人变更', 101, 47, NULL, 1, 44, 1413563071, 1413563071, 44),
(144, 175, 0, '责任人从 高哨 变成 速创科技工作室', 1, '订单 101 责任人变更', 101, 44, NULL, 1, 44, 1413563071, 1413630240, 44),
(145, 179, 0, '已解决 => 已关闭', 1, '投诉单 101状态更新', 101, 44, NULL, 1, 44, 1413563623, 1413630240, 44),
(146, NULL, 0, NULL, 0, '关于投诉单101的反馈', 101, 44, 'http://localhost/cts/index.php/order/feedback?id=101', 0, 44, 1413563623, 1413630240, 44),
(147, 180, 0, '已关闭 => 重新打开', 1, '投诉单 101状态更新', 101, 44, NULL, 1, 44, 1413563650, 1413630240, 44),
(148, 180, 0, '已关闭 => 重新打开', 1, '投诉单 101状态更新', 101, 44, NULL, 1, 44, 1413563650, 1413630240, 44),
(149, 181, 0, '投诉单提交', 1, '投诉单 102 提交', 102, 44, NULL, 1, 44, 1413563758, 1413630240, 44),
(150, 183, 0, '责任人从 未知 变成 速创科技工作室', 1, '投诉单 102 责任人变更', 102, 44, NULL, 1, 44, 1413563776, 1413630240, 44),
(151, 185, 0, '已确认 => 已分配', 1, '投诉单 102状态更新', 102, 44, NULL, 1, 44, 1413563776, 1413630240, 44),
(152, 186, 1, '已分配 => 已解决', 1, '投诉单 102状态更新', 102, 44, NULL, 1, 44, 1413563825, 1413640049, 44),
(153, 188, 1, '责任人从 未知 变成 速创科技工作室', 1, '投诉单 99 责任人变更', 99, 44, NULL, 1, 44, 1413563855, 1413637875, 44),
(154, 190, 1, '已确认 => 已分配', 1, '投诉单 99状态更新', 99, 44, NULL, 1, 44, 1413563855, 1413641945, 44),
(155, 191, 1, '已解决 => 已关闭', 1, '投诉单 102状态更新', 102, 44, NULL, 1, 44, 1413617064, 1413638084, 44),
(156, NULL, 1, NULL, 0, '关于投诉单102的反馈', 102, 44, 'http://localhost/cts/index.php/order/feedback?id=102', 0, 44, 1413617064, 1413637834, 44),
(157, 192, 1, '重新打开 => 已关闭', 1, '投诉单 101状态更新', 101, 44, NULL, 1, 44, 1413625258, 1413637829, 44),
(158, NULL, 1, NULL, 0, '关于投诉单101的反馈', 101, 44, 'http://localhost/cts/index.php/order/feedback?id=101', 0, 44, 1413625258, 1413637577, 44),
(159, 193, 1, '投诉单提交', 1, '投诉单 103 提交', 103, 44, NULL, 1, 44, 1413641795, 1413641826, 44),
(160, 194, 0, '投诉单提交', 1, '投诉单 104 提交', 104, 44, NULL, 1, 44, 1413641971, 1413641971, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_notice_rules`
--

CREATE TABLE IF NOT EXISTS `ct_notice_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type_id` int(11) NOT NULL COMMENT '订单日志类型',
  `description` varchar(255) NOT NULL,
  `notice_created_by` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '创建者',
  `notice_manager` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '责任人',
  `when_new_value` varchar(255) NOT NULL COMMENT '当新值为',
  `when_old_value` varchar(255) NOT NULL COMMENT '当旧值为',
  `default_role_id` int(10) unsigned DEFAULT NULL COMMENT '默认角色ID',
  `inactive_flag` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '失效标识',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`log_type_id`,`inactive_flag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='通知规则信息' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ct_notice_rules`
--

INSERT INTO `ct_notice_rules` (`id`, `log_type_id`, `description`, `notice_created_by`, `notice_manager`, `when_new_value`, `when_old_value`, `default_role_id`, `inactive_flag`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(8, 9, '投诉单提交', 0, 0, 'released', 'all', 2, 0, 44, 1413559614, 1413559614, 44),
(9, 4, '责任人更新', 0, 1, 'all', 'all', 0, 0, 44, 1413562630, 1413562630, 44),
(10, 8, '分配', 0, 1, 'allocated', 'confirmed', 0, 0, 44, 1413562672, 1413562747, 44),
(11, 8, '已解决', 1, 0, 'done', 'allocated', 0, 0, 44, 1413562687, 1413563819, 44),
(12, 8, '已关闭', 0, 1, 'closed', 'all', 0, 0, 44, 1413562732, 1413563704, 44),
(13, 8, '重新打开', 0, 1, 'reopen', 'closed', 2, 0, 44, 1413562799, 1413562799, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_orders`
--

CREATE TABLE IF NOT EXISTS `ct_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_type` varchar(20) NOT NULL COMMENT '订单类型',
  `status` varchar(20) NOT NULL COMMENT '订单状态',
  `severity` varchar(20) NOT NULL COMMENT '严重程度',
  `frequency` varchar(20) NOT NULL COMMENT '发生频率',
  `category` varchar(20) DEFAULT NULL COMMENT '分类',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `manager_id` int(11) DEFAULT NULL COMMENT '负责人',
  `plan_complete_date` int(11) DEFAULT NULL COMMENT '计划完成时间',
  `contact` varchar(255) NOT NULL COMMENT '联系人',
  `phone_number` varchar(255) DEFAULT NULL COMMENT '办公室电话',
  `mobile_telephone` varchar(255) NOT NULL COMMENT '手机号码',
  `address` varchar(255) DEFAULT NULL COMMENT '联系地址',
  `full_name` varchar(255) DEFAULT NULL COMMENT '公司名称/员工姓名',
  `warning_count` int(11) NOT NULL DEFAULT '0' COMMENT '报警次数',
  `creation_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_type`,`status`,`manager_id`) USING BTREE,
  KEY `Index_3` (`created_by`,`creation_date`,`status`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投诉单信息表' AUTO_INCREMENT=105 ;

--
-- Dumping data for table `ct_orders`
--

INSERT INTO `ct_orders` (`id`, `order_type`, `status`, `severity`, `frequency`, `category`, `title`, `manager_id`, `plan_complete_date`, `contact`, `phone_number`, `mobile_telephone`, `address`, `full_name`, `warning_count`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'employee', 'closed', 'low', 'low', '30', 'google', 1, 1412697600, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058395, 44, 1412227657, 44),
(2, 'employee', 'closed', 'low', 'low', '30', 'google', 66, 1407688200, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058525, 44, 1412732259, 44),
(3, 'employee', 'allocated', 'low', 'low', '30', 'google', 44, 0, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058552, 44, 1412232638, 44),
(4, 'employee', 'allocated', 'low', 'low', '30', 'google', 66, 1410278400, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058587, 44, 1412415685, 44),
(5, 'employee', 'reopen', 'low', 'low', '30', 'google', 44, 1412352000, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058603, 44, 1412399692, 44),
(6, 'employee', 'released', 'low', 'low', '30', 'google', 0, NULL, '陈先生', NULL, '13736777206', NULL, NULL, 0, 1412058653, 44, 1412058653, 44),
(7, 'vendor', 'allocated', 'low', 'low', '10', 'asdf', 44, 1399305600, 'asdf', NULL, 'asdf', NULL, NULL, 0, 1412058707, 44, 1412407881, 44),
(8, 'vendor', 'allocated', 'low', 'middle', '20', '啊水电费', 44, 1399305600, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059034, 44, 1412407920, 44),
(9, 'vendor', 'allocated', 'low', 'middle', '20', '啊水电费', 44, 1410278400, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059093, 44, 1412407511, 44),
(10, 'vendor', 'allocated', 'low', 'high', '10', '啊水电费', 44, 1399392000, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059118, 44, 1412408633, 44),
(11, 'vendor', 'released', 'middle', 'high', '10', '啊水电费', 0, NULL, '啊水电费', '0571', '13777777777', '烦烦烦', '方法', 0, 1412059234, 44, 1412059234, 44),
(12, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '1111', NULL, NULL, 0, 1412122645, 44, 1412122645, 44),
(13, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '1111', NULL, NULL, 0, 1412122807, 44, 1412122807, 44),
(14, 'employee', 'released', 'low', 'low', '10', 'dsg', 0, NULL, 'asd', NULL, '111', NULL, NULL, 0, 1412124607, 44, 1412124607, 44),
(15, 'vendor', 'released', 'low', 'middle', '10', 'asdf', 0, NULL, 'asdf', NULL, '1111', NULL, NULL, 0, 1412125865, 44, 1412125865, 44),
(16, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412132305, 44, 1412132305, 44),
(17, 'vendor', 'allocated', 'low', 'low', '10', 'asdf', 44, 1399305600, 'asdf', NULL, '111', NULL, NULL, 0, 1412132354, 44, 1412407695, 44),
(18, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412132369, 44, 1412132369, 44),
(19, 'vendor', 'released', 'low', 'low', '10', '11', 0, NULL, '1', NULL, '111', NULL, NULL, 0, 1412132416, 44, 1412132416, 44),
(20, 'vendor', 'released', 'low', 'low', '10', '11', 0, NULL, '1', NULL, '111', NULL, NULL, 0, 1412133624, 44, 1412133624, 44),
(21, 'vendor', 'released', 'low', 'low', '10', 'asdf', 0, NULL, 'f', NULL, '111', NULL, NULL, 0, 1412133640, 44, 1412133640, 44),
(22, 'vendor', 'released', 'low', 'low', '10', 'adsf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412133729, 44, 1412133729, 44),
(23, 'vendor', 'released', 'low', 'low', '10', 'adsf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412133795, 44, 1412133795, 44),
(24, 'vendor', 'released', 'low', 'low', '10', 'adsf', 0, NULL, 'asdf', NULL, '111', NULL, NULL, 0, 1412133817, 44, 1412133817, 44),
(25, 'employee', '', 'low', 'middle', '10', 'asdf', 0, NULL, 'asf', '', '11', '', '', 0, 1412215786, 44, 1412215786, 44),
(28, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413250542, 44, 1413250542, 44),
(29, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413250809, 44, 1413250809, 44),
(30, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413250932, 44, 1413250932, 44),
(31, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'as', '', '1', '', '', 0, 1413250971, 44, 1413250971, 44),
(32, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413252719, 44, 1413252719, 44),
(33, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413252989, 45, 1413252989, 44),
(34, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413349184, 44, 1413349184, 44),
(35, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413349192, 44, 1413349192, 44),
(36, 'vendor', 'released', 'low', 'low', '10', 'asdf', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413349195, 44, 1413349195, 44),
(37, 'vendor', 'released', 'low', 'low', '30', '图纸变更太过频繁', NULL, NULL, '陈某某', '05771111111', '13777777777', '柳翁西路100号', '速创科技工作室', 0, 1413423789, 44, 1413423789, 44),
(38, 'vendor', 'released', 'low', 'low', '10', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413528202, 44, 1413528202, 44),
(39, 'vendor', 'released', 'low', 'low', '10', '1', NULL, NULL, '1', '', '111', '', '', 0, 1413528282, 44, 1413528282, 44),
(40, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413528320, 44, 1413528320, 44),
(42, 'employee', 'released', 'low', 'low', '30', 'a', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413528421, 44, 1413528421, 44),
(43, 'employee', 'released', 'low', 'low', '30', 'a', NULL, NULL, 'asdf', '', '11', '', '', 0, 1413528437, 44, 1413528437, 44),
(44, 'employee', 'released', 'low', 'low', '30', 'a', NULL, NULL, '11', '', '111', '', '', 0, 1413528536, 44, 1413528536, 44),
(45, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '1', '', '1', '', '', 0, 1413528578, 44, 1413528578, 44),
(46, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413528702, 44, 1413528702, 44),
(48, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413529157, 44, 1413529157, 44),
(49, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413530928, 44, 1413530928, 44),
(50, 'employee', 'released', 'low', 'low', '30', '11', NULL, NULL, '11', '', '1', '', '', 0, 1413530947, 44, 1413530947, 44),
(51, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531048, 44, 1413531048, 44),
(52, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531108, 44, 1413531108, 44),
(53, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531170, 44, 1413531170, 44),
(54, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531209, 44, 1413531209, 44),
(55, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531239, 44, 1413531239, 44),
(56, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531294, 44, 1413531294, 44),
(57, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531314, 44, 1413531314, 44),
(58, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531377, 44, 1413531377, 44),
(59, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531396, 44, 1413531396, 44),
(60, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531456, 44, 1413531456, 44),
(61, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531483, 44, 1413531483, 44),
(62, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531497, 44, 1413531497, 44),
(63, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531523, 44, 1413531523, 44),
(64, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531552, 44, 1413531552, 44),
(65, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531583, 44, 1413531583, 44),
(66, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531602, 44, 1413531602, 44),
(67, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531624, 44, 1413531624, 44),
(68, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '11', '', '111', '', '', 0, 1413531651, 44, 1413531651, 44),
(69, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '111', '', '1', '', '', 0, 1413531705, 44, 1413531705, 44),
(70, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '111', '', '11', '', '', 0, 1413531968, 44, 1413531968, 44),
(71, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '111', '', '11', '', '', 0, 1413532045, 44, 1413532045, 44),
(72, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '111', '', '11', '', '', 0, 1413532174, 44, 1413532174, 44),
(73, 'employee', 'released', 'low', 'low', '30', '1', NULL, NULL, '111', '', '11', '', '', 0, 1413532233, 44, 1413532233, 44),
(77, 'employee', 'released', 'low', 'low', '30', '爱上对方', NULL, NULL, '暗室逢灯', '', '11', '', '', 0, 1413545424, 44, 1413545424, 44),
(78, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413545651, 44, 1413545651, 44),
(79, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413545690, 44, 1413545690, 44),
(80, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413545846, 44, 1413545846, 44),
(81, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413546023, 44, 1413546023, 44),
(82, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413546035, 44, 1413546035, 44),
(83, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413546112, 44, 1413546112, 44),
(84, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413546149, 44, 1413546149, 44),
(85, 'employee', 'released', 'low', 'low', '30', '爱的色放', NULL, NULL, ' 发撒旦法', '', '111', '', '', 0, 1413546302, 44, 1413546302, 44),
(86, 'employee', 'closed', 'low', 'low', '30', '爱的色放', 44, 1413475200, ' 发撒旦法', '', '111', '', '', 0, 1413546327, 44, 1413554629, 44),
(87, 'employee', 'released', 'low', 'low', '30', 'asfd', NULL, NULL, 'afds', '', '111', '', '', 0, 1413546465, 44, 1413546465, 44),
(88, 'employee', 'released', 'low', 'low', '30', 'asdf', NULL, NULL, 'asdf', '', '1', '', '', 0, 1413547082, 44, 1413547082, 44),
(89, 'employee', 'closed', 'low', 'low', '30', 'asdf', NULL, NULL, 'asdf', '', '1', '', '', 0, 1413547106, 44, 1413555683, 44),
(90, 'employee', 'closed', 'low', 'low', '30', 'asfd', 44, 1413475200, 'adsf', '', '1', '', '', 0, 1413547147, 44, 1413552345, 44),
(92, 'employee', 'released', 'low', 'low', '30', 'asfd', NULL, NULL, 'asfd', '', '111', '', '', 0, 1413559395, 44, 1413559395, 44),
(93, 'vendor', 'released', 'low', 'low', '10', 'a', NULL, NULL, 'a', '', '1', '', '', 0, 1413559460, 44, 1413559460, 44),
(94, 'vendor', 'released', 'low', 'low', '10', 'a', NULL, NULL, 'a', '', '1', '', '', 0, 1413559491, 44, 1413559491, 44),
(97, 'vendor', 'released', 'low', 'low', '10', 'a', NULL, NULL, 'a', '', '1', '', '', 0, 1413559897, 44, 1413559897, 44),
(98, 'vendor', 'allocated', 'low', 'low', '10', 'a', 47, 1413475200, 'a', '', '1', '', '', 0, 1413559928, 44, 1413560089, 44),
(99, 'employee', 'allocated', 'low', 'low', '30', 'a', 44, 1413561600, 'a', '', '1', '', '', 0, 1413560227, 44, 1413563855, 44),
(100, 'vendor', 'released', 'low', 'low', '10', '测试测试', NULL, NULL, '测试测试', '', '1', '', '', 0, 1413562846, 44, 1413562846, 44),
(101, 'vendor', 'closed', 'low', 'low', '10', '测试测试', 44, 1413561600, '测试测试', '', '1', '', '', 0, 1413562875, 44, 1413625258, 44),
(102, 'vendor', 'closed', 'low', 'low', '10', '按省份范德萨', 44, 1413561600, '按省份范德萨', '', '11', '', '', 0, 1413563758, 44, 1413617064, 44),
(103, 'vendor', 'released', 'high', 'low', '10', 'a', NULL, NULL, 'as', '', '1', '', '', 0, 1413641795, 44, 1413641795, 44),
(104, 'employee', 'released', 'high', 'low', '30', 'asfd', NULL, NULL, 'asfd', '', '111', '', '', 0, 1413641971, 44, 1413641971, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_order_addfiles`
--

CREATE TABLE IF NOT EXISTS `ct_order_addfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `file_id` int(11) NOT NULL COMMENT '文件ID',
  `description` varchar(255) NOT NULL COMMENT '文件描述',
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投诉单附件表' AUTO_INCREMENT=1 ;

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
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `content` text NOT NULL COMMENT '内容',
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投诉单内容及回复表' AUTO_INCREMENT=152 ;

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
(26, 2, '问题已经解决，你可以关闭了', 44, 1412233237, 1412233237, 44),
(27, 5, '我是分配人员，我已经确定了', 44, 1412399531, 1412399531, 44),
(28, 28, '1<br/>a<br/>v', 44, 1413250542, 1413250542, 44),
(29, 29, '1<br/>a<br/>v', 44, 1413250809, 1413250809, 44),
(30, 30, '1<br/>a<br/>v', 44, 1413250932, 1413250932, 44),
(31, 31, 'asdf', 44, 1413250971, 1413250971, 44),
(32, 32, 'asdf', 44, 1413252719, 1413252719, 44),
(33, 33, 'asdf', 44, 1413252989, 1413252989, 44),
(34, 24, 'gg', 44, 1413342588, 1413342588, 44),
(35, 32, 'ff', 44, 1413342830, 1413342830, 44),
(36, 32, 'ff', 44, 1413343419, 1413343419, 44),
(37, 32, 'aa', 44, 1413343499, 1413343499, 44),
(38, 32, 'aa', 44, 1413343608, 1413343608, 44),
(39, 32, 'a', 44, 1413343711, 1413343711, 44),
(40, 32, 'a', 44, 1413343728, 1413343728, 44),
(41, 32, 'aa', 44, 1413343757, 1413343757, 44),
(42, 32, 'b', 44, 1413346710, 1413346710, 44),
(43, 32, 'b', 44, 1413346763, 1413346763, 44),
(44, 32, 'b', 44, 1413346911, 1413346911, 44),
(45, 32, '回复测试', 44, 1413348013, 1413348013, 44),
(46, 32, '回复测试', 44, 1413348366, 1413348366, 44),
(47, 32, 'asdf', 44, 1413348373, 1413348373, 44),
(48, 32, 'a', 44, 1413348396, 1413348396, 44),
(49, 32, 'a', 44, 1413348444, 1413348444, 44),
(50, 32, 'fsaf', 44, 1413348582, 1413348582, 44),
(51, 32, 'asdf', 44, 1413348629, 1413348629, 44),
(52, 32, 'sf', 44, 1413348790, 1413348790, 44),
(53, 32, 'asdfsadf', 44, 1413348836, 1413348836, 44),
(54, 31, 'asdf', 44, 1413348920, 1413348920, 44),
(55, 31, 'fff', 44, 1413348951, 1413348951, 44),
(56, 31, 'sdaf', 44, 1413349024, 1413349024, 44),
(57, 34, 'asdf', 44, 1413349184, 1413349184, 44),
(58, 35, 'asdf', 44, 1413349192, 1413349192, 44),
(59, 36, 'asdf', 44, 1413349195, 1413349195, 44),
(60, 34, 'asf', 44, 1413349244, 1413349244, 44),
(61, 36, 'ff', 44, 1413351038, 1413351038, 44),
(62, 32, 'sdaf', 44, 1413351558, 1413351558, 44),
(63, 36, 'asdf', 44, 1413351591, 1413351591, 44),
(64, 36, 'asdf', 44, 1413351622, 1413351622, 44),
(65, 36, 'sadf', 44, 1413351720, 1413351720, 44),
(66, 37, '没有通知到位导致我这边生产过多的产品，损失惨重！', 44, 1413423789, 1413423789, 44),
(67, 38, '1', 44, 1413528202, 1413528202, 44),
(68, 39, '1', 44, 1413528282, 1413528282, 44),
(69, 40, '1', 44, 1413528320, 1413528320, 44),
(71, 42, 'a', 44, 1413528421, 1413528421, 44),
(72, 43, 'a', 44, 1413528437, 1413528437, 44),
(73, 44, 'a', 44, 1413528536, 1413528536, 44),
(74, 45, '1', 44, 1413528578, 1413528578, 44),
(75, 46, '1', 44, 1413528702, 1413528702, 44),
(77, 48, '1', 44, 1413529157, 1413529157, 44),
(78, 49, '1', 44, 1413530928, 1413530928, 44),
(79, 50, '11', 44, 1413530947, 1413530947, 44),
(80, 51, '1', 44, 1413531048, 1413531048, 44),
(81, 52, '1', 44, 1413531108, 1413531108, 44),
(82, 53, '1', 44, 1413531170, 1413531170, 44),
(83, 54, '1', 44, 1413531209, 1413531209, 44),
(84, 55, '1', 44, 1413531239, 1413531239, 44),
(85, 56, '1', 44, 1413531294, 1413531294, 44),
(86, 57, '1', 44, 1413531314, 1413531314, 44),
(87, 58, '1', 44, 1413531377, 1413531377, 44),
(88, 59, '1', 44, 1413531396, 1413531396, 44),
(89, 60, '1', 44, 1413531456, 1413531456, 44),
(90, 61, '1', 44, 1413531483, 1413531483, 44),
(91, 62, '1', 44, 1413531497, 1413531497, 44),
(92, 63, '1', 44, 1413531523, 1413531523, 44),
(93, 64, '1', 44, 1413531552, 1413531552, 44),
(94, 65, '1', 44, 1413531583, 1413531583, 44),
(95, 66, '1', 44, 1413531602, 1413531602, 44),
(96, 67, '1', 44, 1413531624, 1413531624, 44),
(97, 68, '1', 44, 1413531651, 1413531651, 44),
(98, 69, '1', 44, 1413531705, 1413531705, 44),
(99, 70, '1', 44, 1413531968, 1413531968, 44),
(100, 71, '1', 44, 1413532045, 1413532045, 44),
(101, 72, '1', 44, 1413532174, 1413532174, 44),
(102, 73, '1', 44, 1413532233, 1413532233, 44),
(106, 77, '暗室逢灯', 44, 1413545424, 1413545424, 44),
(107, 78, '爱上对方', 44, 1413545651, 1413545651, 44),
(108, 79, '爱上对方', 44, 1413545690, 1413545690, 44),
(109, 80, '爱上对方', 44, 1413545846, 1413545846, 44),
(110, 81, '爱上对方', 44, 1413546023, 1413546023, 44),
(111, 82, '爱上对方', 44, 1413546035, 1413546035, 44),
(112, 83, '爱上对方', 44, 1413546112, 1413546112, 44),
(113, 84, '爱上对方', 44, 1413546149, 1413546149, 44),
(114, 85, '爱上对方', 44, 1413546302, 1413546302, 44),
(115, 86, '爱上对方', 44, 1413546327, 1413546327, 44),
(116, 87, 'afds', 44, 1413546465, 1413546465, 44),
(117, 88, 'asfd', 44, 1413547082, 1413547082, 44),
(118, 89, 'asfd', 44, 1413547106, 1413547106, 44),
(119, 90, 'asfd', 44, 1413547147, 1413547147, 44),
(120, 90, 'asfd', 44, 1413547572, 1413547572, 44),
(122, 92, 'asfd', 44, 1413559395, 1413559395, 44),
(123, 93, 'a', 44, 1413559460, 1413559460, 44),
(124, 94, 'a', 44, 1413559491, 1413559491, 44),
(127, 97, 'a', 44, 1413559897, 1413559897, 44),
(128, 98, 'a', 44, 1413559928, 1413559928, 44),
(129, 99, 'a', 44, 1413560227, 1413560227, 44),
(130, 100, '测试测试测试测试测试测试测试测试测试测试测试测试测试测试', 44, 1413562846, 1413562846, 44),
(131, 101, '测试测试测试测试测试测试测试测试测试测试测试测试测试测试', 44, 1413562875, 1413562875, 44),
(132, 102, '按省份范德萨按省份范德萨按省份范德萨', 44, 1413563758, 1413563758, 44),
(133, 102, 'gdf', 44, 1413610753, 1413610753, 44),
(134, 102, '我的恢复可能很长还有分段还有很多有意思的内容阿拉斯加费德勒见撒的房间爱上了快递费', 44, 1413617232, 1413617232, 44),
(135, 102, '我的asdfasdda', 44, 1413617374, 1413617374, 44),
(136, 102, '我的asdfasdda', 44, 1413617463, 1413617463, 44),
(137, 102, '暗室逢灯asfd', 44, 1413617542, 1413617542, 44),
(138, 102, '暗室逢灯asfd', 44, 1413617567, 1413617567, 44),
(139, 102, '暗室逢灯asfd', 44, 1413617592, 1413617592, 44),
(140, 102, '打分数<br/>啊', 44, 1413617645, 1413617645, 44),
(141, 102, '我的回复有可能很长很长<br/>有可能有换行<br/>有可能有<br/>还有很多乱七八糟的东西想。。。asdfasfdasfdafds暗室逢灯', 44, 1413617917, 1413617917, 44),
(142, 102, 'df', 44, 1413618252, 1413618252, 44),
(143, 102, 'asfd\r<br/>aa', 44, 1413618622, 1413618622, 44),
(144, 102, '很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长', -1, 1413635258, 1413635258, -1),
(145, 102, '很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长很长', -1, 1413635290, 1413635290, -1),
(146, 102, '啊上放大', 44, 1413635466, 1413635466, 44),
(147, 102, '阿范德萨', 44, 1413635529, 1413635529, 44),
(148, 102, '啊啊', 44, 1413635686, 1413635686, 44),
(149, 102, '士大夫', 44, 1413635768, 1413635768, 44),
(150, 103, 'a', 44, 1413641795, 1413641795, 44),
(151, 104, 'asfd', 44, 1413641971, 1413641971, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_order_logs`
--

CREATE TABLE IF NOT EXISTS `ct_order_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `log_type` varchar(20) NOT NULL COMMENT '日志类型',
  `new_value` varchar(255) NOT NULL COMMENT '新值',
  `old_value` varchar(255) DEFAULT NULL COMMENT '旧值',
  `reason` text COMMENT '原因',
  `change_hash` int(11) NOT NULL COMMENT '修改序列',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`),
  KEY `Index_3` (`change_hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投诉单日志记录表' AUTO_INCREMENT=195 ;

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
(42, 2, 'status_update', 'reopen', 'closed', NULL, 1412320737, 1412320737, 44, 1412320737, 44),
(43, 5, 'status_update', 'confirmed', 'released', NULL, 1412399511, 1412399511, 44, 1412399511, 44),
(44, 5, 'status_update', 'allocated', 'confirmed', '修改责任人', 1412399578, 1412399578, 44, 1412399602, 44),
(45, 5, 'manager_change', '44', '0', '修改责任人', 1412399578, 1412399578, 44, 1412399602, 44),
(46, 5, 'status_update', 'done', 'allocated', NULL, 1412399669, 1412399669, 44, 1412399669, 44),
(47, 5, 'status_update', 'closed', 'done', NULL, 1412399684, 1412399684, 44, 1412399684, 44),
(48, 5, 'status_update', 'reopen', 'closed', NULL, 1412399692, 1412399692, 44, 1412399692, 44),
(49, 9, 'status_update', 'confirmed', 'released', NULL, 1412407465, 1412407465, 44, 1412407465, 44),
(50, 9, 'status_update', 'allocated', 'confirmed', NULL, 1412407511, 1412407511, 44, 1412407511, 44),
(51, 9, 'manager_change', '44', '0', NULL, 1412407511, 1412407511, 44, 1412407511, 44),
(52, 17, 'status_update', 'confirmed', 'released', NULL, 1412407646, 1412407646, 44, 1412407646, 44),
(53, 17, 'status_update', 'allocated', 'confirmed', NULL, 1412407666, 1412407666, 44, 1412407666, 44),
(54, 17, 'manager_change', '44', '0', NULL, 1412407666, 1412407667, 44, 1412407667, 44),
(55, 7, 'status_update', 'confirmed', 'released', NULL, 1412407737, 1412407737, 44, 1412407737, 44),
(56, 7, 'status_update', 'allocated', 'confirmed', NULL, 1412407744, 1412407744, 44, 1412407744, 44),
(57, 7, 'manager_change', '44', '0', NULL, 1412407744, 1412407744, 44, 1412407744, 44),
(58, 8, 'status_update', 'confirmed', 'released', NULL, 1412407914, 1412407914, 44, 1412407914, 44),
(59, 8, 'status_update', 'allocated', 'confirmed', NULL, 1412407920, 1412407920, 44, 1412407920, 44),
(60, 8, 'manager_change', '44', '0', NULL, 1412407920, 1412407920, 44, 1412407920, 44),
(61, 10, 'status_update', 'confirmed', 'released', NULL, 1412408011, 1412408011, 44, 1412408011, 44),
(62, 10, 'status_update', 'allocated', 'confirmed', NULL, 1412408161, 1412408161, 44, 1412408161, 44),
(63, 10, 'manager_change', '44', '0', NULL, 1412408161, 1412408161, 44, 1412408161, 44),
(64, 2, 'status_update', 'allocated', 'reopen', NULL, 1412408787, 1412408787, 44, 1412408787, 44),
(65, 2, 'pcd_update', '1407686400', '1407686400', NULL, 1412408787, 1412408787, 44, 1412408787, 44),
(66, 2, 'pcd_update', '1407688200', '1407686400', '爱上对方', 1412410328, 1412410328, 44, 1412410331, 44),
(67, 4, 'status_update', 'confirmed', 'released', NULL, 1412412630, 1412412630, 44, 1412412630, 44),
(68, 2, 'manager_change', '66', '44', 'gogo', 1412412997, 1412412997, 44, 1412413010, 44),
(69, 4, 'status_update', 'allocated', 'confirmed', NULL, 1412415137, 1412415137, 44, 1412415137, 44),
(70, 4, 'manager_change', '44', '0', NULL, 1412415137, 1412415138, 44, 1412415138, 44),
(71, 4, 'pcd_update', '1410278400', NULL, NULL, 1412415137, 1412415138, 44, 1412415138, 44),
(73, 4, 'manager_change', '66', '44', 'adf', 1412415685, 1412415685, 44, 1412415689, 44),
(74, 2, 'status_update', 'closed', 'allocated', NULL, 1412732259, 1412732259, 44, 1412732259, 44),
(75, 28, 'status_insert', 'released', NULL, NULL, 1413250542, 1413250542, 44, 1413250542, 44),
(76, 29, 'status_insert', 'released', NULL, NULL, 1413250809, 1413250809, 44, 1413250809, 44),
(77, 30, 'status_insert', 'released', NULL, NULL, 1413250932, 1413250932, 44, 1413250932, 44),
(78, 31, 'status_insert', 'released', NULL, NULL, 1413250971, 1413250971, 44, 1413250971, 44),
(79, 32, 'status_insert', 'released', NULL, NULL, 1413252719, 1413252719, 44, 1413252719, 44),
(80, 33, 'status_insert', 'released', NULL, NULL, 1413252989, 1413252989, 44, 1413252989, 44),
(81, 34, 'status_insert', 'released', NULL, NULL, 1413349184, 1413349184, 44, 1413349184, 44),
(82, 35, 'status_insert', 'released', NULL, NULL, 1413349192, 1413349192, 44, 1413349192, 44),
(83, 36, 'status_insert', 'released', NULL, NULL, 1413349195, 1413349195, 44, 1413349195, 44),
(84, 37, 'status_insert', 'released', NULL, NULL, 1413423789, 1413423789, 44, 1413423789, 44),
(86, 48, 'status_insert', 'released', '', NULL, 1413529157, 1413529157, 44, 1413529157, 44),
(87, 49, 'status_insert', 'released', '', NULL, 1413530928, 1413530928, 44, 1413530928, 44),
(88, 50, 'status_insert', 'released', '', NULL, 1413530947, 1413530947, 44, 1413530947, 44),
(89, 51, 'status_insert', 'released', '', NULL, 1413531048, 1413531048, 44, 1413531048, 44),
(90, 52, 'status_insert', 'released', '', NULL, 1413531108, 1413531108, 44, 1413531108, 44),
(91, 53, 'status_insert', 'released', '', NULL, 1413531170, 1413531170, 44, 1413531170, 44),
(92, 54, 'status_insert', 'released', '', NULL, 1413531209, 1413531209, 44, 1413531209, 44),
(93, 55, 'status_insert', 'released', '', NULL, 1413531239, 1413531239, 44, 1413531239, 44),
(94, 56, 'status_insert', 'released', '', NULL, 1413531294, 1413531294, 44, 1413531294, 44),
(95, 57, 'status_insert', 'released', '', NULL, 1413531314, 1413531314, 44, 1413531314, 44),
(96, 58, 'status_insert', 'released', '', NULL, 1413531377, 1413531377, 44, 1413531377, 44),
(97, 59, 'status_insert', 'released', '', NULL, 1413531396, 1413531396, 44, 1413531396, 44),
(98, 60, 'status_insert', 'released', '', NULL, 1413531456, 1413531456, 44, 1413531456, 44),
(99, 61, 'status_insert', 'released', '', NULL, 1413531483, 1413531483, 44, 1413531483, 44),
(100, 62, 'status_insert', 'released', '', NULL, 1413531497, 1413531497, 44, 1413531497, 44),
(101, 63, 'status_insert', 'released', '', NULL, 1413531523, 1413531523, 44, 1413531523, 44),
(102, 64, 'status_insert', 'released', '', NULL, 1413531552, 1413531552, 44, 1413531552, 44),
(103, 65, 'status_insert', 'released', '', NULL, 1413531583, 1413531583, 44, 1413531583, 44),
(104, 66, 'status_insert', 'released', '', NULL, 1413531602, 1413531602, 44, 1413531602, 44),
(105, 67, 'status_insert', 'released', '', NULL, 1413531624, 1413531624, 44, 1413531624, 44),
(106, 68, 'status_insert', 'released', '', NULL, 1413531651, 1413531651, 44, 1413531651, 44),
(107, 69, 'status_insert', 'released', '', NULL, 1413531705, 1413531705, 44, 1413531705, 44),
(108, 70, 'status_insert', 'released', '', NULL, 1413531968, 1413531968, 44, 1413531968, 44),
(109, 71, 'status_insert', 'released', '', NULL, 1413532045, 1413532045, 44, 1413532045, 44),
(110, 72, 'status_insert', 'released', '', NULL, 1413532174, 1413532174, 44, 1413532174, 44),
(111, 73, 'status_insert', 'released', '', NULL, 1413532233, 1413532233, 44, 1413532233, 44),
(115, 77, 'order_confirm', 'released', '', '爱上对方', 1413545424, 1413545424, 44, 1413545534, 44),
(116, 78, 'order_confirm', 'released', '', NULL, 1413545651, 1413545651, 44, 1413545651, 44),
(117, 79, 'order_confirm', 'released', '', NULL, 1413545690, 1413545690, 44, 1413545690, 44),
(118, 80, 'order_confirm', 'released', '', NULL, 1413545846, 1413545846, 44, 1413545846, 44),
(119, 81, 'order_confirm', 'released', '', NULL, 1413546023, 1413546023, 44, 1413546023, 44),
(120, 82, 'order_confirm', 'released', '', NULL, 1413546035, 1413546035, 44, 1413546035, 44),
(121, 83, 'order_confirm', 'released', '', NULL, 1413546112, 1413546112, 44, 1413546112, 44),
(122, 84, 'order_confirm', 'released', '', NULL, 1413546149, 1413546149, 44, 1413546149, 44),
(123, 85, 'order_confirm', 'released', '', NULL, 1413546302, 1413546302, 44, 1413546302, 44),
(124, 86, 'order_confirm', 'released', '', NULL, 1413546327, 1413546327, 44, 1413546327, 44),
(125, 87, 'order_confirm', 'released', '', NULL, 1413546465, 1413546465, 44, 1413546465, 44),
(126, 88, 'order_confirm', 'released', '', NULL, 1413547082, 1413547082, 44, 1413547082, 44),
(127, 89, 'order_confirm', 'released', '', NULL, 1413547106, 1413547106, 44, 1413547106, 44),
(128, 90, 'order_confirm', 'released', '', 'safd', 1413547147, 1413547147, 44, 1413547170, 44),
(129, 90, 'order_done', 'confirmed', 'released', NULL, 1413548166, 1413548166, 44, 1413548166, 44),
(130, 90, 'order_reopen', 'confirmed', 'released', NULL, 1413548166, 1413548166, 44, 1413548166, 44),
(131, 89, 'order_done', 'confirmed', 'released', NULL, 1413548193, 1413548193, 44, 1413548193, 44),
(132, 89, 'order_reopen', 'confirmed', 'released', NULL, 1413548193, 1413548193, 44, 1413548193, 44),
(133, 90, 'order_done', 'allocated', 'confirmed', 'aa', 1413548938, 1413548938, 44, 1413548982, 44),
(134, 90, 'manager_change', '44', NULL, 'aa', 1413548938, 1413548938, 44, 1413548982, 44),
(135, 90, 'pcd_update', '0', NULL, 'aa', 1413548938, 1413548938, 44, 1413548982, 44),
(136, 90, 'order_reopen', 'allocated', 'confirmed', 'aa', 1413548938, 1413548938, 44, 1413548982, 44),
(137, 90, 'order_done', 'allocated', 'allocated', '无法完成', 1413550556, 1413550556, 44, 1413550570, 44),
(138, 90, 'manager_change', '44', '44', '无法完成', 1413550556, 1413550556, 44, 1413550570, 44),
(139, 90, 'pcd_update', '1413475200', '0', '无法完成', 1413550556, 1413550556, 44, 1413550570, 44),
(140, 90, 'order_reopen', 'allocated', 'allocated', '无法完成', 1413550556, 1413550556, 44, 1413550570, 44),
(141, 90, 'pcd_update', '1413561600', '1413475200', '责任人要求变更', 1413550974, 1413550974, 44, 1413550996, 44),
(142, 90, 'pcd_update', '1413475200', '1413561600', 'f', 1413551190, 1413551190, 44, 1413551197, 44),
(143, 90, 'order_done', 'done', 'allocated', NULL, 1413551407, 1413551407, 44, 1413551407, 44),
(144, 90, 'order_reopen', 'done', 'allocated', NULL, 1413551407, 1413551407, 44, 1413551407, 44),
(145, 90, 'order_done', 'closed', 'done', NULL, 1413551443, 1413551443, 44, 1413551443, 44),
(146, 90, 'order_reopen', 'closed', 'done', NULL, 1413551443, 1413551443, 44, 1413551443, 44),
(147, 90, 'order_done', 'reopen', 'closed', NULL, 1413552179, 1413552179, 44, 1413552179, 44),
(148, 90, 'order_reopen', 'reopen', 'closed', NULL, 1413552179, 1413552179, 44, 1413552179, 44),
(149, 90, 'order_done', 'closed', 'reopen', NULL, 1413552345, 1413552345, 44, 1413552345, 44),
(150, 90, 'order_reopen', 'closed', 'reopen', NULL, 1413552345, 1413552345, 44, 1413552345, 44),
(151, 86, 'manager_change', '44', NULL, 'a', 1413554326, 1413554326, 44, 1413554376, 44),
(152, 86, 'pcd_update', '1413475200', NULL, 'a', 1413554326, 1413554326, 44, 1413554376, 44),
(153, 86, 'order_done', 'done', 'allocated', NULL, 1413554385, 1413554385, 44, 1413554385, 44),
(154, 86, 'order_reopen', 'reopen', 'closed', NULL, 1413554428, 1413554428, 44, 1413554428, 44),
(156, 92, 'order_status_new', 'released', '', NULL, 1413559395, 1413559395, 44, 1413559395, 44),
(157, 93, 'order_status_new', 'released', '', NULL, 1413559460, 1413559460, 44, 1413559460, 44),
(158, 94, 'order_status_new', 'released', '', NULL, 1413559491, 1413559491, 44, 1413559491, 44),
(161, 97, 'order_status_new', 'released', '', NULL, 1413559897, 1413559897, 44, 1413559897, 44),
(162, 98, 'order_status_new', 'released', '', NULL, 1413559928, 1413559928, 44, 1413559928, 44),
(163, 98, 'order_status', 'confirmed', 'released', NULL, 1413559940, 1413559940, 44, 1413559940, 44),
(164, 98, 'manager_change', '44', NULL, NULL, 1413560049, 1413560049, 44, 1413560049, 44),
(165, 98, 'pcd_update', '1413475200', NULL, NULL, 1413560049, 1413560049, 44, 1413560049, 44),
(166, 98, 'order_status', 'allocated', 'confirmed', NULL, 1413560049, 1413560049, 44, 1413560049, 44),
(167, 98, 'manager_change', '47', '44', NULL, 1413560089, 1413560089, 44, 1413560089, 44),
(168, 99, 'order_status_new', 'released', '', NULL, 1413560227, 1413560227, 44, 1413560227, 44),
(169, 100, 'order_status_new', 'released', '', NULL, 1413562846, 1413562846, 44, 1413562846, 44),
(170, 101, 'order_status_new', 'released', '', NULL, 1413562875, 1413562875, 44, 1413562875, 44),
(171, 101, 'order_status', 'confirmed', 'released', NULL, 1413562911, 1413562911, 44, 1413562911, 44),
(172, 101, 'manager_change', '47', NULL, NULL, 1413562963, 1413562963, 44, 1413562963, 44),
(173, 101, 'pcd_update', '1413561600', NULL, NULL, 1413562963, 1413562963, 44, 1413562963, 44),
(174, 101, 'order_status', 'allocated', 'confirmed', NULL, 1413562963, 1413562963, 44, 1413562963, 44),
(175, 101, 'manager_change', '44', '47', '责任人没空', 1413563071, 1413563071, 44, 1413563085, 44),
(176, 101, 'pcd_update', '1413475200', '1413561600', NULL, 1413563132, 1413563132, 44, 1413563132, 44),
(177, 101, 'pcd_update', '1413561600', '1413475200', '又调回来了', 1413563397, 1413563397, 44, 1413563410, 44),
(178, 101, 'order_status', 'done', 'allocated', NULL, 1413563431, 1413563431, 44, 1413563431, 44),
(179, 101, 'order_status', 'closed', 'done', NULL, 1413563623, 1413563623, 44, 1413563623, 44),
(180, 101, 'order_status', 'reopen', 'closed', NULL, 1413563650, 1413563650, 44, 1413563650, 44),
(181, 102, 'order_status_new', 'released', '', NULL, 1413563758, 1413563758, 44, 1413563758, 44),
(182, 102, 'order_status', 'confirmed', 'released', NULL, 1413563771, 1413563771, 44, 1413563771, 44),
(183, 102, 'manager_change', '44', NULL, NULL, 1413563776, 1413563776, 44, 1413563776, 44),
(184, 102, 'pcd_update', '1413561600', NULL, NULL, 1413563776, 1413563776, 44, 1413563776, 44),
(185, 102, 'order_status', 'allocated', 'confirmed', NULL, 1413563776, 1413563776, 44, 1413563776, 44),
(186, 102, 'order_status', 'done', 'allocated', NULL, 1413563825, 1413563825, 44, 1413563825, 44),
(187, 99, 'order_status', 'confirmed', 'released', NULL, 1413563851, 1413563851, 44, 1413563851, 44),
(188, 99, 'manager_change', '44', NULL, NULL, 1413563855, 1413563855, 44, 1413563855, 44),
(189, 99, 'pcd_update', '1413561600', NULL, NULL, 1413563855, 1413563855, 44, 1413563855, 44),
(190, 99, 'order_status', 'allocated', 'confirmed', NULL, 1413563855, 1413563855, 44, 1413563855, 44),
(191, 102, 'order_status', 'closed', 'done', NULL, 1413617064, 1413617064, 44, 1413617064, 44),
(192, 101, 'order_status', 'closed', 'reopen', NULL, 1413625258, 1413625258, 44, 1413625258, 44),
(193, 103, 'order_status_new', 'released', '', NULL, 1413641795, 1413641795, 44, 1413641795, 44),
(194, 104, 'order_status_new', 'released', '', NULL, 1413641971, 1413641971, 44, 1413641971, 44);

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
,`field_valuelist_id` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_order_log_types`
--

CREATE TABLE IF NOT EXISTS `ct_order_log_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` varchar(45) NOT NULL COMMENT '日志类型',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `title` varchar(255) NOT NULL COMMENT '标题格式',
  `content` text NOT NULL COMMENT '内容格式',
  `need_reason_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否需要填写原因',
  `field_name` varchar(100) NOT NULL COMMENT '字段',
  `dll_type` varchar(20) NOT NULL COMMENT '操作类型',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `field_valuelist_id` int(10) unsigned DEFAULT NULL COMMENT '字段值集',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投诉单日志类型表' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ct_order_log_types`
--

INSERT INTO `ct_order_log_types` (`id`, `log_type`, `description`, `title`, `content`, `need_reason_flag`, `field_name`, `dll_type`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`, `field_valuelist_id`) VALUES
(4, 'manager_change', '责任人更新', '投诉单 &order_id 责任人变更', '责任人从 &old_value 变成 &new_value', 1, 'manager_id', 'update', 44, 1412228612, 1413563507, 44, 17),
(5, 'pcd_update', '计划完成时间更新', '投诉单 &order_id 计划完成日期变更', '计划完成时间变更从&old_value 改为 &new_value ', 1, 'plan_complete_date', 'update', 44, 1412408774, 1413563517, 44, 0),
(8, 'order_status', '状态更新', '投诉单 &order_id状态更新', '&old_value => &new_value', 0, 'status', 'update', 44, 1413558149, 1413558149, 44, 16),
(9, 'order_status_new', '投诉单提交', '投诉单 &order_id 提交', '投诉单提交', 0, 'status', 'insert', 44, 1413558239, 1413558239, 44, 16);

-- --------------------------------------------------------

--
-- Table structure for table `ct_order_meetings`
--

CREATE TABLE IF NOT EXISTS `ct_order_meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `meeting_id` int(10) unsigned NOT NULL COMMENT '会议ID',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(10) unsigned DEFAULT NULL,
  `last_updated_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`order_id`,`meeting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投诉单会议记录表' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ct_order_meetings`
--

INSERT INTO `ct_order_meetings` (`id`, `order_id`, `meeting_id`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 2, 1, NULL, NULL, NULL, NULL),
(2, 2, 2, 44, 1412305995, 1412305995, 44),
(4, 3, 3, 44, 1412310745, 1412310745, 44),
(5, 102, 4, 44, 1413611547, 1413611547, 44),
(6, 102, 5, 44, 1413615576, 1413615576, 44),
(7, 102, 6, 44, 1413616500, 1413616500, 44),
(8, 100, 6, 44, 1413616500, 1413616500, 44);

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
  `role_name` varchar(20) NOT NULL COMMENT '角色名称',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统角色信息表' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ct_roles`
--

INSERT INTO `ct_roles` (`id`, `role_name`, `description`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 'reporter_vender', '供应商', NULL, NULL, 1412398542, 44),
(2, 'dispatcher', '调度员', NULL, NULL, NULL, NULL),
(3, 'reporter_employee', '内部员工', NULL, NULL, NULL, NULL),
(4, 'reporter_customer', '客户', NULL, NULL, NULL, NULL),
(5, 'manager_vendor', '采购经理', NULL, NULL, NULL, NULL),
(6, 'manager_customer', '质量经理', NULL, NULL, NULL, NULL),
(7, 'manager_employee', '人事经理', NULL, NULL, NULL, NULL),
(8, 'administrator', '系统管理员', NULL, NULL, NULL, NULL),
(11, 'recorder', '所有投诉记录人员', -1, 1411974364, 1411974364, -1),
(12, 'recorder_customer', '客户投诉记录人员', 44, 1413034064, 1413034064, 44),
(13, 'recorder_vendor', '供应商投诉记录人员', 44, 1413424727, 1413424727, 44),
(14, 'recorder_employee', '内部投诉记录人员', 44, 1413424740, 1413424740, 44);

-- --------------------------------------------------------

--
-- Table structure for table `ct_role_module_lines`
--

CREATE TABLE IF NOT EXISTS `ct_role_module_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `module_line_id` int(11) NOT NULL COMMENT '模块功能',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色对应功能表' AUTO_INCREMENT=58 ;

--
-- Dumping data for table `ct_role_module_lines`
--

INSERT INTO `ct_role_module_lines` (`id`, `role_id`, `module_line_id`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(3, 8, 14, 1412148323, 44, 1412148323, 44),
(19, 1, 14, 1413030370, 44, 1413030370, 44),
(20, 0, 13, 1413033621, 44, 1413033621, 44),
(21, 0, 14, 1413033621, 44, 1413033621, 44),
(22, 0, 13, 1413033700, 44, 1413033700, 44),
(23, 0, 14, 1413033700, 44, 1413033700, 44),
(24, 12, 13, 1413034064, 44, 1413034064, 44),
(25, 12, 14, 1413034064, 44, 1413034064, 44),
(32, 1, 18, 1413095998, 44, 1413095998, 44),
(33, 1, 22, 1413115599, 44, 1413115599, 44),
(34, 1, 23, 1413115740, 44, 1413115740, 44),
(35, 1, 24, 1413115836, 44, 1413115836, 44),
(37, 8, 34, 1413425791, 44, 1413425791, 44),
(45, 1, 25, 1413426237, 44, 1413426237, 44),
(46, 11, 18, 1413427802, 44, 1413427802, 44),
(47, 11, 22, 1413427802, 44, 1413427802, 44),
(48, 11, 24, 1413427802, 44, 1413427802, 44),
(49, 8, 23, 1413436999, 44, 1413436999, 44),
(50, 8, 25, 1413436999, 44, 1413436999, 44),
(51, 8, 39, 1413628264, 44, 1413628264, 44),
(52, 8, 40, 1413628264, 44, 1413628264, 44),
(53, 8, 41, 1413628381, 44, 1413628381, 44),
(54, 8, 42, 1413628381, 44, 1413628381, 44),
(55, 8, 43, 1413628381, 44, 1413628381, 44),
(56, 8, 44, 1413628381, 44, 1413628381, 44),
(57, 8, 17, 1413628381, 44, 1413628381, 44);

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
  `object_id` int(11) NOT NULL COMMENT '权限对象ID',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `module_line_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`role_id`,`object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色对应权限表' AUTO_INCREMENT=68 ;

--
-- Dumping data for table `ct_role_profiles`
--

INSERT INTO `ct_role_profiles` (`id`, `role_id`, `object_id`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`, `module_line_id`) VALUES
(8, 2, 4, 1412992812, 44, 1412992812, 44, NULL),
(39, 0, 2, 1413033621, 44, 1413033621, 44, NULL),
(40, 0, 1, 1413033621, 44, 1413033621, 44, NULL),
(43, 0, 1, 1413033700, 44, 1413033700, 44, NULL),
(45, 0, 2, 1413033700, 44, 1413033700, 44, NULL),
(47, 12, 1, 1413034064, 44, 1413034064, 44, NULL),
(49, 12, 2, 1413034064, 44, 1413034064, 44, NULL),
(53, 1, 1, 1413427676, 44, 1413427676, 44, NULL),
(56, 1, 3, 1413433089, 44, 1413433089, 44, NULL),
(60, 1, 4, 1413433260, 44, 1413433260, 44, NULL),
(63, 11, 1, 1413440415, 44, 1413440415, 44, NULL),
(66, 8, 1, 1413460414, 44, 1413460414, 44, NULL),
(67, 8, 3, 1413462790, 44, 1413462790, 44, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_role_profiles_v`
--
CREATE TABLE IF NOT EXISTS `ct_role_profiles_v` (
`id` int(11)
,`role_id` int(11)
,`object_id` int(11)
,`creation_date` int(11)
,`created_by` int(11)
,`last_update_date` int(11)
,`last_updated_by` int(11)
,`object_name` varchar(20)
,`object_desc` varchar(255)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_role_profile_lines`
--

CREATE TABLE IF NOT EXISTS `ct_role_profile_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `object_line_id` int(11) NOT NULL COMMENT '权限对象项目',
  `auth_value` text NOT NULL COMMENT '项目值',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`profile_id`,`object_line_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色对应权限明细表' AUTO_INCREMENT=95 ;

--
-- Dumping data for table `ct_role_profile_lines`
--

INSERT INTO `ct_role_profile_lines` (`id`, `profile_id`, `object_line_id`, `auth_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(7, 8, 8, 'TRUE', 1412992812, 44, 1412992812, 44),
(8, 8, 11, 'all', 1412992812, 44, 1412992812, 44),
(41, 43, 3, 'customer', 1413033700, 44, 1413033700, 44),
(42, 43, 4, 'all', 1413033700, 44, 1413033700, 44),
(43, 43, 5, 'all', 1413033700, 44, 1413033700, 44),
(47, 45, 6, 'TRUE', 1413033700, 44, 1413033700, 44),
(49, 47, 3, 'customer', 1413034064, 44, 1413034064, 44),
(50, 47, 4, 'all', 1413034064, 44, 1413034064, 44),
(51, 47, 5, 'all', 1413034064, 44, 1413034064, 44),
(55, 49, 6, 'TRUE', 1413034064, 44, 1413034064, 44),
(61, 53, 3, 'vendor', 1413427676, 44, 1413427696, 44),
(62, 53, 4, 'all', 1413427676, 44, 1413427676, 44),
(63, 53, 5, 'all', 1413427676, 44, 1413427676, 44),
(68, 56, 7, 'all', 1413433089, 44, 1413433089, 44),
(74, 60, 8, 'TRUE', 1413433260, 44, 1413433260, 44),
(75, 60, 11, 'all', 1413433260, 44, 1413433260, 44),
(82, 63, 3, 'all', 1413440415, 44, 1413462773, 44),
(83, 63, 4, 'all', 1413440415, 44, 1413440415, 44),
(84, 63, 5, 'all', 1413440415, 44, 1413440415, 44),
(91, 66, 3, 'all', 1413460414, 44, 1413510888, 44),
(92, 66, 4, 'all', 1413460414, 44, 1413460414, 44),
(93, 66, 5, 'all', 1413460414, 44, 1413460414, 44),
(94, 67, 7, 'all', 1413462790, 44, 1413462790, 44);

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
  `status_code` varchar(20) NOT NULL COMMENT '状态码',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`status_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统状态表' AUTO_INCREMENT=2 ;

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
  `segment` varchar(20) NOT NULL COMMENT '段',
  `segment_value` varchar(255) NOT NULL COMMENT '段值',
  `segment_desc` varchar(255) NOT NULL COMMENT '段描述',
  `next_status` varchar(255) DEFAULT NULL COMMENT '下一步状态列表',
  `back_status` varchar(20) DEFAULT NULL COMMENT '冲销后状态',
  `default_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认标识',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `default_next_status` varchar(20) DEFAULT NULL COMMENT '默认下一步',
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_vl_line_01` (`status_id`,`segment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统状态步骤表' AUTO_INCREMENT=7 ;

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
-- Stand-in structure for view `ct_tables_vl`
--
CREATE TABLE IF NOT EXISTS `ct_tables_vl` (
`value` varchar(64)
,`label` text
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_users`
--

CREATE TABLE IF NOT EXISTS `ct_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `sex` varchar(20) NOT NULL DEFAULT 'male' COMMENT '性别',
  `contact` varchar(255) DEFAULT NULL COMMENT '默认联系人',
  `email` varchar(255) DEFAULT NULL COMMENT '邮件地址',
  `phone_number` varchar(255) DEFAULT NULL COMMENT '办公电话',
  `mobile_telephone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `address` varchar(255) DEFAULT NULL COMMENT '联系地址',
  `full_name` varchar(255) NOT NULL COMMENT '公司名称/员工姓名',
  `inactive_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '失效标识',
  `email_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否接收邮件',
  `sms_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否接收短信',
  `initial_pass_flag` int(11) NOT NULL DEFAULT '1' COMMENT '密码初始化标识',
  `created_by` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`username`),
  KEY `Index_3` (`username`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统用户信息表' AUTO_INCREMENT=73 ;

--
-- Dumping data for table `ct_users`
--

INSERT INTO `ct_users` (`id`, `username`, `password`, `sex`, `contact`, `email`, `phone_number`, `mobile_telephone`, `address`, `full_name`, `inactive_flag`, `email_flag`, `sms_flag`, `initial_pass_flag`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(44, 'administrator', 'fbeae417c84f2bf1121ab58c55105b4247c8e069', 'male', '超级管理员', 'yacole@qq.com', '13777777777', '13989775601', '乐清柳市镇', '超级管理员', 0, 1, 0, 0, -1, 1412039595, 1413642792, 44),
(45, 'reporter_customer', 'fbeae417c84f2bf1121ab58c55105b4247c8e069', 'male', '客户测试账号', '', '', '', '', '客户测试账号', 0, 0, 0, 1, 44, 1412229944, 1413633221, 44),
(46, 'reporter_vender', 'fbeae417c84f2bf1121ab58c55105b4247c8e069', 'male', '供应商测试账号', '', '', '', '', '供应商测试账号', 0, 0, 0, 1, 44, 1412230134, 1413633243, 44),
(47, 'reporter_employee', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'male', '内部员工测试账号', '', '', '', '', '内部员工测试账号', 0, 0, 0, 1, 44, 1412230196, 1413633237, 44),
(48, 'dispatcher', '92429d82a41e930486c6de5ebda9602d55c39986', 'male', '调度员测试账号', 'gs1357@qq.com', '', '', '', '调度员测试账号', 0, 1, 0, 1, 44, 1412230229, 1413633124, 44),
(66, 'manager_vendor', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'male', '采购经理测试账号', 'gs1357@qq.com', '', '', '', '采购经理测试账号', 0, 1, 0, 1, 44, 1412231054, 1413633208, 44),
(67, 'manager_customer', '3421ecde2a5de6543b48460b867cf323b018bc22', 'female', '质量经理测试账号', '', '', '', '', '质量经理测试账号', 0, 0, 0, 0, 44, 1412404281, 1413633152, 44),
(68, 'manager_employee', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'female', '', '', '', '', '', '人事经理测试账号', 0, 0, 0, 1, 44, 1412404348, 1413633189, 44),
(69, 'recorder', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'male', '投诉记录人员', 'yacole@sooncreate.com', NULL, NULL, NULL, '投诉记录人员', 0, 0, 0, 1, 44, 1413633354, 1413633354, 44),
(70, 'recorder_customer', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'male', '客户投诉记录人员', 'yacole@sooncreate.com', NULL, NULL, NULL, '客户投诉记录人员', 0, 0, 0, 1, 44, 1413633537, 1413633537, 44),
(71, 'recorder_vendor', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'male', '供应商投诉记录人员', NULL, NULL, NULL, NULL, '供应商投诉记录人员', 0, 0, 0, 1, 44, 1413633576, 1413633576, 44),
(72, 'recorder_employee', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'male', '内部投诉记录人员', NULL, NULL, NULL, NULL, '内部投诉记录人员', 0, 0, 0, 1, 44, 1413633592, 1413633592, 44);

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
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`user_id`,`role_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户角色对应表' AUTO_INCREMENT=56 ;

--
-- Dumping data for table `ct_user_roles`
--

INSERT INTO `ct_user_roles` (`id`, `user_id`, `role_id`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 37, 3, 1411826157, 0, 1411826157, 0),
(2, 39, 4, 1411826432, 0, 1411826432, 0),
(4, 41, 3, 1411826496, 0, 1411826496, 0),
(5, 42, 3, 1411826529, 0, 1411826529, 0),
(14, 48, 3, 1412230229, 44, 1412230229, 44),
(15, 66, 1, 1412231054, 44, 1412231054, 44),
(16, 67, 4, 1412404281, 44, 1412404281, 44),
(18, 66, 8, 1413426082, 44, 1413426082, 44),
(20, 44, 8, 1413426182, 44, 1413426182, 44),
(24, 47, 1, 1413433311, 44, 1413433311, 44),
(54, 44, 2, 1413562478, 44, 1413562478, 44),
(55, 44, 11, 1413562478, 44, 1413562478, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_user_roles_v`
--
CREATE TABLE IF NOT EXISTS `ct_user_roles_v` (
`id` int(11)
,`username` varchar(200)
,`password` varchar(255)
,`sex` varchar(20)
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
,`role_name` varchar(20)
,`role_desc` varchar(255)
,`role_id` int(11)
,`user_id` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_valuelist_header`
--

CREATE TABLE IF NOT EXISTS `ct_valuelist_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valuelist_name` varchar(20) NOT NULL COMMENT '值集名称',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `object_flag` tinyint(4) DEFAULT '0' COMMENT '是否表/视图对象',
  `label_fieldname` varchar(100) DEFAULT NULL COMMENT '描述字段',
  `value_fieldname` varchar(100) DEFAULT NULL COMMENT '值字段',
  `source_view` varchar(100) DEFAULT NULL COMMENT '源表/视图',
  `condition` text COMMENT '查询条件',
  `parent_id` int(11) DEFAULT NULL COMMENT '父值集',
  `editable_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可编辑',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_2` (`valuelist_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='值集信息表' AUTO_INCREMENT=27 ;

--
-- Dumping data for table `ct_valuelist_header`
--

INSERT INTO `ct_valuelist_header` (`id`, `valuelist_name`, `description`, `object_flag`, `label_fieldname`, `value_fieldname`, `source_view`, `condition`, `parent_id`, `editable_flag`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'vl_order_type', '投诉单类型', 0, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 1412753720, 44),
(2, 'vl_severity', '严重程度', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(3, 'vl_priority', '优先级', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(4, 'vl_frequency', '发生频率', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(6, 'ao_order_status', '订单状态权限对象', 1, 'segment_desc', 'segment_value', 'ct_order_status_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(7, 'vl_order_category', '订单分类', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(8, 'ao_order_category', '订单分类权限对象', 1, 'segment_desc', 'segment_value', 'ct_order_category_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(9, 'ao_order_type', '订单类型权限对象', 1, 'segment_desc', 'segment_value', 'ct_valuelist_vl', 'valuelist_name = ''vl_order_type''', NULL, 1, NULL, NULL, NULL, NULL),
(10, 'default_role', '订单类型默认角色', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(11, 'ao_true_or_false', '权限对象选择是/否', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(12, 'default_category', '订单默认的分类（在分类未开启时）', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(14, 'vl_dll_type', '数据库dll操作类型', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(15, 'vl_valuelist', '值集列表', 1, 'label', 'value', 'ct_valuelist_header_vl', '', NULL, 0, NULL, NULL, NULL, NULL),
(16, 'vl_order_status', '投诉单状态', 1, 'segment_desc', 'segment_value', 'ct_order_status_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(17, 'vl_user', '用户列表', 1, 'full_name', 'id', 'ct_users', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(18, 'vl_meeting_cancel', '会议取消原因', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(19, 'vl_sex', '用户性别', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(20, 'vl_feedback', '订单反馈项目', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(22, 'vl_authobject', '供权限对象使用的值集', 1, 'description', 'id', 'ct_valuelist_header', 'valuelist_name like ''ao_%''', NULL, 1, 1412754189, 44, 1412991840, 44),
(23, 'vl_tables', '系统表/视图值集', 1, 'label', 'value', 'ct_tables_vl', '', NULL, 0, 1412907002, 44, 1412907002, 44),
(24, 'vl_roles', '系统角色列表', 1, 'description', 'id', 'ct_roles', '', NULL, 1, 1412927876, 44, 1412928109, 44),
(25, 'ao_log_type', '投诉单日志类型', 1, 'description', 'log_type', 'ct_order_log_types', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(26, 'vl_auth_object', '权限对象值集', 1, 'description', 'id', 'ct_authority_objects', '', NULL, 1, 1413513361, 44, 1413513361, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_valuelist_header_vl`
--
CREATE TABLE IF NOT EXISTS `ct_valuelist_header_vl` (
`value` int(11)
,`label` varchar(278)
);
-- --------------------------------------------------------

--
-- Table structure for table `ct_valuelist_lines`
--

CREATE TABLE IF NOT EXISTS `ct_valuelist_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valuelist_id` int(11) NOT NULL,
  `segment` varchar(20) NOT NULL COMMENT '段',
  `segment_value` varchar(255) NOT NULL COMMENT '段值',
  `segment_desc` varchar(255) NOT NULL COMMENT '段描述',
  `inactive_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '失效标识',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `parent_segment_value` varchar(20) DEFAULT NULL COMMENT '父值集值',
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_vl_line_01` (`valuelist_id`,`segment`,`parent_segment_value`) USING BTREE,
  KEY `Index_3` (`valuelist_id`,`parent_segment_value`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='值集明细表' AUTO_INCREMENT=50 ;

--
-- Dumping data for table `ct_valuelist_lines`
--

INSERT INTO `ct_valuelist_lines` (`id`, `valuelist_id`, `segment`, `segment_value`, `segment_desc`, `inactive_flag`, `sort`, `parent_segment_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, '10', 'vendor', '供应商投诉单', 0, 1, '0', NULL, NULL, 1413506503, 44),
(2, 1, '20', 'employee', '内部员工投诉单', 0, 2, '0', NULL, NULL, NULL, NULL),
(3, 1, '30', 'customer', '客户投诉单', 0, 1, '0', NULL, NULL, 1412902860, 44),
(4, 2, '30', 'low', '低', 0, 0, '0', NULL, NULL, NULL, NULL),
(5, 2, '20', 'middle', '中', 0, 0, '0', NULL, NULL, NULL, NULL),
(6, 2, '10', 'high', '高', 0, 0, '0', NULL, NULL, NULL, NULL),
(7, 3, '30', 'low', '低', 0, 0, '0', NULL, NULL, NULL, NULL),
(8, 3, '20', 'middle', '中', 0, 0, '0', NULL, NULL, NULL, NULL),
(9, 3, '10', 'high', '高', 0, 0, '0', NULL, NULL, NULL, NULL),
(10, 4, '10', 'low', '仅发生一次', 0, 0, '0', NULL, NULL, NULL, NULL),
(11, 4, '20', 'middle', '偶尔发生', 0, 0, '0', NULL, NULL, NULL, NULL),
(12, 4, '30', 'high', '发生频率很高', 0, 0, '0', NULL, NULL, NULL, NULL),
(16, 7, '10', '10', '默认', 0, 0, 'vendor', NULL, NULL, NULL, NULL),
(18, 10, '10', 'reporter_vender', '供应商', 0, 1, 'vendor', NULL, NULL, 1412902890, 44),
(21, 10, '10', 'reporter_customer', '客户', 0, 0, 'customer', NULL, NULL, NULL, NULL),
(22, 10, '10', 'reporter_employee', '内部员工', 0, 0, 'employee', NULL, NULL, NULL, NULL),
(24, 7, '20', '20', '采购需求', 0, 1, 'vendor', NULL, NULL, 1413419176, 44),
(25, 7, '10', '10', '默认', 0, 0, 'customer', NULL, NULL, NULL, NULL),
(26, 7, '10', '30', '默认', 0, 0, 'employee', NULL, NULL, NULL, NULL),
(27, 11, '10', 'TRUE', '是', 0, 0, NULL, NULL, NULL, NULL, NULL),
(28, 11, '20', 'FALSE', '否', 0, 0, NULL, NULL, NULL, NULL, NULL),
(29, 12, '10', '10', '默认', 0, 0, 'vendor', NULL, NULL, NULL, NULL),
(30, 12, '20', '10', '默认', 0, 0, 'customer', NULL, NULL, NULL, NULL),
(31, 12, '30', '10', '默认', 0, 0, 'employee', NULL, NULL, NULL, NULL),
(32, 14, '10', 'update', '更新', 0, 0, NULL, NULL, NULL, NULL, NULL),
(33, 14, '20', 'insert', '创建', 0, 0, NULL, NULL, NULL, NULL, NULL),
(34, 18, '10', '10', '投诉问题已解决', 0, 0, NULL, NULL, NULL, NULL, NULL),
(35, 18, '20', '20', '创建失误', 0, 0, NULL, NULL, NULL, NULL, NULL),
(36, 18, '30', '30', '确认无需再召开', 0, 0, NULL, NULL, NULL, NULL, NULL),
(37, 19, '10', 'male', '男', 0, 0, NULL, NULL, NULL, NULL, NULL),
(38, 19, '20', 'female', '女', 0, 0, NULL, NULL, NULL, NULL, NULL),
(39, 20, '10', '10', '响应速度', 0, 0, NULL, NULL, NULL, 1413623372, 44),
(40, 20, '20', '20', '服务态度', 0, 0, NULL, NULL, NULL, 1413623384, 44),
(43, 7, '20', '20', '默认分类2', 0, 0, 'customer', 1412824646, -1, 1412824646, -1),
(44, 7, '30', '30', '3', 0, 2, 'customer', 1412824672, -1, 1412824702, -1),
(45, 7, '40', '40', '4', 0, 1, 'customer', 1412825288, -1, 1412825288, -1),
(46, 10, '20', '201', 'asdf', 0, 1, 'vendor', 1412903034, 44, 1412903055, 44),
(47, 7, '30', '30', '设计图纸', 0, 2, 'vendor', 1413419139, 44, 1413419167, 44),
(48, 7, '40', '40', '采购部门服务', 0, 3, 'vendor', 1413419234, 44, 1413419234, 44),
(49, 1, '40', 'test', 'set', 1, 0, '', 1413507444, 44, 1413507587, 44);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ct_valuelist_lines_v`
--
CREATE TABLE IF NOT EXISTS `ct_valuelist_lines_v` (
`valuelist_name` varchar(20)
,`description` varchar(255)
,`object_flag` tinyint(4)
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
-- Structure for view `ct_function_objects_v`
--
DROP TABLE IF EXISTS `ct_function_objects_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_function_objects_v` AS select `fo`.`id` AS `id`,`fo`.`function_id` AS `function_id`,`fo`.`object_id` AS `object_id`,`fo`.`created_by` AS `created_by`,`fo`.`creation_date` AS `creation_date`,`fo`.`last_update_date` AS `last_update_date`,`fo`.`last_updated_by` AS `last_updated_by`,`ao`.`object_name` AS `object_name`,`ao`.`description` AS `description` from (`ct_function_objects` `fo` join `ct_authority_objects` `ao`) where (`ao`.`id` = `fo`.`object_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_function_obj_lines_v`
--
DROP TABLE IF EXISTS `ct_function_obj_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_function_obj_lines_v` AS select `fol`.`id` AS `id`,`fol`.`object_line_id` AS `object_line_id`,`fol`.`fun_object_id` AS `fun_object_id`,`fol`.`default_value` AS `default_value`,`fol`.`created_by` AS `created_by`,`fol`.`creation_date` AS `creation_date`,`fol`.`last_update_date` AS `last_update_date`,`fol`.`last_updated_by` AS `last_updated_by`,`fo`.`function_id` AS `function_id`,`fo`.`object_id` AS `object_id`,`fo`.`object_name` AS `object_name`,`fo`.`description` AS `object_desc`,`al`.`valuelist_id` AS `valuelist_id`,`al`.`auth_item_name` AS `auth_item_name`,`al`.`auth_item_desc` AS `auth_item_desc` from ((`ct_function_obj_lines` `fol` join `ct_function_objects_v` `fo`) join `ct_authobj_lines_v` `al`) where ((`fol`.`fun_object_id` = `fo`.`id`) and (`fol`.`object_line_id` = `al`.`id`));

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_messages_v` AS select `m`.`id` AS `id`,`m`.`class_id` AS `class_id`,`m`.`message_code` AS `message_code`,`m`.`content` AS `content`,`m`.`creation_date` AS `creation_date`,`m`.`created_by` AS `created_by`,`m`.`last_update_date` AS `last_update_date`,`m`.`last_updated_by` AS `last_updated_by`,`mc`.`class_code` AS `class_code`,`mc`.`description` AS `class_desc`,`m`.`language` AS `language` from (`ct_message_classes` `mc` join `ct_messages` `m`) where (`m`.`class_id` = `mc`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_module_lines_v`
--
DROP TABLE IF EXISTS `ct_module_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_module_lines_v` AS select `l`.`id` AS `id`,`l`.`module_id` AS `module_id`,`l`.`function_id` AS `function_id`,`l`.`sort` AS `sort`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by`,`h`.`module_name` AS `module_name`,`h`.`description` AS `module_desc`,`fn`.`function_name` AS `function_name`,`fn`.`description` AS `function_desc`,`h`.`sort` AS `module_sort`,`fn`.`controller` AS `controller`,`fn`.`action` AS `action`,`fn`.`display_flag` AS `display_flag`,`fn`.`display_class` AS `function_display_class`,`h`.`display_class` AS `module_display_class` from ((`ct_module_header` `h` join `ct_module_lines` `l`) join `ct_functions` `fn`) where ((`l`.`module_id` = `h`.`id`) and (`l`.`function_id` = `fn`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_module_line_objects_v`
--
DROP TABLE IF EXISTS `ct_module_line_objects_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_module_line_objects_v` AS select `ml`.`id` AS `id`,`ml`.`module_id` AS `module_id`,`ml`.`function_id` AS `function_id`,`ml`.`sort` AS `sort`,`ml`.`creation_date` AS `creation_date`,`ml`.`created_by` AS `created_by`,`ml`.`last_update_date` AS `last_update_date`,`ml`.`last_updated_by` AS `last_updated_by`,`ml`.`module_name` AS `module_name`,`ml`.`module_desc` AS `module_desc`,`ml`.`function_name` AS `function_name`,`ml`.`function_desc` AS `function_desc`,`ml`.`module_sort` AS `module_sort`,`ml`.`controller` AS `controller`,`ml`.`action` AS `action`,`ml`.`display_flag` AS `display_flag`,`ml`.`function_display_class` AS `function_display_class`,`ml`.`module_display_class` AS `module_display_class`,`fo`.`object_id` AS `object_id`,`fo`.`object_name` AS `object_name`,`fo`.`description` AS `object_desc` from (`ct_function_objects_v` `fo` join `ct_module_lines_v` `ml`) where (`ml`.`function_id` = `fo`.`function_id`);

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_order_logs_v` AS select `ol`.`id` AS `id`,`ol`.`order_id` AS `order_id`,`ol`.`log_type` AS `log_type`,`ol`.`new_value` AS `new_value`,`ol`.`old_value` AS `old_value`,`ol`.`reason` AS `reason`,`ol`.`change_hash` AS `change_hash`,`ol`.`creation_date` AS `creation_date`,`ol`.`created_by` AS `created_by`,`ol`.`last_update_date` AS `last_update_date`,`ol`.`last_updated_by` AS `last_updated_by`,`olt`.`description` AS `description`,`olt`.`title` AS `title`,`olt`.`content` AS `content`,`olt`.`need_reason_flag` AS `need_reason_flag`,`olt`.`field_name` AS `field_name`,`olt`.`dll_type` AS `dll_type`,`olt`.`field_valuelist_id` AS `field_valuelist_id` from (`ct_order_logs` `ol` join `ct_order_log_types` `olt`) where (`olt`.`log_type` = `ol`.`log_type`);

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
-- Structure for view `ct_role_profiles_v`
--
DROP TABLE IF EXISTS `ct_role_profiles_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_role_profiles_v` AS select `rp`.`id` AS `id`,`rp`.`role_id` AS `role_id`,`rp`.`object_id` AS `object_id`,`rp`.`creation_date` AS `creation_date`,`rp`.`created_by` AS `created_by`,`rp`.`last_update_date` AS `last_update_date`,`rp`.`last_updated_by` AS `last_updated_by`,`ao`.`object_name` AS `object_name`,`ao`.`description` AS `object_desc` from (`ct_role_profiles` `rp` join `ct_authority_objects` `ao`) where (`rp`.`object_id` = `ao`.`id`);

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
-- Structure for view `ct_tables_vl`
--
DROP TABLE IF EXISTS `ct_tables_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_tables_vl` AS select `information_schema`.`tables`.`TABLE_NAME` AS `value`,concat(`information_schema`.`tables`.`TABLE_NAME`,' - ',`information_schema`.`tables`.`TABLE_COMMENT`) AS `label` from `information_schema`.`tables` where (`information_schema`.`tables`.`TABLE_SCHEMA` = 'cts');

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
-- Structure for view `ct_user_roles_v`
--
DROP TABLE IF EXISTS `ct_user_roles_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_user_roles_v` AS select `u`.`id` AS `id`,`u`.`username` AS `username`,`u`.`password` AS `password`,`u`.`sex` AS `sex`,`u`.`contact` AS `contact`,`u`.`email` AS `email`,`u`.`phone_number` AS `phone_number`,`u`.`mobile_telephone` AS `mobile_telephone`,`u`.`address` AS `address`,`u`.`full_name` AS `full_name`,`u`.`inactive_flag` AS `inactive_flag`,`u`.`email_flag` AS `email_flag`,`u`.`sms_flag` AS `sms_flag`,`u`.`initial_pass_flag` AS `initial_pass_flag`,`u`.`created_by` AS `created_by`,`u`.`creation_date` AS `creation_date`,`u`.`last_update_date` AS `last_update_date`,`u`.`last_updated_by` AS `last_updated_by`,`r`.`role_name` AS `role_name`,`r`.`description` AS `role_desc`,`ur`.`role_id` AS `role_id`,`ur`.`user_id` AS `user_id` from ((`ct_user_roles` `ur` join `ct_users` `u`) join `ct_roles` `r`) where ((`u`.`id` = `ur`.`user_id`) and (`r`.`id` = `ur`.`role_id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_valuelist_header_vl`
--
DROP TABLE IF EXISTS `ct_valuelist_header_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_valuelist_header_vl` AS select `ct_valuelist_header`.`id` AS `value`,concat(`ct_valuelist_header`.`valuelist_name`,' - ',`ct_valuelist_header`.`description`) AS `label` from `ct_valuelist_header` where (`ct_valuelist_header`.`valuelist_name` like 'vl_%');

-- --------------------------------------------------------

--
-- Structure for view `ct_valuelist_lines_v`
--
DROP TABLE IF EXISTS `ct_valuelist_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_valuelist_lines_v` AS select `h`.`valuelist_name` AS `valuelist_name`,`h`.`description` AS `description`,`h`.`object_flag` AS `object_flag`,`h`.`label_fieldname` AS `label_fieldname`,`h`.`value_fieldname` AS `value_fieldname`,`h`.`source_view` AS `source_view`,`h`.`condition` AS `condition`,`h`.`parent_id` AS `parent_id`,`l`.`id` AS `id`,`l`.`valuelist_id` AS `valuelist_id`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc`,`l`.`inactive_flag` AS `inactive_flag`,`l`.`sort` AS `sort`,`l`.`parent_segment_value` AS `parent_segment`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by` from (`ct_valuelist_header` `h` join `ct_valuelist_lines` `l`) where (`h`.`id` = `l`.`valuelist_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_valuelist_vl`
--
DROP TABLE IF EXISTS `ct_valuelist_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_valuelist_vl` AS select `h`.`valuelist_name` AS `valuelist_name`,`h`.`description` AS `valuelist_desc`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc` from (`ct_valuelist_header` `h` join `ct_valuelist_lines` `l`) where ((`l`.`valuelist_id` = `h`.`id`) and (`l`.`inactive_flag` = 0));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
