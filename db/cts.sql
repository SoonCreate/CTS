-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2014 at 10:57 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ct_authobj_lines`
--

INSERT INTO `ct_authobj_lines` (`id`, `object_id`, `valuelist_id`, `default_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(3, 1, 9, 'all', NULL, NULL, NULL, NULL),
(4, 1, 6, 'all', NULL, NULL, NULL, NULL),
(5, 1, 8, 'all', NULL, NULL, NULL, NULL);

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
(1, 'category_control', '订单控制权限对象1', NULL, NULL, 1411958674, -1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `ct_configs`
--

INSERT INTO `ct_configs` (`id`, `config_name`, `description`, `config_value`, `editable_flag`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'company_name', '公司名称', '浙江天正集团', 1, NULL, NULL, NULL, NULL),
(2, 'logo_file', 'Logo文件路径', '1', 1, NULL, NULL, NULL, NULL),
(3, 'upload_path', '上传公用文件夹', 'resources/uploads', 0, NULL, NULL, NULL, NULL),
(4, 'category_control', '投诉订单分类功能开关', '0', 1, NULL, NULL, NULL, NULL),
(5, 'all_values', '包含所有值', 'all', 0, NULL, NULL, NULL, NULL),
(6, 'alarm_period', '报警周期，每次报警的时间间隔，单位为小时', '24', 1, NULL, NULL, NULL, NULL),
(7, 'mail_protocol', 'mail, sendmail, or smtp 邮件发送协议', 'smtp', 1, NULL, NULL, NULL, NULL),
(8, 'sendmail_path', '服务器上 Sendmail 的实际路径。protocol 为 sendmail 时使用', '', 1, NULL, NULL, NULL, NULL),
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
(25, 'initial_password', '系统用户初始密码', '123456', 1, NULL, NULL, NULL, NULL);

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
-- Table structure for table `ct_functions`
--

CREATE TABLE IF NOT EXISTS `ct_functions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `function_name` (`function_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ct_module_header`
--

INSERT INTO `ct_module_header` (`id`, `module_name`, `description`, `sort`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(2, 'system_admin', '系统管理', 1, 1411885327, 0, 1411951422, -1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ct_module_lines`
--

INSERT INTO `ct_module_lines` (`id`, `module_id`, `function_id`, `sort`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(11, 2, 1, 0, 1411894480, -1, 1411894480, -1),
(12, 2, 2, 0, 1411976377, -1, 1411976377, -1);

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
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `company_name` varchar(255) DEFAULT NULL,
  `creation_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_type`,`status`,`manager_id`) USING BTREE,
  KEY `Index_3` (`created_by`,`creation_date`,`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Triggers `ct_orders`
--
DROP TRIGGER IF EXISTS `ct_orderlog_insert_t`;
DELIMITER //
CREATE TRIGGER `ct_orderlog_insert_t` AFTER INSERT ON `ct_orders`
 FOR EACH ROW insert into ct_order_logs
(order_id,log_type,new_value,creation_date,created_by,last_update_date,last_updated_by)
values(new.id,'stauts',new.status,new.creation_date,-1,new.last_update_date,-1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ct_orderlog_update_t`;
DELIMITER //
CREATE TRIGGER `ct_orderlog_update_t` AFTER UPDATE ON `ct_orders`
 FOR EACH ROW begin
	if new.status <> old.status then
        insert into ct_order_logs
(order_id,log_type,
new_value,old_value,creation_date,
created_by,last_update_date,
last_updated_by)
values(new.id,'stauts',
new.status,old.status,new.last_update_date,-1,
new.last_update_date,-1);
        end if;

	if new.manager_id <> old.manager_id then
        insert into ct_order_logs
(order_id,log_type,
new_value,old_value,creation_date,
created_by,last_update_date,
last_updated_by)
values(new.id,'manager',
new.manager_id,old.manager_id,new.last_update_date,-1,
new.last_update_date,-1);
        end if;
        
        if new.plan_complete_date <> old.plan_complete_date then
        insert into ct_order_logs
(order_id,log_type,
new_value,old_value,creation_date,
created_by,last_update_date,
last_updated_by)
values(new.id,'plan_complete_date',
new.plan_complete_date,old.plan_complete_date,new.last_update_date,-1,
new.last_update_date,-1);
        end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ct_order_addfiles`
--

CREATE TABLE IF NOT EXISTS `ct_order_addfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `file_name` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ct_role_profiles`
--

INSERT INTO `ct_role_profiles` (`id`, `role_id`, `object_id`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ct_role_profile_lines`
--

INSERT INTO `ct_role_profile_lines` (`id`, `profile_id`, `object_line_id`, `auth_value`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, 3, 'vender', NULL, NULL, NULL, NULL),
(2, 1, 4, 'all', NULL, NULL, NULL, NULL),
(3, 1, 5, 'all', NULL, NULL, NULL, NULL);

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_vl_line_01` (`status_id`,`segment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ct_status_lines`
--

INSERT INTO `ct_status_lines` (`id`, `status_id`, `segment`, `segment_value`, `segment_desc`, `next_status`, `back_status`, `default_flag`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 1, '10', 'released', '已提交', '20,50', NULL, 1, NULL, NULL, NULL, NULL),
(2, 1, '20', 'confirmed', '已确认', '30,50', NULL, 0, NULL, NULL, NULL, NULL),
(3, 1, '30', 'allocated', '已分配', '40,50', NULL, 0, NULL, NULL, NULL, NULL),
(4, 1, '40', 'done', '已解决', '50', NULL, 0, NULL, NULL, NULL, NULL),
(5, 1, '50', 'closed', '已关闭', '60', NULL, 0, NULL, NULL, NULL, NULL),
(6, 1, '60', 'reopen', '重新打开', '40,50', NULL, 0, NULL, NULL, NULL, NULL);

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
  `full_name` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `ct_users`
--

INSERT INTO `ct_users` (`id`, `username`, `password`, `contact`, `email`, `phone_number`, `mobile_telephone`, `address`, `full_name`, `inactive_flag`, `email_flag`, `sms_flag`, `initial_pass_flag`, `created_by`, `creation_date`, `last_update_date`, `last_updated_by`) VALUES
(1, 'yacole1', '111', '111', 'dsaf@gg.com', '1111', '123456', '薛宅', '陈杨阳', 0, 1, 0, 1, 0, 1411643732, 1411969571, -1),
(2, 'yyacole', 'b2a801fc1f6cdddb5df949c5126817cb5c8562ce', 'yy', 'yy@qq.com', 'yy', '1377777777', 'yy', 'yy', 0, 0, 0, 1, 0, 1411817141, 1411873607, 0),
(4, 'asfdasfd', '5122f516bc1a72641469c8970f15968403f5dbd4', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 1411824077, 1411873615, 0),
(5, 'dsfasfd', '7971ef9ebd79cb6af0826251759c108e3cafdd44', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411824134, 1411824134, 0),
(6, 'asfdas', '9e69c397d393aaf6e70a3bbaa1ca28ff4560306a', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411824220, 1411824220, 0),
(8, 'asdfasdfasfd', '9e69c397d393aaf6e70a3bbaa1ca28ff4560306a', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411824353, 1411824353, 0),
(34, 'asfdasdffff', 'ed70c57d7564e994e7d5f6fd6967cea8b347efbc', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411825930, 1411825930, 0),
(35, 'asdflaskl', 'ed70c57d7564e994e7d5f6fd6967cea8b347efbc', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411825963, 1411825963, 0),
(37, 'asdflaskldsf', 'ed70c57d7564e994e7d5f6fd6967cea8b347efbc', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411826157, 1411826157, 0),
(39, 'asfdfff', 'dde93f95d664df0c518e10bff196d9111e30e7ad', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411826432, 1411826432, 0),
(40, 'asfdffff', 'dde93f95d664df0c518e10bff196d9111e30e7ad', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411826457, 1411826457, 0),
(41, 'asfdfffff', 'dde93f95d664df0c518e10bff196d9111e30e7ad', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411826496, 1411826496, 0),
(42, 'asfdfffffd', 'dde93f95d664df0c518e10bff196d9111e30e7ad', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1411826529, 1411826529, 0),
(43, 'asdfsadfaa', '3da541559918a808c2402bba5012f6c60b27661c', 'asdf', NULL, NULL, '123445', NULL, NULL, 0, 0, 0, 1, 0, 1411868974, 1411868974, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

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
(11, 1, 1, 1411892389, 1, 1411892389, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ct_valuelist_header`
--

INSERT INTO `ct_valuelist_header` (`id`, `valuelist_name`, `description`, `from_obj`, `label_fieldname`, `value_fieldname`, `source_view`, `condition`, `parent_id`, `editable_flag`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(1, 'vl_order_type', '投诉订单类型', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(2, 'vl_severity', '严重程度', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(3, 'vl_priority', '优先级', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(4, 'vl_frequency', '发生频率', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(5, 'vl_log_type', '订单日志类型', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(6, 'ao_order_status', '订单状态权限对象', 1, 'segment_desc', 'segment_value', 'ct_order_status_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(7, 'vl_order_category', '订单分类', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(8, 'ao_order_category', '订单分类权限对象', 1, 'segment_desc', 'segment_value', 'ct_order_category_vl', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(9, 'ao_order_type', '订单类型权限对象', 1, 'segment_desc', 'segment_value', 'ct_valuelist_vl', 'valuelist_name = ''vl_order_type''', NULL, 1, NULL, NULL, NULL, NULL),
(10, 'order_default_role', '订单类型默认角色', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);

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
  `parent_segment` varchar(20) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_vl_line_01` (`valuelist_id`,`segment`,`parent_segment`) USING BTREE,
  KEY `Index_3` (`valuelist_id`,`parent_segment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `ct_valuelist_lines`
--

INSERT INTO `ct_valuelist_lines` (`id`, `valuelist_id`, `segment`, `segment_value`, `segment_desc`, `inactive_flag`, `sort`, `parent_segment`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
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
(13, 5, '10', 'status', '状态变更', 0, 0, '0', NULL, NULL, NULL, NULL),
(14, 5, '20', 'plan_complete_date', '计划完成时间变更', 0, 0, '0', NULL, NULL, NULL, NULL),
(15, 5, '30', 'manager', '责任人变更', 0, 0, '0', NULL, NULL, NULL, NULL),
(16, 7, '10', '10', '供应商投诉分类一', 0, 0, '10', NULL, NULL, NULL, NULL),
(17, 5, '40', 'plan_complete_date', '计划完成日期修改', 0, 0, NULL, NULL, NULL, NULL, NULL),
(18, 10, '10', 'reporter_vender', '默认供应商投诉角色', 0, 0, '10', NULL, NULL, NULL, NULL),
(21, 10, '10', 'reporter_customer', '默认客户投诉角色', 0, 0, '30', NULL, NULL, NULL, NULL),
(22, 10, '10', 'reporter_employee', '默认员工投诉角色', 0, 0, '20', NULL, NULL, NULL, NULL);

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
-- Structure for view `ct_messages_v`
--
DROP TABLE IF EXISTS `ct_messages_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_messages_v` AS select `m`.`id` AS `id`,`m`.`class_id` AS `class_id`,`m`.`message_code` AS `message_code`,`m`.`content` AS `content`,`m`.`creation_date` AS `creation_date`,`m`.`created_by` AS `created_by`,`m`.`last_update_date` AS `last_update_date`,`m`.`last_updated_by` AS `last_updated_by`,`mc`.`class_code` AS `class_code`,`mc`.`description` AS `class_desc` from (`ct_message_classes` `mc` join `ct_messages` `m`) where (`m`.`class_id` = `mc`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_module_lines_v`
--
DROP TABLE IF EXISTS `ct_module_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_module_lines_v` AS select `l`.`id` AS `id`,`l`.`module_id` AS `module_id`,`l`.`function_id` AS `function_id`,`l`.`sort` AS `sort`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by`,`h`.`module_name` AS `module_name`,`h`.`description` AS `module_desc`,`fn`.`function_name` AS `function_name`,`fn`.`description` AS `function_desc` from ((`ct_module_header` `h` join `ct_module_lines` `l`) join `ct_functions` `fn`) where ((`l`.`module_id` = `h`.`id`) and (`l`.`function_id` = `fn`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_order_category_vl`
--
DROP TABLE IF EXISTS `ct_order_category_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_order_category_vl` AS select concat(`pl`.`segment_desc`,' : ',`cl`.`segment_desc`) AS `segment_desc`,`cl`.`segment_value` AS `segment_value` from ((`ct_valuelist_header` `c` join `ct_valuelist_lines` `cl`) join `ct_valuelist_lines` `pl`) where ((`cl`.`valuelist_id` = `c`.`id`) and (`c`.`valuelist_name` = 'vl_order_category') and (`pl`.`segment` = `cl`.`parent_segment`) and (`pl`.`inactive_flag` = 0) and (`cl`.`inactive_flag` = 0));

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_role_module_lines_v` AS select `l`.`id` AS `role_module_line_id`,`l`.`role_id` AS `role_id`,`ml`.`id` AS `id`,`ml`.`module_id` AS `module_id`,`ml`.`function_id` AS `function_id`,`ml`.`sort` AS `sort`,`ml`.`creation_date` AS `creation_date`,`ml`.`created_by` AS `created_by`,`ml`.`last_update_date` AS `last_update_date`,`ml`.`last_updated_by` AS `last_updated_by`,`ml`.`module_name` AS `module_name`,`ml`.`module_desc` AS `module_desc`,`ml`.`function_name` AS `function_name`,`ml`.`function_desc` AS `function_desc` from (`ct_role_module_lines` `l` join `ct_module_lines_v` `ml`) where (`l`.`module_line_id` = `ml`.`id`);

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_status_lines_v` AS select `h`.`status_code` AS `status_code`,`h`.`description` AS `description`,`l`.`id` AS `id`,`l`.`status_id` AS `status_id`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc`,`l`.`next_status` AS `next_status`,`l`.`back_status` AS `back_status`,`l`.`default_flag` AS `default_flag`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by` from (`ct_status_header` `h` join `ct_status_lines` `l`) where (`h`.`id` = `l`.`status_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_user_auth_v`
--
DROP TABLE IF EXISTS `ct_user_auth_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_user_auth_v` AS select `ur`.`role_id` AS `role_id`,`ao`.`object_name` AS `object_name`,`ao`.`description` AS `description`,`ur`.`user_id` AS `user_id`,`rp`.`id` AS `profile_id` from ((`ct_user_roles` `ur` join `ct_role_profiles` `rp`) join `ct_authority_objects` `ao`) where ((`ur`.`role_id` = `rp`.`role_id`) and (`rp`.`object_id` = `ao`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `ct_valuelist_lines_v`
--
DROP TABLE IF EXISTS `ct_valuelist_lines_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_valuelist_lines_v` AS select `h`.`valuelist_name` AS `valuelist_name`,`h`.`description` AS `description`,`h`.`from_obj` AS `from_obj`,`h`.`label_fieldname` AS `label_fieldname`,`h`.`value_fieldname` AS `value_fieldname`,`h`.`source_view` AS `source_view`,`h`.`condition` AS `condition`,`h`.`parent_id` AS `parent_id`,`l`.`id` AS `id`,`l`.`valuelist_id` AS `valuelist_id`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc`,`l`.`inactive_flag` AS `inactive_flag`,`l`.`sort` AS `sort`,`l`.`parent_segment` AS `parent_segment`,`l`.`creation_date` AS `creation_date`,`l`.`created_by` AS `created_by`,`l`.`last_update_date` AS `last_update_date`,`l`.`last_updated_by` AS `last_updated_by` from (`ct_valuelist_header` `h` join `ct_valuelist_lines` `l`) where (`h`.`id` = `l`.`valuelist_id`);

-- --------------------------------------------------------

--
-- Structure for view `ct_valuelist_vl`
--
DROP TABLE IF EXISTS `ct_valuelist_vl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ct_valuelist_vl` AS select `h`.`valuelist_name` AS `valuelist_name`,`h`.`description` AS `valuelist_desc`,`l`.`segment` AS `segment`,`l`.`segment_value` AS `segment_value`,`l`.`segment_desc` AS `segment_desc` from (`ct_valuelist_header` `h` join `ct_valuelist_lines` `l`) where ((`l`.`valuelist_id` = `h`.`id`) and (`l`.`inactive_flag` = 0));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
