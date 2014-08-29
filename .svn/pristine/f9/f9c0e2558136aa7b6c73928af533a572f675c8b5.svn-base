-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 08 月 15 日 19:50
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
-- 表的结构 `crm_market`
--

CREATE TABLE IF NOT EXISTS `crm_market` (
  `market_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资源id',
  `employee_id` int(11) NOT NULL COMMENT '员工id',
  `login_date` int(11) NOT NULL COMMENT '登记日期',
  `school` varchar(50) NOT NULL COMMENT '机构、学校',
  `education` varchar(30) NOT NULL COMMENT '学历性质',
  `term` varchar(30) NOT NULL COMMENT '学期分配',
  `area` varchar(30) NOT NULL COMMENT '区域',
  `address` varchar(100) NOT NULL COMMENT '校区地址',
  `route` text NOT NULL COMMENT '乘车路线',
  `website` text NOT NULL COMMENT '学校介绍、网址',
  `show_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '虚拟删除，1为显示，0为不显示',
  PRIMARY KEY (`market_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='市场资源表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
