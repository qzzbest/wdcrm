-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 07 月 29 日 14:05
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wdcrm728`
--

-- --------------------------------------------------------

--
-- 表的结构 `crm_files`
--

CREATE TABLE IF NOT EXISTS `crm_files` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `file_url` text COMMENT '文件路径',
  `file_type` tinyint(4) DEFAULT NULL COMMENT '文件类型（1，常见问题，2，规章制度，3，学生简历）',
  `file_type_cate` tinyint(4) NOT NULL COMMENT '文件类型下的分类（1，问I题；2，答案）',
  `type_id` int(11) DEFAULT NULL COMMENT '文件对应的类型ID',
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文件存储表' AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `crm_files`
--

INSERT INTO `crm_files` (`file_id`, `file_url`, `file_type`, `file_type_cate`, `type_id`) VALUES
(10, './upload/answer/2014/07/29/2014072919574082537.jpg', 1, 2, NULL),
(9, './upload/question/2014/07/29/2014072919574061596.jpg', 1, 1, NULL),
(8, './upload/question/2014/07/29/2014072919574042316.jpg', 1, 1, NULL),
(20, './upload/question/2014/07/29/2014072921111463631.jpg', 1, 1, 11),
(18, './upload/answer/2014/07/29/2014072921100533614.jpg', 1, 2, 10),
(21, './upload/question/2014/07/29/2014072921111478274.jpg', 1, 1, 11);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
