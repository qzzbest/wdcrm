-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 08 月 23 日 00:17
-- 服务器版本: 5.1.46-community
-- PHP 版本: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wdcrm`
--

-- --------------------------------------------------------

--
-- 表的结构 `crm_upload_files`
--

CREATE TABLE IF NOT EXISTS `crm_upload_files` (
  `upload_file_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件上传ID',
  `file_name` varchar(100) NOT NULL COMMENT '上传文件名称',
  `file_size` varchar(20) NOT NULL COMMENT '文件大小',
  `file_path` varchar(255) NOT NULL COMMENT '上传文件路径',
  `upload_employee_id` int(11) DEFAULT NULL COMMENT '文件上传的员工ID',
  `upload_time` int(11) DEFAULT NULL COMMENT '文件上传的时间',
  `download_employee_id` int(11) DEFAULT NULL COMMENT '文件下载的员工ID',
  `download_time` int(11) DEFAULT NULL COMMENT '文件下载的时间',
  `download_number` int(10) unsigned NOT NULL COMMENT '下载次数',
  `file_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '文件状态（0，默认；1，上传成功；2，下载成功）',
  PRIMARY KEY (`upload_file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文件上传记录表' AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `crm_upload_files`
--

INSERT INTO `crm_upload_files` (`upload_file_id`, `file_name`, `file_size`, `file_path`, `upload_employee_id`, `upload_time`, `download_employee_id`, `download_time`, `download_number`, `file_status`) VALUES
(28, '中文 - 副本.doc', '9.5 KB', './upload/file/2014082223505910210.doc', 1, 1408722659, NULL, NULL, 0, 1),
(27, '渠道招生工作日志（7月8日）.xls', '172 KB', './upload/file/2014082223505945992.xls', 1, 1408722659, 1, 1408722665, 1, 2),
(26, '中文.doc', '9.5 KB', './upload/file/2014082223484662988.doc', 1, 1408722526, NULL, NULL, 0, 1),
(25, '中文 - 副本.doc', '9.5 KB', './upload/file/2014082223484699688.doc', 1, 1408722526, NULL, NULL, 0, 1),
(21, '渠道招生工作日志（7月8日）.xls', '172 KB', './upload/file/2014082223445955290.xls', 1, 1408722299, NULL, NULL, 0, 1),
(24, '渠道招生工作日志（7月8日）.xls', '172 KB', './upload/file/2014082223484645792.xls', 1, 1408722526, NULL, NULL, 0, 1),
(22, '中文 - 副本.doc', '9.5 KB', './upload/file/2014082223445946765.doc', 1, 1408722299, NULL, NULL, 0, 1),
(23, '中文.doc', '9.5 KB', './upload/file/2014082223445942634.doc', 1, 1408722299, 1, 1408722427, 1, 2),
(29, '中文.doc', '9.5 KB', './upload/file/2014082223505953595.doc', 1, 1408722659, NULL, NULL, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
