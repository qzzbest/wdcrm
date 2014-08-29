-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 06 月 17 日 02:30
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wdcrm614`
--

-- --------------------------------------------------------

--
-- 表的结构 `crm_classroom_type`
--

CREATE TABLE IF NOT EXISTS `crm_classroom_type` (
  `classroom_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '班级类型ID',
  `classroom_type_name` varchar(250) DEFAULT NULL COMMENT '班级类型名称',
  PRIMARY KEY (`classroom_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='班级类型表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
